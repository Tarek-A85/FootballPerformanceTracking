<?php

namespace Database\Seeders;

use App\Models\ActivityStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach([
            [
              'not started',
              'لم تبدأ بعد'
            ],
            [
                'finished',
                'انتهت',
            ],
            [
                'cancelled',
                'ألغيت'
            ],
            [
                'posponed',
                'مؤجلة'
            ]
        ] as $status){
            ActivityStatus::create([
                'name_en' => $status[0],
                'name_ar' => $status[1]
            ]);
        }
    }
}
