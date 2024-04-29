<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    //index action
    public function index(){

        $search = request('search');
        
        if($search){

            $events = Event::where([

                ['title', 'like', '%'. $search . '%']
                
            ])->get();

        }else{

            $events = Event::all();

        }        

        return view('welcome', ['events' => $events, 'search' => $search]);

    }

    //Função para criação de eventos
    public function create(){        

        return view('events.create');
        
    }

    //Função para de contatos
    public function contatos(){

        return view('contact');
        
    }

    //Função para tratar os dados recebidos no formulario
    public function store(Request $request){

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        if($request->hasFile('image') && $request->file('image')->isValid()){

            // Recebendo os dados da imagem enviada no formulario
            $requestImage = $request->image;

            // Pegando a extensao do arquivo enviado
            $extension = $requestImage->extension();

            // Criando o nome do arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            // Movendo a imagem para a pasta definida
            $requestImage->move(public_path('img/events'), $imageName);

            // Estabelecendo o valor no parametro para ser salvo no banco de dados
            $event->image = $imageName;

        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    // Função para buscar um evento especifico
    public function show($id){

        $event = Event::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if($user){

            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }

        }

        //Pegando especificamente o primeiro id de usuario encontrado, trazendo as informações e transformando em array
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);

    }

    //Controlando o dashboard de eventos
    public function dashboard(){

        // Identificando o usuario logado
        $user = auth()->user();

        // Chamando todos os eventos
        $events = $user->events;

        //chamando os eventos que o usuario está participando
        $eventAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventAsParticipant]);

    }

    public function destroy($id){

        // Encontrando o evento pelo id passado pela view
        Event::findOrFail($id)->delete();

        // Redirecionando o usuario após excluir o evento
        return redirect('/dashboard')->with('msg', 'Evento excluido com sucesso');

    }

    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id){
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);

    }

    public function update(Request $request){

        $data = $request->all();

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()){

            // Recebendo os dados da imagem enviada no formulario
            $requestImage = $request->image;

            // Pegando a extensao do arquivo enviado
            $extension = $requestImage->extension();

            // Criando o nome do arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            // Movendo a imagem para a pasta definida
            $requestImage->move(public_path('img/events'), $imageName);

            // Estabelecendo o valor no parametro para ser salvo no banco de dados
            $data['image'] = $imageName;

        }

        // Buscando o id para atualizar os dados pela requisição recebida no Request
        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento atualizado com sucesso!');

    }

    public function joinEvent($id){

        $user = auth()->user();

        // Relacionando o id do usuario logado com o id do evento
        $user->eventsAsParticipant()->attach($id);

        // Procurando pelo evento
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirma no evento ' . $event->title);

    }

    public function leaveEvent($id){

        $user = auth()->user();

        //Saindo do evento
        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu do evento: ' . $event->title);

    }

}
