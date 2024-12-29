<?php

namespace Database\Seeders;

use App\Models\Round;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach([
            ['League match',
            'مباراة دوري'],

            ['Group stage',
            'دور المجموعات'],

            ['Round of 16',
            'دور ال 16'],

           [ 'Quarter final',
            'ربع النهائي'],

            ['Semi final',
            'نصف النهائي'],

            ['Final',
            'النهائي']
        ] as $round){
            Round::create([
                'name_en' => $round[0],
                'name_ar' => $round[1],
            ]);
        }
    }
}
