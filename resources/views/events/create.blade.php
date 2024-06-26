@extends('layouts.main')

@section('title', 'Criando evento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie seu evento</h1>
    <form action="/events" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="image">Imagem do evento: </label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="title">Evento: </label>
            <input type="text" class="form-control" id="title" name="title" Placeholder="Nome do evento">
        </div>
        <div class="form-group">
            <label for="date">Data do evento: </label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div class="form-group">
            <label for="cidade">Cidade: </label>
            <input type="text" class="form-control" id="cidade" name="city" Placeholder="Cidade do evento">
        </div>
        <div class="form-group">
            <label for="title">O evento é privado? </label>
            <select name="private" id="private" class="form-control">
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição: </label>
            <textarea name="description" id="description" class="form-control" Placeholder="Detalhes do evento">
            </textarea>
        </div>
        <div class="form-group">
            <label>Adicione itens de infraestrutura: </label>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Cadeiras" > Cadeiras
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Palco" > Palco
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Cerveja Grátis" > Cerveja Grátis
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Open Food" > Open Food
            </div>
            <div class="form-group">
                <input type="checkbox" name="items[]" value="Brindes" > Brindes
            </div>
        </div>
        <input value="Criar Evento" type="submit" class="btn btn-primary">
    </form>
</div>

@endsection