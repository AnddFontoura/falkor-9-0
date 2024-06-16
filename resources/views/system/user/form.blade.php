@extends('layouts.adminlte')

@section('content_adminlte')
    <div class="row">
        <div class="col-12 mt-3">
            <form action="{{ route('system.user.update') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Atualizar dados cadastrais e Configurações
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <span> Nome do usuário </span>
                                    <input class="form-control" type="text" required maxlength="255" value="{{ old('name') ?? $user->name }}" name="name">
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <span> Linguagem </span>
                                    <select name="language" class="form-control">
                                        @foreach($languages as $key => $lang)
                                            @php
                                                $user->language == $key ? $selected = 'selected' : $selected = '';
                                            @endphp

                                            <option value="{{$key}}" {{ $selected }}>{{$lang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input type="submit" class="btn btn-success" value="Atualizar configurações">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
