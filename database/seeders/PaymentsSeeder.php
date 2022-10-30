<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $firstUser = User::take(1)->first();
        if (empty($firstUser)) {
            $this->command->line("Unable to run the seed since no user was not found in the system.");
            return;
        }

        $payments = [
            [
                'user_id' => $firstUser->id,
                'gateway' => Payment::GATEWAY_FIRST,
                'amount' => 500,
                'amount_paid' => 0,
            ],
            [
                'user_id' => $firstUser->id,
                'gateway' => Payment::GATEWAY_SECOND,
                'amount' => 500,
                'amount_paid' => 0,
            ],
            [
                'user_id' => $firstUser->id,
                'gateway' => Payment::GATEWAY_FIRST,
                'amount' => 600,
                'amount_paid' => 0,
            ],
            [
                'user_id' => $firstUser->id,
                'gateway' => Payment::GATEWAY_SECOND,
                'amount' => 10000,
                'amount_paid' => 0,
            ],
            [
                'user_id' => $firstUser->id,
                'gateway' => Payment::GATEWAY_FIRST,
                'amount' => 1500,
                'amount_paid' => 0,
            ]
        ];

        Payment::insert($payments);
        $this->command->line("Ok.");
    }
}
