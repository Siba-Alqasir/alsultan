<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(BasicPagesSeeder::class);
        $this->call(PagesSectionsSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(NewSectionSeeder::class);
    }
}
