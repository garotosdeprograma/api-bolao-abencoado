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

    // public function edit(Request $request, $id)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'estadio' => 'between:3, 100',
    //         'equipe_casa' => 'integer',
    //         'equipe_visitante' => 'integer',
    //         'campeonato_id' => 'integer',
    //         'rodada_id' => 'integer',
    //         'inicio' => 'date',
    //         'fim' => 'date',
    //         'gol_casa' => 'integer | max: 20',
    //         'gol_visitante' => 'integer | max: 20',
    //     ], $message = [
    //         'estadio.between' => 'O campo estádio aceita entre 3 e 100 carateres',
    //         'equipe_casa.integer' => 'o campo equipe casa aceita apenas inteiros',
    //         'equipe_casa.integer' => 'o campo equipe visitante aceita apenas inteiros',
    //         'inicio.date' => 'O formato do campo inicio deve ser date',
    //         'fim.date' => 'O formato do campo fim deve ser date',
    //         'gol_casa.integer' => 'O campo gol casa aceita apenas numeros interios',
    //         'gol_casa.max' => 'O campo gol casa não pode ser superior a 20',
    //         'gol_visitante.integer' => 'O campo gol visitante aceita apenas numeros interios',
    //         'gol_visitante.max' => 'O campo gol visitante não pode ser superior a 20',
    //         'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios',
    //         'rodada_id.integer' => 'O id do rodada aceita apenas numeros interios'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     if ($id == null) {
    //         return response()->json(['error' => 'O id da rodada não foi informado']);
    //     }

    //     $jogo = Jogo::find($id);

    //     if ($jogo == null) {
    //         return response()->json(['Error' => 'jogo não encontrado'], 400);
    //     }

    //     if ($request->input('estadio') != null) {
    //         $jogo->estadio = $request->input('estadio');
    //     }

    //     if ($request->input('inicio') != null) {
    //         $jogo->inicio = $request->input('inicio');
    //     }

    //     if ($request->input('fim') != null) {
    //         $jogo->fim = $request->input('fim');
    //     }
        
    //     if ($request->input('campeonato_id') != null) {
    //         $jogo->campeonato_id = $request->input('campeonato_id');
    //     }

    //     if ($request->input('rodada_id') != null) {
    //         $jogo->rodada_id = $request->input('rodada_id');
    //     }

    //     if ($request->input('equipe_casa') != null) {
    //         $jogo->equipe_casa = $request->input('equipe_casa');
    //     }

    //     if ($request->input('equipe_visitante') != null) {
    //         $jogo->equipe_visitante = $request->input('equipe_visitante');
    //     }


    //     if ($request->input('gol_casa') != null) {
    //         $jogo->gol_casa = $request->input('gol_casa');
    //     }

    //     if ($request->input('gol_visitante') != null) {
    //         $jogo->gol_visitante = $request->input('gol_visitante');
    //     }

    //     $jogo->save();
        
    //     return response()->json(['jogo' => $jogo], 200);
        
    // }

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
