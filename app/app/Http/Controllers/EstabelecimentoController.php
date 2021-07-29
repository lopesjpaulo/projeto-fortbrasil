<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EstabelecimentoService;
use App\Traits\ApiResponser;
use App\Traits\ConsumesExternalServices;

class EstabelecimentoController extends Controller
{
    use ApiResponser, ConsumesExternalServices;

    public $estabelecimentoService;

    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    /**
     * Cria um estabelecimento
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = $this->estabelecimentoService->criarEstabelecimento($request);

        if (isset($response)) {
            return $this->successResponse(['success' => true, 'data' => $response]);
        }

        return $this->errorResponse($response, $response['code']);
    }

    /**
     * Recupera lista dos estabelecimentos
     * 
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $response = $this->estabelecimentoService->recuperarEstabelecimentos();

        if(isset($response)) {
            return $this->successResponse(['success' => true, 'data' => $response]);
        }

        return $this->errorResponse($response, $response['code']);
    }

    /**
     * Atualiza um estabelecimento pelo id
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $response = $this->estabelecimentoService->atualizaEstabelecimento($request, $id);

        if(isset($response['success'])) {
            return $this->errorResponse('Houve um problema ao atualizar', $response['code']);
        }

        return $this->successResponse($response);
    }

    /**
     * Exclui um estabelecimento pelo id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $response = $this->estabelecimentoService->excluiEstabelecimento($id);

        if($response['success']) {
            return $this->successResponse(['success' => true, 'id' => $response]);
        }

        return $this->errorResponse('Houve um problema ao excluir', $response['code']);
    }

    /**
     * Busca estabelecimento pelo cep
     * 
     * @param string $cep
     * @return array
     */
    public function buscaCep(string $cep)
    {
        $response = $this->estabelecimentoService->buscaLocalizacao($cep);

        if(isset($response)) {
            return $this->successResponse(['success' => true, 'data' => $response]);
        }

        return $this->errorResponse('Houve um problema ao excluir', $response['code']);
    }
}
