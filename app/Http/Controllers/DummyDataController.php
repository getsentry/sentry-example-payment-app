<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class DummyDataController extends Controller
{
    public function generate(): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Generate a unique timestamp for this batch
            $timestamp = now()->timestamp;
            
            // Create 10 dummy users
            $users = [];
            for ($i = 0; $i < 10; $i++) {
                $users[] = User::create([
                    'name' => 'Dummy User ' . ($i + 1),
                    'email' => "dummy.user{$i}.{$timestamp}@example.com",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);
            }

            // Create 20 dummy payments
            $currencies = ['USD', 'EUR', 'GBP'];
            $types = ['send', 'receive', 'convert'];
            $statuses = ['pending', 'completed', 'failed'];

            $payments = [];
            for ($i = 0; $i < 20; $i++) {
                $sender = $users[array_rand($users)];
                $receiver = $users[array_rand($users)];
                
                // Ensure sender and receiver are different
                while ($receiver->id === $sender->id) {
                    $receiver = $users[array_rand($users)];
                }

                $payments[] = Payment::create([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'amount' => rand(1000, 10000) / 100, // Random amount between 10.00 and 100.00
                    'currency' => $currencies[array_rand($currencies)],
                    'type' => $types[array_rand($types)],
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Dummy data generated successfully',
                'users_created' => count($users),
                'payments_created' => count($payments),
                'batch_timestamp' => $timestamp
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to generate dummy data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cleanup(): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Delete all dummy users and their associated payments
            $deletedUsers = User::where('email', 'like', 'dummy.user%@example.com')->delete();
            
            // Delete any orphaned payments
            $deletedPayments = Payment::whereDoesntHave('sender')
                ->orWhereDoesntHave('receiver')
                ->delete();

            DB::commit();

            return response()->json([
                'message' => 'Dummy data cleaned up successfully',
                'users_deleted' => $deletedUsers,
                'payments_deleted' => $deletedPayments
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to cleanup dummy data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 