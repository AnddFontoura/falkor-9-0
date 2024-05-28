<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    use WithoutModelEvents;

    /*
        Esses planos são exemplos, estão aqui para finalidades de teste no momento.
    */
    protected array $plans = [
        [
            'name' => 'Dente de Leite - Plano Grátis',
            'description' =>
                '
                    <p> Você pode criar seu perfil de atleta, consultar outros perfis, utilizar a plataforma normalmente </p>
                    <p> Pode criar e gerenciar até 3 times. </p>
                    <p> Não pode criar campeonatos mas pode ter seu time incluido em um campeonato pelo administrador </p>
                ',
            'slug' => 'free-plan',
            'duration_days' => '0',
            'durations_months' => '12',
            'price' => 0.00,
            'features' => [
                'teams' => 3,
                'team.finances' => false,
                'team.status' => false,
                'championship' => false,
                'field' => false,
            ],
            'active' => true,
        ],
        [
            'name' => 'Bola de capotão - Plano Básico',
            'description' =>
                '
                    <p> Tudo que o plano grátis pode fazer </p>
                    <p> Pode criar e gerenciar até 6 times e ganha acesso a gestão financeira da sua equipe </p>
                ',
            'slug' => 'basic-plan',
            'duration_days' => '0',
            'durations_months' => '1',
            'price' => 5.50,
            'features' => [
                'teams' => 7,
                'team.finances' => true,
                'team.status' => false,
                'championship' => false,
                'field' => false,
            ],
            'active' => false,
        ],
        [
            'name' => 'Bola de Gomo - Plano Médio',
            'description' =>
                '
                    <p> Tudo que o plano básico pode fazer </p>
                    <p> Pode criar e gerenciar até 9 times e ganha acesso a gestão individual da sua equipe </p>
                ',
            'slug' => 'medium-plan',
            'duration_days' => '0',
            'durations_months' => '1',
            'price' => 11.00,
            'features' => [
                'teams' => 7,
                'team.finances' => true,
                'team.status' => true,
                'championship' => false,
                'field' => false,
            ],
            'active' => false,
        ],
        [
            'name' => 'Bola de Ouro - Plano Máximo',
            'description' =>
                '
                    <p> Tudo que o plano básico pode fazer </p>
                    <p> Pode criar e gerenciar até 12 times </p>
                    <p> Pode criar e gerenciar campeonatos </p>
                    <p> Pode criar e gerenciar quadras e campos </p>
                ',
            'slug' => 'maximum-plan',
            'duration_days' => '0',
            'durations_months' => '1',
            'price' => 15.00,
            'features' => [
                'teams' => 7,
                'team.finances' => true,
                'team.status' => true,
                'championship' => true,
                'field' => true,
            ],
            'active' => false,
        ],
    ];

    public function run(): void
    {
        foreach($this->plans as $plan) {
            $features = json_encode($plan['features']);
            $plan['features'] = $features;

            Plan::updateOrCreate(
                [
                    'slug' => $plan['slug'],
                ],
                $plan
            );
        }
    }
}
