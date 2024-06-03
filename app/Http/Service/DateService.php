<?php

namespace App\Http\Service;

use Carbon\Carbon;

class DateService
{
    public function getRegistrationTime(object $model): string
    {
        Carbon::setLocale('pt_BR');
        
        $creationDate = new Carbon($model->created_at);

        return $accountTime = $creationDate->diffForHumans([
            'parts' => 3, //mostra ate 3 unidades de tempo
            'join' => true, //junta as unidades com 'e'
            'short' => false, //usa a forma completa, nao abreviada
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW // formato relativo ao agora
        ]);
    }

    public function getPlanFinishDate(object $model)
    {
        Carbon::setLocale('pt_BR');

        $finishDate = new Carbon($model->finish_date);

        return $planFinishDate = $finishDate->diffForHumans([
            'parts' => 3, //mostra ate 3 unidades de tempo
            'join' => true, //junta as unidades com 'e'
            'short' => false, //usa a forma completa, nao abreviada
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW // formato relativo ao agora
        ]);
    }
}