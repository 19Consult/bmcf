<?php

namespace Database\Seeders;

use App\Models\SettingsTable;
use Illuminate\Database\Seeder;

class DafaultSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingsTable::create([
            'name' => 'count_posts',
            'value' => '1',
            ]);
    }
}
