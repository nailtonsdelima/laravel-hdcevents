<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // 
    protected $casts = [
        'items' => 'array'
    ];

    // Atributo para ser possivel trabalhar com datas e formatações
    protected $dates = ['date'];

    // Atribuição para fazer update em varios campos(tirando a restrição do laravel)
    protected $guarded = [];

    // Atribuição para buscar o dono do evento
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // Especificando que tem varios usuarios no evento
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }



}
