<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Aposta;
use App\Jogo;
use App\Equipe;
use App\ApostaJogo;

class ApostaController extends Controller
{
    public function cadastro(Request $request)
    {

        $listaJogosAposta = $request->input('aposta');

        $teamFrequency = array_count_values($listaJogosAposta);

        $apostaJogoList = [];

        foreach ($listaJogosAposta as $key => $value) {
            $jogo = Jogo::find($key);
            if ($jogo == null) {
                return response()->json(['Essa aposta consta jogo(s) inexistente no sistema'], 400);
                break;
            }
            $equipe = Equipe::find($value);
            if ($equipe == null) {
                return response()->json(['Essa aposta consta equipe(s) inexistente no sistema'], 400);
                break;
            }

            $result = array_filter($teamFrequency, function($value) {
                return $value > 2;
            });

            if (sizeof($result) > 0) {
                return response()->json(['Não pode escolher mais de duas vezes o mesmo team'], 400);
                break;
            }
            
            $apostaJogo = new ApostaJogo();
            $apostaJogo->jogo_id = $key;
            $apostaJogo->equipe_id = $value;
            array_push($apostaJogoList, $apostaJogo);

        }

        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required | integer',
            'pagamento' => 'required | numeric',
            'aposta_pago' => 'required | boolean',
        ], $message = [
            'usuario_id.required' => 'O id do usuario efetuando a aposta é necessário',
            'usuario_id.integer' => 'O id do usuário efetuando a aposta deve ser inteiro',
            'pagamento.required' => 'O campo status do pagamento é obrigatório',
            'pagamento.numeric' => 'o campo status do pagamento deve ser numerico',
            'aposta_pago.required' => 'O campo aposta pago é obrigatório',
            'aposta_pago.boolean' => 'o campo aposta pago deve ser booleano',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $aposta = new Aposta();
        $aposta->usuario_id = $request->input('usuario_id');
        $aposta->pagamento = $request->input('pagamento');
        $aposta->aposta_pago = $request->input('aposta_pago');
        
        
        $aposta->save();
        
        foreach ($apostaJogoList as $key => $value) {
            $aposta->jogoAposta()->attach($value->jogo_id, ['equipe_id' => $value->equipe_id]);
        }

        return response()->json(['aposta' => $aposta], 200);
    }

    public function buscar(Request $request) {

        $apostas = Aposta::select(  "id",
                                    "aposta_pago",
                                    "pagamento",
                                    "usuario_id",
                                    "created_at",
                                    "updated_at"
                                );


        $apostas = $apostas
                    ->orderBy('created_at', 'DESC')
                    ->with('jogoAposta')
                    ->get();

        return response()->json(['apostas' => $apostas], 200);

    }

    // public function buscarPorId($id) {

    //     if ($id == null) {
    //         return response()->json(['error' => 'O id do rodada nao foi informado'], 400);
    //     }
        
    //     $jogo = Jogo::find($id);

    //     if ($jogo == null) {
    //         return response()->json(['error' => 'jogo não encontrado'], 400);
    //     }

    //     return response()->json(['jogo' => $jogo], 200);

    // }
}
