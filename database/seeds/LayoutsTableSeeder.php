<?php

use App\Layouts;
use Illuminate\Database\Seeder;

class LayoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Layouts::create([
            'nama' => 'cover',
            'image' => 'layouts-01.JPG'
        ]);
        Layouts::create([
            'nama' => '4-row',
            'image' => 'layouts-02.JPG'
        ]);
        Layouts::create([
            'nama' => '5-row',
            'image' => 'layouts-03.JPG'
        ]);
        Layouts::create([
            'nama' => '6-row',
            'image' => 'layouts-04.JPG'
        ]);
        Layouts::create([
            'nama' => '3-row',
            'image' => 'layouts-05.JPG'
        ]);
        Layouts::create([
            'nama' => '2-row',
            'image' => 'layouts-06.JPG'
        ]);
        Layouts::create([
            'nama' => '3-row vertical',
            'image' => 'layouts-07.JPG'
        ]);
        Layouts::create([
            'nama' => '4-row vertical',
            'image' => 'layouts-08.JPG'
        ]);
        Layouts::create([
            'nama' => '4-rv 1-rh',
            'image' => 'layouts-09.JPG'
        ]);
        Layouts::create([
            'nama' => '3-rv 1-rh',
            'image' => 'layouts-10.JPG'
        ]);
    }
}
