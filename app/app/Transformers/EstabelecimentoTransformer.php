<?php
namespace App\Transformers;

use App\Models\Estabelecimento;
use League\Fractal;

class EstabelecimentoTransformer extends Fractal\TransformerAbstract
{
	public function transform(Estabelecimento $estabelecimento)
	{
	    return [
	        'estabelecimento_id'      => (int) $estabelecimento->estabelecimento_id,
	        'nome'   => $estabelecimento->nome,
	        'cep'    =>  $estabelecimento->cep,
			'logradouro'    =>  $estabelecimento->logradouro,
	        'numero'    =>  $estabelecimento->numero,
	        'bairro'    =>  $estabelecimento->bairro,
	        'cidade'    =>  $estabelecimento->cidade,
	        'estado'    =>  $estabelecimento->estado,
	        'complemento'    =>  $estabelecimento->complemento,
	        'created_at'    =>  $estabelecimento->created_at->format('d-m-Y'),
	        'updated_at'    =>  $estabelecimento->updated_at != null ? $estabelecimento->updated_at->format('d-m-Y') : null
	    ];
	}
}