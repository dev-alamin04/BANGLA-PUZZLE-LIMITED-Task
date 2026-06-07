<?php

namespace Database\Seeders;

use App\Models\DynamicPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DynamicPage::insert([
            [
                'page_title' => 'Terms of Service',
                'page_slug' => 'terms-service',
                'banner' => '/uploads/dynamic_page/terms-service.png',
                'page_content' =>" 
                <p>1. Introduction</p><p>Welcome to iFire Protection.</p><p>By accessing or using our website and services, you agree to comply with these Terms of Service. Please read them carefully before using our site.</p><p><br></p><p>If you do not agree with any part of these terms, please do not use our website or purchase our products.</p><p><br></p><p>2. About Our Services</p><p>iFire Protection provides professional wildfire defense solutions, including equipment sales, installation, and consultation services for residential, commercial, and community clients.</p><p></p><p></p>
                 ",
            ],
            [
                'page_title' => 'Privacy Policies',
                'page_slug' => 'privacy-policies',
                'banner' => '/uploads/dynamic_page/privacy-policies.png',
                 'page_content' =>" 
                <p>1. Introduction</p><p>Welcome to iFire Protection.</p><p>By accessing or using our website and services, you agree to comply with these Terms of Service. Please read them carefully before using our site.</p><p><br></p><p>If you do not agree with any part of these terms, please do not use our website or purchase our products.</p><p><br></p><p>2. About Our Services</p><p>iFire Protection provides professional wildfire defense solutions, including equipment sales, installation, and consultation services for residential, commercial, and community clients.</p><p></p><p></p>
                 ",
            ],
        ]);
    }
}
