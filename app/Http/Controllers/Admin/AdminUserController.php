<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('websites')->latest()->paginate(20);
        return view('admin.manage_users', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('websites');
        $user->load(['websites.testimonials']);
        $testimonials = \App\Models\Testimonial::forUser($user->id)->with('website')->latest()->get();
        return view('admin.user_show', compact('user', 'testimonials'));
    }

    public function edit(User $user)
    {
        return view('admin.user_edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'website_limit' => ['required', 'integer', 'min:1'],
        ]);
        $user->update($data);
        return redirect()->route('admin.users.show', $user)->with('message', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('message', 'User "' . $user->name . '" has been deleted.');
    }

    public function emailForm(User $user)
    {
        return view('admin.user_email', compact('user'));
    }

    public function sendEmail(Request $request, User $user)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        Mail::raw($request->body, function ($message) use ($user, $request) {
            $message->to($user->email)
                    ->subject($request->subject);
        });

        return redirect()->route('admin.users')->with('message', 'Email sent to ' . $user->email . '.');
    }

    public function impersonate(User $user)
    {
        // Store admin identity so we can restore it later
        session([
            'impersonating_admin_id' => Auth::guard('admin')->id(),
            'impersonated_user_id'   => $user->id,
        ]);

        Auth::guard('admin')->logout();
        Auth::login($user);

        return redirect()->route('dashboard.index');
    }

    public function stopImpersonating()
    {
        $adminId = session('impersonating_admin_id');
        $userId  = session('impersonated_user_id');

        if (!$adminId) {
            return redirect()->route('home');
        }

        Auth::logout();
        Auth::guard('admin')->loginUsingId($adminId);

        session()->forget(['impersonating_admin_id', 'impersonated_user_id']);

        return redirect()->route('admin.users.show', $userId)
            ->with('message', 'Impersonation ended. You are back as admin.');
    }
}
