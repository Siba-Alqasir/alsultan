<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class BasicPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'key' => 'home-page',
            'slug' => 'home-page',
            'title' => 'home page',
            'description' => '',
            'meta_title' => 'Al Sultan Industrial Cement',
            'meta_description' => 'Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 0,
                "video" => 0,
                "title"=> 0,
                "sub_title"=> 0,
                "description"=> 0,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 1,
                "video" => 1,
                "title"=> 1,
                "sub_title"=> 1,
                "description"=> 1,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'privacy-policy-page',
            'slug' => 'Privacy-Policy-page',
            'title' => 'Privacy Policy',
            'description' => 'Privacy Policy',
            'meta_title' => 'Privacy Policy | Al Sultan Industrial Cement',
            'meta_description' => 'Privacy Policy | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 1,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 0,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'terms-and-conditions-page',
            'slug' => 'Terms-and-Condition-page',
            'title' => 'Terms & Condition page',
            'description' => 'Terms & Condition page',
            'meta_title' => 'Terms & Condition | Al Sultan Industrial Cement',
            'meta_description' => 'Terms & Condition | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 1,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 0,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'thank-you-page',
            'slug' => 'thank-you-page',
            'title' => 'Thank You page',
            'description' => 'Thank You page',
            'meta_title' => 'Thank You | Al Sultan Industrial Cement',
            'meta_description' => 'Thank You | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 1,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 0,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'not-found-page',
            'slug' => 'Not-Found-page',
            'title' => '404 | Not Found',
            'description' => '404 | Not Found',
            'meta_title' => '404 | Not Found | Al Sultan Industrial Cement',
            'meta_description' => '404 | Not Found | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 1,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 0,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'by-size-page',
            'slug' => 'by-size-page',
            'title' => 'By Size Page',
            'description' => '',
            'meta_title' => 'By Size | Al Sultan Industrial Cement',
            'meta_description' => 'By Size | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 0,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 1,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'tailor-page',
            'slug' => 'tailor-page',
            'title' => 'Tailor Made Design Page',
            'description' => '',
            'meta_title' => 'Tailor Made Design | Al Sultan Industrial Cement',
            'meta_description' => 'Tailor Made Design | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 0,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 1,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'about-us-page',
            'slug' => 'about-us-page',
            'title' => 'About Us Page',
            'description' => '',
            'meta_title' => 'About Us | Al Sultan Industrial Cement',
            'meta_description' => 'About Us | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 0,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 1,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'services-page',
            'slug' => 'services-page',
            'title' => 'Services',
            'description' => '',
            'meta_title' => 'Services | Al Sultan Industrial Cement',
            'meta_description' => 'Services | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "description"=> 0,
                "seo" => 1,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "description"=> 1,
                "seo" => 0,
            ],
        ]);
        Page::create([
            'key' => 'projects-page',
            'slug' => 'projects-page',
            'title' => 'Projects',
            'description' => '',
            'meta_title' => 'Projects | Al Sultan Industrial Cement',
            'meta_description' => 'Projects | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],
        ]);
        Page::create([
            'key' => 'surface-page',
            'slug' => 'surface-page',
            'title' => 'Surface Treatment',
            'description' => '',
            'meta_title' => 'Surface Treatment | Al Sultan Industrial Cement',
            'meta_description' => 'Surface Treatment | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],
        ]);
        Page::create([
            'key' => 'clients-page',
            'slug' => 'clients-page',
            'title' => 'Clients',
            'description' => '',
            'meta_title' => 'Clients | Al Sultan Industrial Cement',
            'meta_description' => 'Clients | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],
        ]);
        Page::create([
            'key' => 'blogs-page',
            'slug' => 'blogs-page',
            'title' => 'News & Blogs',
            'description' => '',
            'meta_title' => 'News & Blogs | Al Sultan Industrial Cement',
            'meta_description' => 'News & Blogs | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],
        ]);
        Page::create([
            'key' => 'contact-us-page',
            'slug' => 'contact-us-page',
            'title' => 'Contact Us',
            'description' => '',
            'meta_title' => 'Contact Us | Al Sultan Industrial Cement',
            'meta_description' => 'Contact Us | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],

        ]);
        Page::create([
            'key' => 'inquiry-page',
            'slug' => 'inquiry-page',
            'title' => 'Inquiry Form',
            'description' => '',
            'meta_title' => 'Inquiry Form | Al Sultan Industrial Cement',
            'meta_description' => 'Inquiry Form | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],

        ]);
        
        Page::create([
            'key' => 'search-page',
            'slug' => 'search-page',
            'title' => 'Search Page',
            'description' => '',
            'meta_title' => 'Search Page | Al Sultan Industrial Cement',
            'meta_description' => 'Search Page | Al Sultan Industrial Cement',
            'is_required' => [
                "cover"=> 1,
                "video" => 0,
                "title"=> 1,
                "description"=> 0,
                "seo" => 1,
                "sub_title"=> 0,
            ],
            'removed_inputs' => [
                "cover"=> 0,
                "video" => 1,
                "title"=> 0,
                "description"=> 1,
                "seo" => 0,
                "sub_title"=> 1,
            ],

        ]);
        
    }
}
