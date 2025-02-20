<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class PagesSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Home
        Section::create([
            'key' => 'home_page_about',
            'title' => 'Who we are',
            'sub_title' => '',
            'btn_title' => 'Read More',
            'btn_link' => '',
            'description' => 'Al Sultan Industrial Cement Factory is one of the leading Concrete Products Manufacturer in the region. The company was founded in 1982 in Abu Dhabi.',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 0
            ],
        ]);
        Section::create([
            'key' => 'home_page_visualizer',
            'title' => 'Interactive 360 Visualizer',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'View our products in an immersive 360° interactive experience. Explore our various products applications across diverse spaces and more.',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 1,
                "video" => 1,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 0,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);
        //By Size
        Section::create([
            'key' => 'by_size_page_main',
            'title' => 'By Size',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'Experience the perfect combination of durability, versatility, and convenience with our premium Interlocking Tiles. Designed for easy installation, these tiles are an ideal choice for both indoor and outdoor spaces.',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);

        //About us
        Section::create([
            'key' => 'about_page_main',
            'title' => 'Who we are',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'Al Sultan Industrial Cement Factory is one of the leading Concrete Products Manufacturer in the region. The company was founded in 1982 in Abu Dhabi.',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);
        Section::create([
            'key' => 'about_page_vision',
            'title' => 'Vision',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'Leading and applying the latest studies and standards to provide our local market with product of the highest quality using safe and sustainable operations.',
            'is_required' => [
                "image"=> 0,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 1,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);
        Section::create([
            'key' => 'about_page_mission',
            'title' => 'Mission',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'Developing a sustainable infrastructure and land scaping system that improve our local community.',
            'is_required' => [
                "image"=> 0,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 1,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);
        Section::create([
            'key' => 'about_page_policy',
            'title' => 'Quality Policy',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'We maintain our product quality by adopting the following steps:',
            'is_required' => [
                "image"=> 0,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 1,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);

        //Contact
        Section::create([
            'key' => 'contact_page_get_contact',
            'title' => 'Get Contact!',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => 'If you need help, support, or just want to say hi, feel free to get in touch with below.',
            'is_required' => [
                "image"=> 0,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 1,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0
            ],
        ]);
        //Inquiry Form
        Section::create([
            'key' => 'inquiry_page_main',
            'title' => '',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => '',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 0,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 0,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 1,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 1
            ],
        ]);
    }
}
