<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    protected array $states = [
        [
            'name' => 'Acre',
            'short' => 'AC',
        ],
        [
            'name' => 'Alagoas',
            'short' => 'AL',
        ],
        [
            'name' => 'Amazonas',
            'short' => 'AM',
        ],
        [
            'name' => 'Amapá',
            'short' => 'AP',
        ],
        [
            'name' => 'Bahia',
            'short' => 'BA',
        ],
        [
            'name' => 'Ceará',
            'short' => 'CE',
        ],
        [
            'name' => 'Distrito Federal',
            'short' => 'DF',
        ],
        [
            'name' => 'Espírito Santo',
            'short' => 'ES',
        ],
        [
            'name' => 'Goiás',
            'short' => 'GO',
        ],
        [
            'name' => 'Maranhão',
            'short' => 'MA',
        ],
        [
            'name' => 'Minas Gerais',
            'short' => 'MG',
        ],
        [
            'name' => 'Mato Grosso do Sul',
            'short' => 'MS',
        ],
        [
            'name' => 'Mato Grosso',
            'short' => 'MT',
        ],
        [
            'name' => 'Pará',
            'short' => 'PA',
        ],
        [
            'name' => 'Paraíba',
            'short' => 'PB',
        ],
        [
            'name' => 'Pernambuco',
            'short' => 'PE',
        ],
        [
            'name' => 'Piauí',
            'short' => 'PI',
        ],
        [
            'name' => 'Paraná',
            'short' => 'PR',
        ],
        [
            'name' => 'Rio de Janeiro',
            'short' => 'RJ',
        ],
        [
            'name' => 'Rio Grande do Norte',
            'short' => 'RN',
        ],
        [
            'name' => 'Rondônia',
            'short' => 'RO',
        ],
        [
            'name' => 'Roraima',
            'short' => 'RR',
        ],
        [
            'name' => 'Rio Grande do Sul',
            'short' => 'RS',
        ],
        [
            'name' => 'Santa Catarina',
            'short' => 'SC',
        ],
        [
            'name' => 'Sergipe',
            'short' => 'SE',
        ],
        [
            'name' => 'São Paulo',
            'short' => 'SP',
        ],
        [
            'name' => 'Tocantins',
            'short' => 'TO',
        ],
    ];

    public function run(): void
    {
        foreach ($this->states as $state) {
            $stateExists = State::where('name', $state['name'])
                ->first();
            if (!$stateExists) {
                State::create(
                    $state
                );
            } else {
                $stateExists = State::where('name', $state['name'])
                    ->update($state);
            }
        }
    }
}
