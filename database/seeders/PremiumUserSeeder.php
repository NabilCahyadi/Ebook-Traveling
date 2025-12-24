<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PremiumUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisikan data untuk 3 pengguna premium di dalam array
        $premiumUsersData = [
            [
                'name' => 'Premium User',
                'email' => 'premium@gmail.com',
                'plan_slug' => 'yearly-voyager-66003',
            ],
            [
                'name' => 'Star Premium',
                'email' => 'premium1@gmail.com',
                'plan_slug' => 'yearly-voyager-66003',
            ],
            [
                'name' => 'Gold Premium',
                'email' => 'premium2@gmail.com',
                'plan_slug' => 'yearly-voyager-66003',6
            ],
            [
                'name' => 'Kahla Luthfiyah',
                'email' => 'premium3@gmail.com',
                'plan_slug' => 'yearly-voyager-66003',
            ],
        ];

        // Ambil role 'member' sekali saja di luar loop
        $memberRole = DB::table('roles')->where('name', 'member')->first();
        if (!$memberRole) {
            $this->command->error('Role "member" not found. Please run RoleSeeder first.');
            return;
        }

        // Loop untuk membuat setiap pengguna
        foreach ($premiumUsersData as $userData) {
            // 1. Cek apakah user sudah ada
            if (User::where('email', $userData['email'])->exists()) {
                $this->command->info("User with email {$userData['email']} already exists. Skipping.");
                continue; // Lanjut ke pengguna berikutnya
            }

            // 2. Buat pengguna baru
            $premiumUser = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'), // password: password untuk semua
                'email_verified_at' => now(),
            ]);

            // 3. Assign role 'member' ke pengguna baru
            DB::table('user_roles')->insert([
                'id' => Str::uuid(),
                'user_id' => $premiumUser->id,
                'role_id' => $memberRole->id,
            ]);

            // 4. Ambil paket berlangganan berdasarkan slug
            $plan = SubscriptionPlan::where('slug', $userData['plan_slug'])->first();

            if (!$plan) {
                $this->command->error("Subscription plan '{$userData['plan_slug']}' not found.");
                continue; // Lanjut ke pengguna berikutnya
            }

            // 5. Buat data langganan yang aktif
            $startDate = now();
            $endDate = (clone $startDate)->addDays($plan->duration_days);

            DB::table('subscriptions')->insert([
                'id' => Str::uuid(),
                'user_id' => $premiumUser->id,
                'subscription_plan_id' => $plan->id,
                'payment_id' => null,
                'subscription_code' => 'PREMIUM-' . strtoupper(Str::random(8)),
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'status' => 'active',
                'auto_renew' => true,
                'total_amount' => $plan->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Premium users created successfully!');
        $this->command->line('Emails: premium@gmail.com, premium1@gmail.com, premium2@gmail.com, premium3@gmail.com');
        $this->command->line('Password for all: password');
    }
}
