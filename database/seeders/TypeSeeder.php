<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Models\Finish;
use App\Enums\CategoryEnum;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'title' => 'B/N-BULL NOSE',
            'category_id' => CategoryEnum::Kerbstone->value
        ]);
        Type::create([
            'title' => 'CH-CHAMFERING',
            'category_id' => CategoryEnum::Kerbstone->value
        ]);
        Type::create([
            'title' => 'FH-FLUSH',
            'category_id' => CategoryEnum::Kerbstone->value
        ]);

        Finish::create([
            'title' => 'Flush',
            'category_id' => CategoryEnum::Kerbstone->value
        ]);
    }
}
