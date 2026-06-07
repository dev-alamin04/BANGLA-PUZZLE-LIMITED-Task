<?php
namespace Database\Seeders;

use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::insert([
            [
                'id'             => 1,
                'system_name'    => 'Laravel',
                'email'          => 'support@gmail.com',
                'copyright_text' => '© 2025 copyright. All right reserved.',
                'logo'           => 'uploads/logos/logo.png',
                'favicon'        => 'uploads/favicons/mini-logo.png',
                'created_at'     => Carbon::now(),
            ],
        ]);
    }
}
