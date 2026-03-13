
@include('admin.header')
@include('admin.navbar')
<!-- Content wrapper start -->
					<div class="content-wrapper">
    <!-- User Profile Header -->
    <div class="row gx-3 mb-4">
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="position-relative">
                        @if($userProfile->user_status==="0")
                            <a href="{{route('admin.verify_user',$userProfile->id)}}" class="btn btn-success btn-sm position-absolute top-0 end-0 m-2">
                                <i class="bi bi-unlock"></i> Unfreeze
                            </a>
                        @elseif($userProfile->user_status==="1")
                            <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" data-bs-toggle="modal" data-bs-target="#editContact">
                                <i class="bi bi-lock"></i> Freeze
                            </a>
                        @endif
                        
                        <img src="{{ asset('uploads/display/' . ($userProfile->display_picture ? $userProfile->display_picture : 'avatar.jpg')) }}" 
                             alt="User Avatar" class="rounded-circle mb-3" width="150" height="150">
                        <h4 class="mb-3">{{$userProfile->first_name}} {{$userProfile->last_name}}</h4>
                        
                        <div class="d-flex justify-content-center mb-3">
                            <span class="badge bg-{{$userProfile->user_status==='0' ? 'success' : 'danger'}} me-2">
                                {{$userProfile->user_status==="0" ? 'Active' : 'Frozen'}}
                            </span>
                            <span class="badge bg-{{$userProfile->user_block==='0' ? 'success' : 'danger'}} me-2">
                                {{$userProfile->user_block==="0" ? 'Unblocked' : 'Blocked'}}
                            </span>
                            <span class="badge bg-{{$userProfile->user_activity==='0' ? 'danger' : 'warning'}}">
                                {{$userProfile->user_activity==="0" ? 'ML Deactivated' : 'ML Activated'}}
                            </span> 
                        </div>
                    </div>
                    
                    <!-- Financial Summary - At Top -->
                    <div class="row g-2 text-center mb-3">
                        <div class="col-6">
                            <div class="bg-success rounded p-2">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($balance, 2)}}</div>
                                <small class="text-white fw-semibold">Balance</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-primary rounded p-2">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($user_deposits, 2)}}</div>
                                <small class="text-white fw-semibold">Deposits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info rounded p-2">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($credit_transfers, 2)}}</div>
                                <small class="text-white fw-semibold">Credits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-danger rounded p-2">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($debit_transfers, 2)}}</div>
                                <small class="text-white fw-semibold">Debits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded p-2" style="background-color: #fd7e14;">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($user_loans, 2)}}</div>
                                <small class="text-white fw-semibold">Loans</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-dark rounded p-2">
                                <div class="text-white fw-bold fs-5">{{$userProfile->currency}}{{number_format($user_card, 2)}}</div>
                                <small class="text-white fw-semibold">Card Withdrawals</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-2">
                    <div class="text-start">
                        <p><strong><i class="bi bi-envelope me-2"></i>Email:</strong> {{$userProfile->email}}</p>
                        <p><strong><i class="bi bi-credit-card me-2"></i>Account #:</strong> {{$userProfile->a_number}}</p>
                        <p><strong><i class="bi bi-key me-2"></i>Account Pin:</strong> {{$userProfile->account_pin}}</p>
                        <p><strong><i class="bi bi-phone me-2"></i>Phone:</strong> {{$userProfile->phone_number}}</p>
                        <p><strong><i class="bi bi-globe me-2"></i>Country:</strong> {{$userProfile->country}}</p>
                        {{-- <p><strong><i class="bi bi-shield-lock me-2"></i>TAC Code:</strong> {{$userProfile->otp}}</p> --}}
                        <p><strong><i class="bi bi-cash-stack me-2"></i>Loan Eligibility:</strong> {{$userProfile->currency}}{{number_format($userProfile->eligible_loan, 2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <!-- Account Actions -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Account Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{route('admin.verify_user',$userProfile->id)}}" class="btn btn-outline-success">
                                    <i class="bi bi-unlock"></i> Freeze Account
                                </a>
                                <a href="{{route('admin.unfreeze_user',$userProfile->id)}}" class="btn btn-outline-danger">
                                    <i class="bi bi-lock"></i> Unfreeze Account
                                </a>
                                <a href="{{route('admin.user_block',$userProfile->id)}}" class="btn btn-outline-warning">
                                    <i class="bi bi-person-x"></i> Block User
                                </a>
                                <a href="{{route('admin.iuser_block',$userProfile->id)}}" class="btn btn-outline-info">
                                    <i class="bi bi-person-check"></i> Unblock User
                                </a>
                                <a href="{{route('admin.access_account',$userProfile->id)}}" class="btn btn-dark">
                                    <i class="bi bi-person-video3"></i> Access Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Financial Actions -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Financial Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                    <i class="bi bi-plus-circle"></i> Credit Account
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">
                                    <i class="bi bi-dash-circle"></i> Debit Account
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter3">
                                    <i class="bi bi-currency-dollar"></i> Update Loan Limit
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter9">
                                    <i class="bi bi-shield-lock"></i> Update TAC Code
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Security Actions -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Security Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{route('admin.user_activity',$userProfile->id)}}" class="btn btn-outline-warning">
                                    <i class="bi bi-activity"></i> Activate ML Monitoring
                                </a>
                                <a href="{{route('admin.iuser_activity',$userProfile->id)}}" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye-slash"></i> Deactivate ML Monitoring
                                </a>
                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModalCenter99">
                                    <i class="bi bi-envelope"></i> Update Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Delivery Information -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Delivery Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{$userProfile->fname}}</p>
                            <p><strong>Address:</strong> {{$userProfile->delivery_address}}</p>
                            <p><strong>Phone:</strong> {{$userProfile->delivery_phone}}</p>
                            <p><strong>Email:</strong> {{$userProfile->emailAddress}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modals -->
    <!-- Credit Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Credit {{$userProfile->first_name}}'s Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.credit.user')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="email" value="{{$userProfile->email}}"/>
                        <input type="hidden" name="name" value="{{$userProfile->first_name}} {{$userProfile->last_name}}"/>
                        <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                        <input type="hidden" name="balance" value="{{$balance}}"/>
                        <input type="hidden" name="a_number" value="{{$userProfile->a_number}}"/>
                        <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                        
                        <div class="mb-3">
                            <label class="form-label">Amount ({{$userProfile->currency}})</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="Enter Amount" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" name="sender_name" class="form-control" placeholder="Enter sender's full name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sender Account Number</label>
                            <input type="text" name="sender_account" class="form-control" placeholder="Enter sender's account number" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Enter sender's bank name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Transaction Date</label>
                            <input type="datetime-local" name="transaction_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Credit Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Debit Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Debit {{$userProfile->first_name}}'s Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.debit.user')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="email" value="{{$userProfile->email}}"/>
                        <input type="hidden" name="name" value="{{$userProfile->first_name}} {{$userProfile->last_name}}"/>
                        <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                        <input type="hidden" name="balance" value="{{$balance}}"/>
                        <input type="hidden" name="a_number" value="{{$userProfile->a_number}}"/>
                        <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                        
                        <div class="mb-3">
                            <label class="form-label">Amount ({{$userProfile->currency}})</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="Enter Amount" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Debit Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Loan Eligibility Modal -->
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Update Loan Eligibility</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.update.eligible',$userProfile->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                        <div class="mb-3">
                            <label class="form-label">New Loan Eligibility Amount ({{$userProfile->currency}})</label>
                            <input type="number" name="eligible_loan" class="form-control" value="{{$userProfile->eligible_loan}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Limit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- TAC Code Modal -->
    <div class="modal fade" id="exampleModalCenter9" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Update TAC Code</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.update.otp',$userProfile->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                        <div class="mb-3">
                            <label class="form-label">New TAC Code</label>
                            <input type="number" name="otp" class="form-control" value="{{$userProfile->otp}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update TAC Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Email Update Modal -->
    <div class="modal fade" id="exampleModalCenter99" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Update Email Address</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.update.email',$userProfile->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                        <div class="mb-3">
                            <label class="form-label">New Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{$userProfile->email}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Update Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Tab Navigation -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab">
                        <i class="bi bi-list-check me-1"></i> Transactions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button" role="tab">
                        <i class="bi bi-cash-stack me-1"></i> Deposits
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab">
                        <i class="bi bi-currency-exchange me-1"></i> Loans
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kyc-tab" data-bs-toggle="tab" data-bs-target="#kyc" type="button" role="tab">
                        <i class="bi bi-person-badge me-1"></i> KYC
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cards-tab" data-bs-toggle="tab" data-bs-target="#cards" type="button" role="tab">
                        <i class="bi bi-credit-card me-1"></i> Cards
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0 rounded-bottom shadow-sm" id="myTabContent">
                <!-- Transactions Tab -->
                <div class="tab-pane fade show active" id="transactions" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->transaction_ref}}</td>
                                    <td>{{$transaction->transaction_type}}</td>
                                    <td>{{$transaction->transaction_description}}</td>
                                    <td>{{$userProfile->currency}}{{number_format($transaction->transaction_amount, 2)}}</td>
                                    <td>
                                        @if ($transaction->transaction_status == '1')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($transaction->transaction_status == '0')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($transaction->transaction_status == '2')
                                        <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.update-transaction-date', $transaction->id) }}" method="POST" class="d-flex">
    @csrf
    <input type="datetime-local" name="new_date" value="{{ $transaction->created_at->format('Y-m-d\TH:i') }}" class="form-control form-control-sm me-2">
    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
</form>

                                    </td>
                                    <td class="d-flex">
                                        <form action="{{route('admin.approve-transaction', $transaction->id)}}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="transaction_status" value="1">
                                            <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
                                            <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{route('admin.decline-transaction', $transaction->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="transaction_status" value="2">
                                            <input type="hidden" name="user_id" value="{{$transaction->user_id}}">
                                            <input type="hidden" name="email" value="{{$transaction->email}}">
                                            <input type="hidden" name="amount" value="{{$transaction->amount}}">
                                            <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Deposits Tab -->
                <div class="tab-pane fade" id="deposits" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userdeposits as $deposit)
                                <tr>
                                    <td>{{$deposit->id}}</td>
                                    <td>{{$userProfile->currency}}{{number_format($deposit->amount, 2)}}</td>
                                    <td>{{$deposit->deposit_type}}</td>
                                    <td>
                                        <a href="{{asset('uploads/cheque/'.$deposit->front_cheque)}}" data-lightbox="deposit-{{$deposit->id}}">
                                            <img src="{{asset('uploads/cheque/'.$deposit->front_cheque)}}" width="50">
                                        </a>
                                    </td>
                                    <td>
                                        @if ($deposit->status == '1')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($deposit->status == '0')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($deposit->status == '2')
                                        <span class="badge bg-danger">Declined</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('D, M j, Y g:i A') }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('admin.approve-deposit', $deposit->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.decline-deposit', $deposit->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Loans Tab -->
                <div class="tab-pane fade" id="loans" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Documents</th>
                                    <th>SSN</th>
                                    <th>Credit Score</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loan as $loan)
                                <tr>
                                    <td>{{$loan->id}}</td>
                                    <td>{{$userProfile->currency}}{{number_format($loan->amount, 2)}}</td>
                                    <td>{{$loan->reason}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                                View Documents
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{asset('uploads/loan/'.$loan->license)}}" target="_blank">License</a>
                                                <a class="dropdown-item" href="{{asset('uploads/loan/'.$loan->photoID)}}" target="_blank">Photo ID</a>
                                                <a class="dropdown-item" href="{{asset('uploads/loan/'.$loan->selfie)}}" target="_blank">Selfie</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$loan->ssn}}</td>
                                    <td>{{$loan->credit_score}}</td>
                                    <td>
                                        @if ($loan->status == '1')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($loan->status == '0')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($loan->status == '2')
                                        <span class="badge bg-danger">Declined</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($loan->created_at)->format('D, M j, Y g:i A') }}</td>
                                    <td class="d-flex">
                                        <form action="{{route('admin.approve-loan', $loan->id)}}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$loan->amount}}">
                                            <input type="hidden" name="reason" value="{{$loan->reason}}">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{route('admin.decline-loan', $loan->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$loan->amount}}">
                                            <input type="hidden" name="reason" value="{{$loan->reason}}">
                                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- KYC Tab -->
                <div class="tab-pane fade" id="kyc" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    Driver's License
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{asset('uploads/kyc/'.$userProfile->driver_license)}}" data-lightbox="kyc-docs">
                                        <img src="{{asset('uploads/kyc/'.$userProfile->driver_license)}}" class="img-fluid mb-3" style="max-height: 200px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    Residence ID Card
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{asset('uploads/kyc/'.$userProfile->id_card)}}" data-lightbox="kyc-docs">
                                        <img src="{{asset('uploads/kyc/'.$userProfile->id_card)}}" class="img-fluid mb-3" style="max-height: 200px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    Passport
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{asset('uploads/kyc/'.$userProfile->passport)}}" data-lightbox="kyc-docs">
                                        <img src="{{asset('uploads/kyc/'.$userProfile->passport)}}" class="img-fluid mb-3" style="max-height: 200px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-body text-center">
                            <h5 class="mb-3">KYC Status: 
                                @if($userProfile->kyc_status=='0')
                                <span class="badge bg-warning">Pending</span>
                                @elseif($userProfile->kyc_status=='1')
                                <span class="badge bg-success">Approved</span>
                                @elseif($userProfile->kyc_status=='2')
                                <span class="badge bg-danger">Declined</span>
                                @endif
                            </h5>
                            
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('admin.accept-kyc', $userProfile->id) }}" method="POST" class="me-3">
                                    @csrf
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="bi bi-check-circle me-2"></i>Approve KYC
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.decline-kyc', $userProfile->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="2">
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="bi bi-x-circle me-2"></i>Decline KYC
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cards Tab -->
                <div class="tab-pane fade" id="cards" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Card Number</th>
                                    <th>CVC</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usercards as $cards)
                                <tr>
                                    <td>{{$cards->card_number}}</td>
                                    <td>{{$cards->card_cvc}}</td>
                                    <td>
                                        @if ($cards->status == '1')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($cards->status == '0')
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($cards->status == '2')
                                        <span class="badge bg-danger">Declined</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cards->created_at)->format('D, M j, Y g:i A') }}</td>
                                    <td class="d-flex">
                                        <form action="{{route('admin.approve-card', $cards->id)}}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$cards->amount}}">
                                            <input type="hidden" name="card_number" value="{{$cards->card_number}}">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{route('admin.decline-card',$cards->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$cards->amount}}">
                                            <input type="hidden" name="card_number" value="{{$cards->card_number}}">
                                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add lightbox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<!-- Add lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<style>
    .contact-avatar {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .card-cover {
        transition: all 0.3s ease;
    }
    
    .card-cover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .nav-tabs .nav-link {
        font-weight: 500;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    @media (max-width: 768px) {
        .d-flex {
            flex-direction: column;
        }
        
        .d-flex form {
            margin-bottom: 5px;
            width: 100%;
        }
        
        .d-flex form button {
            width: 100%;
        }
    }
</style>

				

				@include('admin.footer')