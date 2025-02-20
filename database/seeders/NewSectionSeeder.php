<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Page;

class NewSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'key' => 'tailor_made_design',
            'title' => 'Get a <i>tailor made</i> design',
            'sub_title' => 'Start Planning',
            'btn_title' => 'Learn More',
            'btn_link' => '',
            'description' => '',
            'is_required' => [
                "image"=> 1,
                "second_image" => 0,
                "highlight" => 0,
                "video" => 0,
                "title"=> 1,
                "sub_title"=> 1,
                "btn_title"=> 1,
                "btn_link"=> 1,
                "description"=> 0,
                "title_editor" => 0
            ],
            'removed_inputs' => [
                "image"=> 0,
                "second_image" => 1,
                "highlight" => 1,
                "video" => 1,
                "title"=> 0,
                "sub_title"=> 0,
                "btn_title"=> 0,
                "btn_link"=> 0,
                "description"=> 1
            ],
        ]);

        //Tailor Made Design
        Page::create([
            'key' => 'tailormade-page',
            'slug' => 'tailormade-page',
            'title' => 'Tailor Made Design',
            'description' => '',
            'meta_title' => 'Tailor Made Design | Al Sultan Industrial Cement',
            'meta_description' => 'Tailor Made Design | Al Sultan Industrial Cement',
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
        Section::create([
            'key' => 'tailormade-page-main',
            'title' => 'Tailor Design',
            'sub_title' => '',
            'btn_title' => '',
            'btn_link' => '',
            'description' => '',
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
    }
}
