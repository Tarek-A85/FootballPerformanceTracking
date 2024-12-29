<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach([
            ['friendly match',
            'مباراة ودية'],

             ['stamina',
             'لياقة بدنية'],

             [ 'shooting',
              'تسديد'],

               ['passing',
               'تمرير'],

               [ 'general',
                'تمرين عام']
                ] 
        as $drill){
            TrainingType::create([
                'name_en' => $drill[0],
                'name_ar' => $drill[1]
            ]);
        }
    }
}
