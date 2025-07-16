<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\KeluhanPelanggan;
use App\Models\KeluhanStatusHis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        $listkeluhan = KeluhanPelanggan::factory(50)->create();

        foreach($listkeluhan as $keluhan){
            KeluhanStatusHis::factory()->create([
                'keluhan_id' => $keluhan->id,
                'status_keluhan' => $keluhan->status_keluhan,
            ]);
        }
    }
}
