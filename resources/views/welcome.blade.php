@extends('layouts.main')

@section('title', 'Titulo de teste')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque um evento</h1>
    <form action="/" method="get">
        <input type="text" name="search" id="search" class="form-control" placeholder="Procurar...">
    </form>
</div>

<div id="events-container" class="col-md-12">

    @if($search)
        <h2>Você buscou por: <strong> {{ $search }} </strong></h2>
    @else
        <h2>Próximos eventos</h2>
        <p class="subtitle">Veja os eventos dos proximos dias</p>
    @endif    
    
    <div id="cards-container" class="row">
    @foreach($events as $event)
        <div class="card col-md-3">
            @if($event->image !== "")
            <img class="img-fluid" src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" title="{{ $event->title }}">
            @else
            <img class="img-fluid" src="/img/imagem4.jfif" alt="{{ $event->title }}" title="{{ $event->title }}">
            @endif
            <div class="card-body">
                <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
                <h5 class="card-title">{{ $event->title }}</h5>
                <p class="card-participantes">{{ count( $event->users ) }} Participantes</p>
                <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber Mais</a>                
            </div>
        </div>
    @endforeach
    @if(count($events) == 0 && $search)
        <h3>Não encontramos nenhum evento com o nome: {{ $search }} - <a class="btn" href="/">Ver eventos </a> </h3>
    @elseif(count($events) == 0)
        <h3>Não há eventos disponiveis</h3>
    @endif
    </div>
</div>

@endsection