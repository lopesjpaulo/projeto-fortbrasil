<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    /** 
     * Table name.
     */
    protected $table = 'estabelecimento';

    /** 
     * Primary key.
     */
    protected $primaryKey = 'estabelecimento_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'created_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
