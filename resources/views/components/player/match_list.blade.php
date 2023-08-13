@php

@endphp

<ul>
@foreach($teamPlayers as $player)
    <li> {{ $player->name }} </li>
@endforeach
</ul>