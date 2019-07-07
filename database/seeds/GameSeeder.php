<?php

use Illuminate\Database\Seeder;
use App\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games = [
            'Arena of Valor',
            'PUBG',
            'Mobile Legends',
            'LifeAfter',
            'Clash of Clans',
            'Clash Royale'
        ];

        foreach ($games as $game) {
            Game::create([
                'name' => $game
            ]);
        }
    }
}
