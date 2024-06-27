@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        // Ajusta os dados para exibir no formulario antes de exibir
        $fieldValue = $fieldValueInfo->value ?? old('fieldValue');
        $refereeValue = $refereeValueInfo->value ?? old('refereeValue');
        $otherValue = $otherValueInfo->value ?? old('otherValue');
        $otherDescription = $otherValueInfo->description ?? old('otherDescription');
    @endphp
    <div class="row">
        <div class="col-12 mt-3">
            <form action="{{ route('system.team-finance.matches.save', [$team->id, $matchId]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                                <div class="col-12 alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                           <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                               <h1 class="border-bottom"> Dados do Campo </h1>

                               <div class="form-group mt-3">
                                   <span> Valor do campo </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0000,00"
                                        pattern="[0-9]{1,6},[0-9]{1,2}"
                                        name="fieldValue"
                                        value="{{ $fieldValue }}"
                                    >
                               </div>

                               <div class="form-group mt-3">
                                   <span> Valor da arbitragem </span>
                                   <input
                                       type="text"
                                       class="form-control"
                                       placeholder="0000,00"
                                       pattern="[0-9]{1,6},[0-9]{1,2}"
                                       name="refereesValue"
                                       value="{{ $refereeValue }}"
                                   >
                               </div>

                               <div class="form-group mt-3">
                                   <span> Outros custos </span>
                                   <input
                                       type="text"
                                       class="form-control"
                                       placeholder="0000,00"
                                       pattern="[0-9]{1,6},[0-9]{1,2}"
                                       name="otherValue"
                                       value="{{ $otherValue }}"
                                   >

                                   <span> Descrição dos outros custos </span>
                                   <textarea
                                       class="form-control"
                                       name="otherDescription"
                                   >{!! $otherDescription !!}
                                   </textarea>
                               </div>
                           </div>

                            <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                                <h1 class="border-bottom"> Dados dos jogadores </h1>
                                @if(count($teamMatchPlayers) == 0)
                                    <div class="alert alert-danger">
                                        Nenhum jogador incluido nessa partida
                                    </div>
                                @else
                                    <table class="table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="w-25 p-3"> Valor </th>
                                                <th class="w-50 p-3"> Nome </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teamMatchPlayers as $player)
                                                @php
                                                    $value = $player->finance_value
                                                    ?? old('teamPlayerId[' . $player->teamPlayerInfo->id . ']');

                                                    $value = str_replace('.', ',', $value);
                                                @endphp
                                                <tr>
                                                    <td class="p-3">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="0000,00"
                                                            pattern="[0-9]{1,6},[0-9]{1,2}"
                                                            name="teamPlayerId[{{$player->teamPlayerInfo->id}}]"
                                                            value="{{ $value }}"
                                                        >
                                                    </td>
                                                    <td class="p-3">
                                                        {{ $player->teamPlayerInfo->name }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="submit"
                            class="btn btn-success"
                            value="{{ __('team_finances.buttons.save_match_finance') }}"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
