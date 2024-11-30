<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        // Menu item data
        $menuItems = [
            ['name' => 'Home', 'is_available' => 1],
            ['name' => 'Menu', 'is_available' => 1],
        ];

        // Insert the data into the menu_items table
        foreach ($menuItems as $menuItem) {
            MenuItem::create($menuItem);
        }
    }
}
