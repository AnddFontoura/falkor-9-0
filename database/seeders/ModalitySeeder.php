<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Modality;
use Illuminate\Database\Seeder;

class ModalitySeeder extends Seeder
{
    use WithoutModelEvents;

    protected array $modalities = [
        [
            'modality' => 'Futsal',
            'description' => 'Cinco jogadores, sendo 1 goleiro. Quadra'
        ],
        [
            'modality' => 'Fut7',
            'description' => 'Fut7 ou Society. Sete jogadores, sendo 1 goleiro. Campo sintético'
        ],
        [
            'modality' => 'Suíço',
            'description' => 'Jogam de 6 a 8 na linha, 1 no gol. Campo de grama'
        ],
        [
            'modality' => 'Campo de 11',
            'description' => 'Onze jogadores, sendo 1 goleiro.'
        ],
    ];

    public function run()
    {
        foreach($this->modalities as $modality) {
            Modality::updateOrCreate(
                [
                    'modality' => $modality['modality']
                ],
                $modality
            );
        }
    }
}
