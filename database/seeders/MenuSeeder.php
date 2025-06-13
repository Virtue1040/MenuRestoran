<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'judul' => 'Sate Ayam',
            'kategori' => 'Makanan',
            'asal' => 'Madura',
            'image' => 'upload/sate.jpg',
        ]);

        Menu::create([
            'judul' => 'Es Cendol',
            'kategori' => 'Minuman',
            'asal' => 'Sunda',
            'image' => 'upload/cendol.jpg',
        ]);
    }
}
