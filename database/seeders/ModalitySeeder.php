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
            'name' => 'Futsal',
            'description' => 'Cinco jogadores, sendo 1 goleiro. Quadra'
        ],
        [
            'name' => 'Fut7',
            'description' => 'Fut7 ou Society. Sete jogadores, sendo 1 goleiro. Campo sintético'
        ],
        [
            'name' => 'Suíço',
            'description' => 'Jogam de 6 a 8 na linha, 1 no gol. Campo de grama'
        ],
        [
            'name' => 'Campo de 11',
            'description' => 'Onze jogadores, sendo 1 goleiro.'
        ],
    ];

    public function run()
    {
        foreach($this->modalities as $modality) {
            Modality::updateOrCreate(
                [
                    '' => $modality['name']
                ],
                $modality
            );
        }
    }
}
