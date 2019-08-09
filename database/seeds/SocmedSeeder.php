<?php

use Illuminate\Database\Seeder;
use App\Socmed;

class SocmedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socmeds = [
            'Facebook',
            'Instagram',
            'Twitter',
            'Github',
        ];

        foreach ($socmeds as $socmed) {
            Socmed::create([
                'name' => $socmed
            ]);
        }
    }
}
