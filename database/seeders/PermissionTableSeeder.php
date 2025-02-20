<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'pages-list',
            'pages-create',
            'pages-edit',
            'pages-delete',

            'sections-list',
            'sections-create',
            'sections-edit',
            'sections-delete',

            'settings-list',
            'settings-create',
            'settings-edit',
            'settings-delete',

            'users-list',
            'users-create',
            'users-edit',
            'users-delete',

            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',

            'translations-list',
            'translations-create',
            'translations-edit',
            'translations-delete',

            'sliders-list',
            'sliders-create',
            'sliders-edit',
            'sliders-delete',

            'categories-list',
            'categories-create',
            'categories-edit',
            'categories-delete',

            'companies-list',
            'companies-create',
            'companies-edit',
            'companies-delete',

            'products-list',
            'products-create',
            'products-edit',
            'products-delete',

            'statistics-list',
            'statistics-create',
            'statistics-edit',
            'statistics-delete',

            'policies-list',
            'policies-create',
            'policies-edit',
            'policies-delete',

            'certificates-list',
            'certificates-create',
            'certificates-edit',
            'certificates-delete',

            'services-list',
            'services-create',
            'services-edit',
            'services-delete',

            'projects-list',
            'projects-create',
            'projects-edit',
            'projects-delete',

            'treatments-list',
            'treatments-create',
            'treatments-edit',
            'treatments-delete',

            'clients-list',
            'clients-create',
            'clients-edit',
            'clients-delete',

            'news-list',
            'news-create',
            'news-edit',
            'news-delete',

            'inquiries-list',
            'inquiries-delete',

            'sizes-list',
            'sizes-create',
            'sizes-edit',
            'sizes-delete',

            'colors-list',
            'colors-create',
            'colors-edit',
            'colors-delete',

            'patterns-list',
            'patterns-create',
            'patterns-edit',
            'patterns-delete',

            'finishes-list',
            'finishes-create',
            'finishes-edit',
            'finishes-delete',

            'types-list',
            'types-create',
            'types-edit',
            'types-delete',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
