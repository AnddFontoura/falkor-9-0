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
            'icon' => "<p class='btn btn-sm btn-success m-0' alt='Goleiro'> GK </p>",
        ],
        [
            'name' => 'Zagueiro',
            'short' => 'ZG',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0' alt='Zagueiro'> ZG </p>",
        ],
        [
            'name' => 'Lateral Direito',
            'short' => 'LTD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0' alt='Lateral Direito'> LTD </p>",
        ],
        [
            'name' => 'Lateral Esquerdo',
            'short' => 'LTE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info m-0' alt='Lateral Esquerdo'> LTE </p>",
        ],
        [
            'name' => 'Ala Direito',
            'short' => 'ALD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Ala Direito'> ALD </p>",
        ],
        [
            'name' => 'Ala Esquerdo',
            'short' => 'ALE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Ala Esquerdo'> ALE </p>",
        ],
        [
            'name' => 'Volante',
            'short' => 'VOL',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Volante'> VOL </p>",
        ],
        [
            'name' => 'Meio Campo Direito',
            'short' => 'MCD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Meio Campo Direito'> MCD </p>",
        ],
        [
            'name' => 'Meio Campo Esquerdo',
            'short' => 'MCE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Meio Campo Esquerdo'> MCE </p>",
        ],
        [
            'name' => 'Meio Campo Ofensivo',
            'short' => 'MCO',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary m-0' alt='Meio Campo Ofensivo'> LTD </p>",
        ],
        [
            'name' => 'Centro Avante',
            'short' => 'CA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0' alt='Centro Avante'> CA </p>",
        ],
        [
            'name' => 'Ponta de Área Externo',
            'short' => 'EX',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0' alt='Ponta de Área Externo'> EX </p>",
        ],
        [
            'name' => 'Segundo Avançado',
            'short' => 'SA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger m-0' alt='Segundo Avançado'> SA </p>",
        ],
    ];

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
