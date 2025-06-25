<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Красный', 'code' => '#FF0000'],
            ['name' => 'Синий', 'code' => '#0000FF'],
            ['name' => 'Зеленый', 'code' => '#00FF00'],
            ['name' => 'Черный', 'code' => '#000000'],
            ['name' => 'Белый', 'code' => '#FFFFFF'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
