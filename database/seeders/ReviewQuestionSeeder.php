<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('review_questions')->insert([
            [
            	'name' => 'performance',
            	'label' => 'Performance',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'attendance',
            	'label' => 'Attendance',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'workQuality',
            	'label' => 'Work Quality',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'deliverables',
            	'label' => 'Deliverables',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'communication',
            	'label' => 'Communication',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'techSkill',
            	'label' => 'Tech Skill',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'newLearning',
            	'label' => 'New Learning',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'timeMaintaince',
            	'label' => 'Time Maintaince',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'socialInvolvement',
            	'label' => 'Social Involvement',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'overall',
            	'label' => 'overall',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
