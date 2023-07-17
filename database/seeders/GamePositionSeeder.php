<?php

namespace Database\Seeders;

use App\Models\GamePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamePositionSeeder extends Seeder
{
    use WithoutModelEvents;
    
    protected array $gamePositions = [
        [
            'name' => 'Goleiro',
            'short' => 'GK',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-success m-0'> GK </p>",
        ],
        [
            'name' => 'Zagueiro',
            'short' => 'ZG',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0'> ZG </p>",
        ],
        [
            'name' => 'Lateral Direito',
            'short' => 'LTD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0'> LTD </p>",
        ],
        [
            'name' => 'Lateral Esquerdo',
            'short' => 'LTE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0'> LTE </p>",
        ],
        [
            'name' => 'Ala Direito',
            'short' => 'ALD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> ALD </p>",
        ],
        [
            'name' => 'Ala Esquerdo',
            'short' => 'ALE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> ALE </p>",
        ],
        [
            'name' => 'Volante',
            'short' => 'VOL',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> VOL </p>",
        ],
        [
            'name' => 'Meio Campo Direito',
            'short' => 'MCD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> MCD </p>",
        ],
        [
            'name' => 'Meio Campo Esquerdo',
            'short' => 'MCE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> MCE </p>",
        ],
        [
            'name' => 'Meio Campo Ofensivo',
            'short' => 'MCO',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0'> LTD </p>",
        ],
        [
            'name' => 'Centro Avante',
            'short' => 'CA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0'> CA </p>",
        ],
        [
            'name' => 'Ponta de Área Externo',
            'short' => 'EX',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0'> EX </p>",
        ],
        [
            'name' => 'Segundo Avançado',
            'short' => 'SA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0'> SA </p>",
        ],
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        foreach($this->gamePositions as $gamePosition) {
            GamePosition::updateOrCreate(
                [
                    'name' => $gamePosition['name']
                ],
                $gamePosition
            );
        }
    }
}
