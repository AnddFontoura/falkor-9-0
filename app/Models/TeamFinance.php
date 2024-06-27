<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamFinance extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'team_finances';

    public $fillable = [
        'team_id',
        'match_id',
        'team_player_id',
        'description', //descricao do pagamento, para controle interno
        'value', //Valor em float
        'method', //Método de pamgamento boleto - cartoa - dinheiro - pix
        'type', //tipo de pagamento, se é débito (0) de valor ou crédito (1) de valor
        'origin', //Origem do pagamento, campo, arbitro, bola, mensalidade, outros
    ];

    public function teamInfo(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function teamPlayerInfo(): HasOne
    {
        return $this->hasOne(TeamPlayer::class, 'id', 'team_player_id');
    }
    public function matchInfo(): HasOne
    {
        return $this->hasOne(Matches::class, 'id', 'match_id');
    }
}
