<?php

use Illuminate\Database\Seeder;

class ReportStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report_status')->insert([
            'status' => 'INIT',
        ]);

        DB::table('report_status')->insert([
            'status' => 'READY_FOR_GENERATION',
        ]);

        DB::table('report_status')->insert([
            'status' => 'GENERATED',
        ]);

        DB::table('report_status')->insert([
            'status' => 'READY_FOR_QA',
        ]);

        DB::table('report_status')->insert([
            'status' => 'READY_FOR_DELIVERY',
        ]);
    }
}
