<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'phone',
            'value' =>'+971 2 566 6555',
        ]);
        Setting::create([
            'key' => 'email',
            'value' => 'info@alsultanfactory.com',
        ]);
        Setting::create([
            'key' => 'address',
            'value' => 'Mafraq Industrial Area - Abu Dhabi. P.O. Box 8423',
        ]);
        Setting::create([
            'key' => 'map',
            'value' =>'https://maps.app.goo.gl/9N5TPUijd9XP8jVb7',
        ]);
        Setting::create([
            'key' => 'slogan',
            'value' => 'Al Sultan Industrial Cement a leading Concrete Products Manufacturer Founded in 1982.',
        ]);
        Setting::create([
            'key' => 'brochure',
            'value' => '',
        ]);
        Setting::create([
            'key' => 'iframe',
            'value' => '',
        ]);

        //Social Media
        Setting::create([
            'key' => 'facebook',
            'value' =>'https://www.facebook.com/alsultancement',
        ]);
        Setting::create([
            'key' => 'instagram',
            'value' =>'https://www.instagram.com/AlSultanIndustrialCement',
        ]);
        Setting::create([
            'key' => 'linkedin',
            'value' =>'https://www.linkedin.com/company/alsultanindustrialcement',
        ]);
    }
}
