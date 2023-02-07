<?php

namespace Database\Seeders\Tasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class TaskPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_periods')->insert([
            [
                'id' => '458943da-0feb-4e16-a7e3-66d3720ac7cf',
                'name' => 'Ежедневно',
                'alias' => 'daily',
                'period_time' => '+1 day',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 'ed299cb8-bc11-4910-99f4-24f4c6463012',
                'name' => 'Еженедельно',
                'alias' => 'weekly',
                'period_time' => '+1 week',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '6af96f0c-67ff-40e0-9ef7-2f1dc9121732',
                'name' => 'Ежемесячно',
                'alias' => 'monthly',
                'period_time' => '+1 month',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 'eaf670a6-3e1b-47a3-b73e-283d2c1c009e',
                'name' => 'Ежеквартально',
                'alias' => 'quarterly',
                'period_time' => '+3 months',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '21b065be-b8fe-4f19-a7a2-0c1b09261c8c',
                'name' => 'Ежегодно',
                'alias' => 'annually',
                'period_time' => '+1 year',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
