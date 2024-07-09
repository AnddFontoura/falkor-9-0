@extends('layouts.adminlte')

@section('content_adminlte')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.team-player.index', $team->id) }}"
                        class="btn btn-primary w-100"
                    >
                        Lista de jogadores
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.team.manage', $team->id) }}"
                        class="btn bg-purple color-palette w-100"
                    >
                        Administrar Time
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ route('system.t-s-p.save', $team->id)  }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mt-3 form-group">
                                <span> Aparecer na lista de times procurando jogador? </span>
                                <select name="allowApplication" class="form-control">
                                    <option value="0" @if($team->allow_application == 0) selected @endif> Não </option>
                                    <option value="1" @if($team->allow_application == 1) selected @endif> Sim </option>
                                </select>
                            </div>

                            @foreach($gamePositions as $gamePosition)
                                @php
                                    $checked = in_array($gamePosition->id, $teamSearchPositions)
                                    ? 'checked'
                                    : '';
                                @endphp
                                <div class="col-sm-6 col-md-4 col-lg-3 mt-3 form-check">
                                    <input
                                        type="checkbox"
                                        name="gamePositionId[]"
                                        value="{{ $gamePosition->id }}"
                                        class="form-check-input"
                                        {{ $checked }}
                                    >
                                    <label class="form-check-label">
                                        {!! $gamePosition->icon !!} {{ $gamePosition->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="submit"
                            class="btn btn-success"
                            value="Abrir procura por jogadores"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page_js')
@endsection

