<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = [
            [
                'user' => [
                    'business_name' => 'TechCorp Solutions',
                    'name'          => 'James Davidson',
                    'email'         => 'james@techcorpsolutions.com',
                    'website_url'   => 'https://techcorpsolutions.com',
                ],
                'website' => [
                    'name'        => 'TechCorp Solutions',
                    'url'         => 'https://techcorpsolutions.com',
                    'description' => 'Enterprise software solutions and IT consulting for businesses of all sizes.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'James Davidson',
                        'author_email' => 'james@techcorpsolutions.com',
                        'author_role'  => 'CEO',
                        'content'      => 'TrustCredNet transformed our reputation strategy. Our conversion rate jumped 38% within two months of launching our review widget.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Linda Torres',
                        'author_email' => 'linda@client.com',
                        'author_role'  => 'Product Manager',
                        'content'      => 'Outstanding software delivery and professional team. Highly recommended for any enterprise project.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Daniel Kim',
                        'author_email' => 'daniel@client.com',
                        'author_role'  => 'CTO',
                        'content'      => 'Best IT consulting firm we have worked with. They delivered on time and exceeded expectations.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'HealthFirst',
                    'name'          => 'Dr. Aisha Patel',
                    'email'         => 'aisha@healthfirst.com',
                    'website_url'   => 'https://healthfirst.com',
                ],
                'website' => [
                    'name'        => 'HealthFirst',
                    'url'         => 'https://healthfirst.com',
                    'description' => 'Comprehensive healthcare services and wellness programs for individuals and families.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Maria Johnson',
                        'author_email' => 'maria.j@email.com',
                        'author_role'  => 'Patient',
                        'content'      => 'HealthFirst completely changed my approach to wellness. The doctors are attentive, caring, and truly listen.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Robert Chen',
                        'author_email' => 'rchen@email.com',
                        'author_role'  => 'Patient',
                        'content'      => 'Incredible care and professionalism. I have been a patient for two years and would not go anywhere else.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Fatima Al-Rashid',
                        'author_email' => 'fatima@email.com',
                        'author_role'  => 'Patient',
                        'content'      => 'The wellness programs are life-changing. Lost 20 lbs and feel better than I have in a decade.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'GreenLeaf',
                    'name'          => 'Sarah Mitchell',
                    'email'         => 'sarah@greenleaf.com',
                    'website_url'   => 'https://greenleaf.com',
                ],
                'website' => [
                    'name'        => 'GreenLeaf',
                    'url'         => 'https://greenleaf.com',
                    'description' => 'Organic and sustainable products for a healthier planet and a healthier you.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Sarah Mitchell',
                        'author_email' => 'sarah@greenleaf.com',
                        'author_role'  => 'Marketing Director',
                        'content'      => 'We had no idea how powerful social proof could be. After 3 months, our Google Ads ROAS doubled. The embed widget is insanely easy to use.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Tom Yates',
                        'author_email' => 'tom@email.com',
                        'author_role'  => 'Customer',
                        'content'      => 'Absolutely love the sustainable packaging and the product quality is second to none.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Claire Hudson',
                        'author_email' => 'claire@email.com',
                        'author_role'  => 'Customer',
                        'content'      => 'Switched to GreenLeaf six months ago and have not looked back. Planet-friendly and wallet-friendly.',
                        'rating'       => 4,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'GrowthLabs',
                    'name'          => 'Marcus Webb',
                    'email'         => 'marcus@growthlabs.io',
                    'website_url'   => 'https://growthlabs.io',
                ],
                'website' => [
                    'name'        => 'GrowthLabs',
                    'url'         => 'https://growthlabs.io',
                    'description' => 'Data-driven digital marketing and growth hacking strategies for scaling startups and SMEs.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Priya Sharma',
                        'author_email' => 'priya@startup.com',
                        'author_role'  => 'Founder',
                        'content'      => 'GrowthLabs took our MRR from $10k to $80k in under six months. The team is brilliant.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Oliver Barnes',
                        'author_email' => 'oliver@sme.com',
                        'author_role'  => 'CEO',
                        'content'      => 'Best marketing investment we have ever made. ROI was evident within the first 30 days.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Yuki Tanaka',
                        'author_email' => 'yuki@tech.com',
                        'author_role'  => 'Head of Growth',
                        'content'      => 'Rigorous data analysis and creative strategies. They helped us crack our CAC problem.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'LexPro Legal',
                    'name'          => 'Alex Lee',
                    'email'         => 'alex@lexprolegal.com',
                    'website_url'   => 'https://lexprolegal.com',
                ],
                'website' => [
                    'name'        => 'LexPro Legal',
                    'url'         => 'https://lexprolegal.com',
                    'description' => 'Expert legal services in corporate law, contracts, intellectual property, and dispute resolution.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Alex Lee',
                        'author_email' => 'alex@lexprolegal.com',
                        'author_role'  => 'Partner',
                        'content'      => 'The fraud detection is a game-changer. We went from dealing with 12 fake reviews a month to zero. The Verified badge has boosted client trust significantly.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Sandra O\'Brien',
                        'author_email' => 'sandra@corp.com',
                        'author_role'  => 'General Counsel',
                        'content'      => 'LexPro handled our IP portfolio flawlessly. Responsive, knowledgeable, and truly strategic.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Wei Zhang',
                        'author_email' => 'wei@startup.io',
                        'author_role'  => 'Founder',
                        'content'      => 'Exceptional contract review service. Saved us from a clause that could have cost us six figures.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'FitZone',
                    'name'          => 'Riya Kapoor',
                    'email'         => 'riya@fitzone.com',
                    'website_url'   => 'https://fitzone.com',
                ],
                'website' => [
                    'name'        => 'FitZone',
                    'url'         => 'https://fitzone.com',
                    'description' => 'Premium fitness centres and online coaching programs to help you reach your peak performance.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Riya Kapoor',
                        'author_email' => 'riya@fitzone.com',
                        'author_role'  => 'Operations Lead',
                        'content'      => 'Managing reviews used to take 3 hours a week across 5 platforms. Now it takes 20 minutes in TrustCredNet. The analytics alone are worth it.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Jake Morales',
                        'author_email' => 'jake@email.com',
                        'author_role'  => 'Member',
                        'content'      => 'Best gym I have ever joined. The coaching is personalised and the facilities are top-notch.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Nina Brown',
                        'author_email' => 'nina@email.com',
                        'author_role'  => 'Member',
                        'content'      => 'Lost 15kg with FitZone in four months. The trainers are motivating and truly care about your progress.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'HomeCraft',
                    'name'          => 'Emily Turner',
                    'email'         => 'emily@homecraft.com',
                    'website_url'   => 'https://homecraft.com',
                ],
                'website' => [
                    'name'        => 'HomeCraft',
                    'url'         => 'https://homecraft.com',
                    'description' => 'Interior design, home renovation, and bespoke furniture crafted to transform your living space.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Greg Patterson',
                        'author_email' => 'greg@email.com',
                        'author_role'  => 'Homeowner',
                        'content'      => 'HomeCraft renovated our kitchen and it looks like something out of a magazine. Truly stunning work.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Alicia Ford',
                        'author_email' => 'alicia@email.com',
                        'author_role'  => 'Interior Design Client',
                        'content'      => 'They brought our vision to life perfectly. Every detail was thoughtfully considered.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Ben Nguyen',
                        'author_email' => 'ben@email.com',
                        'author_role'  => 'Homeowner',
                        'content'      => 'Punctual, professional, and incredibly skilled craftsmen. Our home has never looked better.',
                        'rating'       => 4,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'FinancePro',
                    'name'          => 'David Okafor',
                    'email'         => 'david@financepro.com',
                    'website_url'   => 'https://financepro.com',
                ],
                'website' => [
                    'name'        => 'FinancePro',
                    'url'         => 'https://financepro.com',
                    'description' => 'Independent financial planning, investment advice, and tax optimisation for individuals and businesses.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Rachel Stone',
                        'author_email' => 'rachel@email.com',
                        'author_role'  => 'Client',
                        'content'      => 'FinancePro helped me plan my retirement properly. Clear, honest advice with no hidden fees.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Chris Adeyemi',
                        'author_email' => 'chris@email.com',
                        'author_role'  => 'Business Owner',
                        'content'      => 'Our tax bill dropped by 30% after working with FinancePro. Exceptional service throughout.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Laura Singh',
                        'author_email' => 'laura@email.com',
                        'author_role'  => 'Investor',
                        'content'      => 'Portfolio is up 22% YoY thanks to their investment strategy. Would not trust anyone else.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'PixelStudio',
                    'name'          => 'Sofia Reeves',
                    'email'         => 'sofia@pixelstudio.io',
                    'website_url'   => 'https://pixelstudio.io',
                ],
                'website' => [
                    'name'        => 'PixelStudio',
                    'url'         => 'https://pixelstudio.io',
                    'description' => 'Creative digital agency specialising in brand identity, UI/UX design, and web development.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Nathan Brooks',
                        'author_email' => 'nathan@startup.com',
                        'author_role'  => 'Founder',
                        'content'      => 'PixelStudio redesigned our entire brand. The new look drove a 50% increase in inbound leads.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Zoe Carter',
                        'author_email' => 'zoe@agency.com',
                        'author_role'  => 'Creative Director',
                        'content'      => 'Pixel-perfect execution every time. Their attention to detail is unmatched in the industry.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Mike Owens',
                        'author_email' => 'mike@app.com',
                        'author_role'  => 'Product Owner',
                        'content'      => 'They built our app UI from scratch and the user feedback has been overwhelmingly positive.',
                        'rating'       => 5,
                    ],
                ],
            ],
            [
                'user' => [
                    'business_name' => 'CloudBase',
                    'name'          => 'Ethan Walsh',
                    'email'         => 'ethan@cloudbase.io',
                    'website_url'   => 'https://cloudbase.io',
                ],
                'website' => [
                    'name'        => 'CloudBase',
                    'url'         => 'https://cloudbase.io',
                    'description' => 'Scalable cloud infrastructure, DevOps consulting, and managed services for modern engineering teams.',
                ],
                'testimonials' => [
                    [
                        'author_name'  => 'Amy Liu',
                        'author_email' => 'amy@tech.com',
                        'author_role'  => 'VP Engineering',
                        'content'      => 'CloudBase cut our infrastructure costs by 40% and our deployment time by 70%. Phenomenal team.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'James Adeyemi',
                        'author_email' => 'james@corp.com',
                        'author_role'  => 'CTO',
                        'content'      => 'Zero downtime migrations and rock-solid uptime. CloudBase is the backbone of our platform.',
                        'rating'       => 5,
                    ],
                    [
                        'author_name'  => 'Hana Yoshida',
                        'author_email' => 'hana@startup.io',
                        'author_role'  => 'DevOps Lead',
                        'content'      => 'Their Kubernetes expertise saved us weeks of work. The support is fast and genuinely helpful.',
                        'rating'       => 5,
                    ],
                ],
            ],
        ];

        foreach ($businesses as $data) {
            // Skip if this business email already exists
            if (User::where('email', $data['user']['email'])->exists()) {
                continue;
            }

            $user = User::create([
                'business_name' => $data['user']['business_name'],
                'name'          => $data['user']['name'],
                'email'         => $data['user']['email'],
                'password'      => Hash::make('password'),
                'website_url'   => $data['user']['website_url'],
                'website_limit' => 5,
            ]);

            $slug    = \App\Models\Website::generateUniqueSlug($data['website']['name']);
            $website = Website::create([
                'user_id'     => $user->id,
                'name'        => $data['website']['name'],
                'slug'        => $slug,
                'url'         => $data['website']['url'],
                'description' => $data['website']['description'],
                'is_active'   => true,
            ]);

            foreach ($data['testimonials'] as $t) {
                Testimonial::create([
                    'website_id'   => $website->id,
                    'author_name'  => $t['author_name'],
                    'author_email' => $t['author_email'],
                    'author_role'  => $t['author_role'],
                    'content'      => $t['content'],
                    'rating'       => $t['rating'],
                    'status'       => 'approved',
                    'is_featured'  => true,
                    'reviewed_at'  => now()->subDays(rand(5, 90)),
                ]);
            }
        }
    }
}
