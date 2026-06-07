<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactSubmission;

class ContactSubmissionSeeder extends Seeder
{
    public function run()
    {
        ContactSubmission::insert([
            [
                'name'    => 'Alice Smith',
                'email'   => 'alice@example.com',
                'phone'   => '+1111111111',
                'country' => 'UK',
                'message' => 'Hello, I need info about your plans.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'    => 'Bob Johnson',
                'email'   => 'bob@example.com',
                'phone'   => '+2222222222',
                'country' => 'Canada',
                'message' => 'Can you provide pricing details?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'    => 'Charlie Lee',
                'email'   => 'charlie@example.com',
                'phone'   => '+3333333333',
                'country' => 'Australia',
                'message' => 'Interested in your services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
