<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Interlocking Tiles',
            'description' => 'Experience the perfect combination of durability, versatility, and convenience with our premium Interlocking Tiles. Designed for easy installation, these tiles are an ideal choice for both indoor and outdoor spaces. Whether it’s a patio, driveway, walkway, or an interior upgrade, our Interlocking Tiles enhance aesthetics and provide long-lasting performance.',
            'meta_title' => 'Interlocking Tiles | Al Sultan Industrial Cement',
            'meta_description' => 'Interlocking Tiles | Al Sultan Industrial Cement',
        ]);
        Category::create([
            'title' => 'Kerbstone Collection',
            'description' => 'Discover the perfect blend of functionality and aesthetics with our Kerbstone Collection. Built to withstand the toughest conditions, these kerbstones offer robust support for pathways, driveways, and landscaping.',
            'meta_title' => 'Kerbstones | Al Sultan Industrial Cement',
            'meta_description' => 'Kerbstones | Al Sultan Industrial Cement',
        ]);
        Category::create([
            'title' => 'Cable Cover Collection',
            'description' => 'Ensure the longevity and safety of your cable systems with our premium Cable Covers. Crafted to withstand harsh conditions and heavy use, they provide reliable protection for exposed cables in various settings.',
            'meta_title' => 'Cable Cover | Al Sultan Industrial Cement',
            'meta_description' => 'Cable Cover | Al Sultan Industrial Cement',
        ]);
        Category::create([
            'title' => 'Hollow & Solid blocks',
            'description' => 'Our Hollow & Solid Blocks provide strong and durable solutions for all your paving and construction needs. Engineered for versatility, these blocks are ideal for a wide range of applications, from structural foundations to decorative features.',
            'meta_title' => 'Hollow & Solid blocks | Al Sultan Industrial Cement',
            'meta_description' => 'Hollow & Solid blocks | Al Sultan Industrial Cement',
        ]);
        Category::create([
            'title' => 'Concrete Slabs',
            'description' => 'Ensure the longevity and safety of your cable systems with our premium Cable Covers. Crafted to withstand harsh conditions and heavy use, they provide reliable protection for exposed cables in various settings.',
            'meta_title' => 'Concrect Slabs | Al Sultan Industrial Cement',
            'meta_description' => 'Concrect Slabs | Al Sultan Industrial Cement',
        ]);
    }
}
