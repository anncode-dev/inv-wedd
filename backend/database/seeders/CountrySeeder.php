<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ##Insert New Data
        $file = database_path('csvs/currency.csv');         
        $data = csvToArray($file,';');
        foreach ($data as $k => $v) {               
            $v = array_map('trim', $v);                         
            $v['name'] = !empty($v['name']) ? $v['name'] : 0;
            $v['code'] = !empty($v['code']) ? $v['code'] : 0;
            
            \App\Models\Currency::create($v);
        }
    }
}
