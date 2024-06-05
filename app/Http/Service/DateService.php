<?php

namespace App\Http\Service;

use Carbon\Carbon;

class DateService
{
    public function toHuman(Carbon $date): string
    {
        Carbon::setLocale('pt_BR');

        return $date->diffForHumans([
            'parts' => 3, //mostra ate 3 unidades de tempo
            'join' => true, //junta as unidades com 'e'
            'short' => false, //usa a forma completa, nao abreviada
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW // formato relativo ao agora
        ]);
    }
}
