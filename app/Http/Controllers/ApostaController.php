<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Aposta;
use App\Jogo;
use App\Rank;
use App\Equipe;
use App\ApostaJogo;

class ApostaController extends Controller
{
    public function cadastro(Request $request)
    {

        $this->validate($request, [
            'usuario_id' => 'required | integer',
            'rodada_id' => 'required | integer',
            'premio' => 'required | numeric',
            'jogo_1' => 'required | integer',
            'jogo_2' => 'required | integer',
            'jogo_3' => 'required | integer',
            'jogo_4' => 'required | integer',
            'time_1' => 'required | integer',
            'time_2' => 'required | integer',
            'time_3' => 'required | integer',
            'time_4' => 'required | integer',
            'aposta_pago' => 'required | boolean',
        ]);

        $jogo1 = Jogo::find($request->input('jogo_1'));
        if ($jogo1 == null) {
            return response()->json(['Essa aposta consta jogo(s) inexistente no sistema'], 400);
        }

        if ($request->input('time_1') != $jogo1->equipe_casa && $request->input('time_1') != $jogo1->equipe_visitante) {
            return response()->json(['error' => 'Dados da aposta inválidos']);
        }

        $jogo2 = Jogo::find($request->input('jogo_2'));
        if ($jogo2 == null) {
            return response()->json(['Essa aposta consta jogo(s) inexistente no sistema'], 400);
        }

        if ($request->input('time_2') != $jogo2->equipe_casa && $request->input('time_2') != $jogo2->equipe_visitante) {
            return response()->json(['error' => 'Dados da aposta inválidos']);
        }

        $jogo3 = Jogo::find($request->input('jogo_3'));
        if ($jogo3 == null) {
            return response()->json(['Essa aposta consta jogo(s) inexistente no sistema'], 400);
        }

        if ($request->input('time_3') != $jogo3->equipe_casa && $request->input('time_3') != $jogo3->equipe_visitante) {
            return response()->json(['error' => 'Dados da aposta inválidos']);
        }

        $jogo4 = Jogo::find($request->input('jogo_4'));
        if ($jogo4 == null) {
            return response()->json(['Essa aposta consta jogo(s) inexistente no sistema'], 400);
        }

        if ($request->input('time_4') != $jogo4->equipe_casa && $request->input('time_4') != $jogo4->equipe_visitante) {
            return response()->json(['error' => 'Dados da aposta inválidos']);
        }

        $idsJogos = [];
        $idsTimes = [];
            
        array_push($idsJogos, $request->input('jogo_1'));
        array_push($idsJogos, $request->input('jogo_2'));
        array_push($idsJogos, $request->input('jogo_3'));
        array_push($idsJogos, $request->input('jogo_4'));
        array_push($idsTimes, $request->input('time_1'));
        array_push($idsTimes, $request->input('time_2'));
        array_push($idsTimes, $request->input('time_3'));
        array_push($idsTimes, $request->input('time_4'));

        sort($idsJogos);
        sort($idsTimes);

        $chave_aposta = '';

        $jogoFrequency = array_count_values($idsJogos);

        foreach ($jogoFrequency as $key => $value) {
            if ($value > 1) {
                return response()->json(['Não pode escolher duas vezes o mesmo jogo'], 400);
            }
        }

        foreach ($idsJogos as $key => $value) {
            $chave_aposta = $chave_aposta.''.$value.'-';
        }

        foreach ($idsTimes as $key => $value) {
            $chave_aposta = $chave_aposta.''.$value.'-';
        }

        try {
            $checkAposta = DB::table('check_aposta')->insert(
                ['rodada_id' => $request->input('rodada_id'), 'chave_aposta' => $chave_aposta]
            );
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Combinação já escolhida'], 500);
        }


        try {

            $aposta = new Aposta();
            $aposta->usuario_id = $request->input('usuario_id');
            $aposta->premio = $request->input('premio');
            $aposta->aposta_pago = $request->input('aposta_pago');
            $aposta->rodada_id = $request->input('rodada_id');
            
            $aposta->save();

        } catch(\Illuminate\Database\QueryException $e) {
            DB::table('check_aposta')->where('id',$checkAposta->id)->delete();
            return response()->json(['error' => 'Occoreu um problema ao salvar a aposta, por favor tente mais tarde'], 500);
        }

        $apostaJogoList = [];

        $apostaJogo1 = new ApostaJogo();
        $apostaJogo1->jogo_id = $request->input('jogo_1');
        $apostaJogo1->time_id = $request->input('time_1');
        array_push($apostaJogoList, $apostaJogo1);

        $apostaJogo2 = new ApostaJogo();
        $apostaJogo2->jogo_id = $request->input('jogo_2');
        $apostaJogo2->time_id = $request->input('time_2');
        array_push($apostaJogoList, $apostaJogo2);

        $apostaJogo3 = new ApostaJogo();
        $apostaJogo3->jogo_id = $request->input('jogo_3');
        $apostaJogo3->time_id = $request->input('time_3');
        array_push($apostaJogoList, $apostaJogo3);

        $apostaJogo4 = new ApostaJogo();
        $apostaJogo4->jogo_id = $request->input('jogo_4');
        $apostaJogo4->time_id = $request->input('time_4');
        array_push($apostaJogoList, $apostaJogo4);
        
        foreach ($apostaJogoList as $key => $value) {
            $aposta->jogoAposta()->attach($value->jogo_id, ['equipe_id' => $value->time_id]);
        }

        return response()->json(['aposta' => $aposta], 201);
    }

    public function buscar($id_rodada) {

        if(!is_numeric($id_rodada)) {
            return response()->json(['error' => 'Id rodada inválido'], 404);
        }

        try {
            $apostas = Aposta::select(  "id",
                                    "aposta_pago",
                                    "premio",
                                    'rodada_id',
                                    "usuario_id",
                                    "created_at",
                                    "updated_at"
                                );
            
            if (null != $rodada_id) {
                $aposta->where('rodada_id', $rodada_id);
            }

            $apostas = $apostas
                        ->orderBy('created_at', 'DESC')
                        ->with('jogoAposta')
                        ->paginate();
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Ocorreu um problema ao buscar as apostas'], 500);
        }

        return response()->json($apostas, 200);

    }

    public function ranking($rodada_id) {

        if(!is_numeric($rodada_id) || null == $rodada_id) {
            return response()->json(['error' => 'Id rodada inválido'], 404);
        }

        try {

            $apostas = Aposta::select(  "id",
                                    'aposta_pago',
                                    'usuario_id',    
                                    'premio',
                                    'rodada_id',
                                    "created_at",
                                    "updated_at"
                                )
                        ->where('rodada_id', $rodada_id)
                        ->orderBy('created_at', 'DESC')
                        ->with('usuario')
                        ->with('jogoAposta')
                        ->get();

            $ranking = [];

            foreach ($apostas as $key => $aposta) {
                $rank = new Rank();
                $rank->nome = $aposta->usuario->nome.' '.$aposta->usuario->sobrenome;
                $rank->celular = $aposta->usuario->celular;
                return response()->json($aposta, 200);
                foreach ($aposta->jogo_aposta as $key => $jogo) {
                    $result = $jogo->equipe_casa - $jogo->equipe_visitante;
                    if ($result = 0) {
                        $rank->ponto += 1;
                    }
                    if ($result > 0) {
                        if ($jogo->equipe_casa == $jogo->pivot->equipe_id) {
                            $rank->ponto += 1;
                        }
                    }
                }
                array_push($ranking, $rank);
            }

            return response()->json($apostas, 200);
            
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Ocorreu um problema ao buscar ao ranking da rodada'], 500);
        }

    }
}
