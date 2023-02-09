<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainAlarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alarms = [
            'Auto reclosure',
            'Flag Relay Replacement',
            'Protection Clearance feeder',
            'Transformer Clearance',
            'mw reading wrong transformer',
            'mv reading wrong transformer',
            'kv reading wrong transformer',
            'Dist Prot Main Alaram',
            'Dist.Prot.Main B Alarm',
            'Pilot Cable Fault Alarm',
            'Pilot cable Superv.Supply Fail Alarm',
            'mw reading showing wrong',
            'mv reading showing wrong',
            'kv reading showing wrong',
            'ampere reading showing wrong',
            'BB reading showing wrong',
            'BB KV reading showing wrong',
            'Transformer out of step Alarm',
            'DC Supply 1 & 2 Fail Alarm',
            'General Alarm 300KV',
            'General Alarm 132KV',
            'General Alarm 33KV',
            'General Alarm 11KV',
            'B/Bar Protection Fail Alarm',
            'Shunt Reactor Restricted Earth Earth Fault Realy',
            'Shunt Reactor Over Current',
            'Shunt Reactor Clearance',
            'Shunt Reactor Earth Fault',
            'Breaker Open / close undefined',
            'B/Bar Isolator open / close D.S',
            'Line Isolator Open / close D.S'
        ];

        foreach ($alarms as $alarm) {
            DB::table('main_alarm')->insert([
                'department_id' => 2,
                'name' => $alarm,

            ]);
        }
    }
}
