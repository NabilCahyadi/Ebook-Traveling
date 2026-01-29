<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ebook;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(5)->get();
        $ebooks = Ebook::limit(10)->get();

        if ($users->isEmpty() || $ebooks->isEmpty()) {
            $this->command->warn('No users or ebooks found. Please run user and ebook seeders first.');
            return;
        }

        $this->command->info('Creating sample payments...');

        // Create 50 sample orders with payments
        for ($i = 1; $i <= 50; $i++) {
            $user = $users->random();
            $ebook = $ebooks->random();
            $price = rand(20000, 150000);
            
            // Random date dalam 12 bulan terakhir
            $createdAt = Carbon::now()->subDays(rand(0, 365));

            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . time() . '-' . $i,
                'subtotal' => $price,
                'total_amount' => $price,
                'status' => 'completed',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'ebook_id' => $ebook->id,
                'price' => $price,
                'quantity' => 1,
            ]);

            Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_code' => 'PAY-' . time() . '-' . $i,
                'payment_method' => collect(['transfer', 'credit_card', 'e-wallet'])->random(),
                'amount' => $price,
                'status' => 'completed',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            if ($i % 10 === 0) {
                $this->command->info("Created {$i} payments...");
            }
        }

        $this->command->info('✓ Payment seeder completed! Created 50 sample payments.');
    }
}
