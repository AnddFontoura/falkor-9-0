<?php

namespace App\Http\Service;

use Carbon\Carbon;

class DateService
{
    public function getRegistrationTime(object $model): string
    {
        $data_atual = new Carbon();
        $data_criacao = new Carbon();

        $tempo_diff = $data_atual->diff($data_criacao);
        $tempo_de_user = '';
        
        return $this->calculateRegistrationTime($tempo_diff, $tempo_de_user);
    }

    protected function calculateRegistrationTime($tempo_diff, $tempo_de_user): string
    {
        if($tempo_diff->y > 0) {
            $tempo_de_user .= $tempo_diff->y . ' anos, ';
        } 

        if($tempo_diff->m > 0) {
            $tempo_de_user .= $tempo_diff->m . ' meses, ';
        }

        if($tempo_diff->d > 0) {
            $tempo_de_user .= $tempo_diff->d . ' dias, ';
        }

        if($tempo_diff->h > 0) {
            $tempo_de_user .= $tempo_diff->h . ' horas, ';
        }
        
        if($tempo_diff->i > 0) {
            $tempo_de_user .= $tempo_diff->i . ' minutos, ';
        }

        if($tempo_diff->s > 0) {
            $tempo_de_user .= $tempo_diff->s . ' segundos';
        }
        return $tempo_de_user;
    }
}