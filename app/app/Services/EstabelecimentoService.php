<?php

namespace App\Services;


use App\Models\Estabelecimento;
use App\Transformers\EstabelecimentoTransformer;
use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Transformers\ConsumerTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class EstabelecimentoService
{
    /**
     * @var Estabelecimento
     */
    private $estabelecimento;

    private $fractal;

    private $key;

    public function __construct(
        Estabelecimento $estabelecimento
    )
    {
        $this->estabelecimento = $estabelecimento;
        $this->fractal = new Manager();
    }

    /**
     * Valida a requisição para a criação de um estabelecimento
     * 
     * @param \Illuminate\Http\Request $request
     */
    private function validateRequest(Request $request): void
    {
        $rules = [
            'nome'          => 'required|string',
            'cep'           => 'required|string|min:9|max:9',
            'logradouro'    => 'required|string',
            'numero'        => 'required|string',
            'bairro'        => 'required|string',
            'cidade'        => 'required|string',
            'estado'        => 'required|string|max:2',
            'complemento'   => 'string' 
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            throw new ValidationException($validator);
    }

    /**
     * Valida a requisição para a atualização de um estabelecimento
     * 
     * @param \Illuminate\Http\Request $request
     */
    private function validateUpdate(Request $request): void
    {
        $rules = [
            'nome'          => 'string',
            'cep'           => 'string|min:9|max:9',
            'logradouro'    => 'string',
            'numero'        => 'string',
            'bairro'        => 'string',
            'cidade'        => 'string',
            'estado'        => 'string|max:2',
            'complemento'   => 'string' 
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            throw new ValidationException($validator);
    }

    /**
     * Salva o estabelecimento
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function criarEstabelecimento(Request $request): array
    {
        $this->validateRequest($request);

        $estabelecimento = $this->estabelecimento::create($request->all());

        if($estabelecimento) {
            $resource = new Item($estabelecimento, new EstabelecimentoTransformer);
            return $this->fractal->createData($resource)->toArray();
        }

        return ['success' => false, 'code' => 404];
    }

    /**
     * Atualiza o estabelecimento
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array
     */
    public function atualizaEstabelecimento(Request $request, int $id): array
    {
        $this->validateUpdate($request);

        if(!$this->estabelecimento->find($id)) return ['success'  => false, 'code' => 404];

        $estabelecimento_id = $this->estabelecimento::find($id)->update($request->all());

        if($estabelecimento_id) {
            $resource = new Item($this->estabelecimento::find($id), new EstabelecimentoTransformer); 
            return $this->fractal->createData($resource)->toArray();
        }

        return ['success' => false, 'code' => 400];
    }

    /**
     * Exclui um estabelecimento
     */
    public function excluiEstabelecimento(int $id)
    {
        if(!$this->estabelecimento->find($id)) return ['success'  => false, 'code' => 404];

        $estabelecimento_id = $this->estabelecimento::destroy($id);

        if($estabelecimento_id) {
            return ['success' => true, 'code' => 200];
        }

        return ['success' => false, 'code' => 400];
    }

    /**
     * Recupera dados dos estabelecimentos
     * 
     * @return array
     */
    public function recuperarEstabelecimentos()
    {
        $paginator = Estabelecimento::paginate();
        $consumers = $paginator->getCollection();
        $resource = new Collection($consumers, new EstabelecimentoTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * Recupera dados do estabelecimento pelo CEP
     */
    public function buscaLocalizacao(string $cep)
    {
        if(!isset($cep))
        {
            return ['success' => false, 'code' => 400];
        }

        $estabelecimento = $this->estabelecimento::where('cep', $cep)->first();

        if($estabelecimento) {
            $resource = new Item($estabelecimento, new EstabelecimentoTransformer);
            return $this->fractal->createData($resource)->toArray();
        }

        return ['success' => false, 'code' => 404];
    }
}
