@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-events-container">
    <h1>Meus Eventos</h1>
</div>

<div class="col-md-10 offset-md-1 dashboard-events-container">
    <p>Você ainda não tem eventos <a title="criar evento" href="/events/create">Criar Evento</a></p>
</div>

@endsection