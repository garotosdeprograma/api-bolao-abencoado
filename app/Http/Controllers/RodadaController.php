<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rodada;
use Carbon\Carbon;
use App\JogoTO;
use App\ApostaTO;
use App\Http\Controllers\ApostaController;

class RodadaController extends Controller
{
    public function cadastro(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required | alpha_num | between:3,30',
            'inicio' => 'required | date | before:fim',
            'fim' => 'required | date',
        ]);

        $rodada = new Rodada();
        $rodada->nome = $request->input('nome');
        $rodada->inicio = $request->input('inicio');
        $rodada->fim = $request->input('fim');
        $rodada->save();

        return response()->json(['rodada' => $rodada], 201);
    }

    public function edit(Request $request, $id)
    {
        
        $this->validate($request, [
            'nome' => 'nullable | alpha_num | between:3,30',
            'inicio' => 'date',
            'fim' => 'date | after:inicio',
        ]);

        $rodada = Rodada::find($id);

        if ($rodada == null) {
            return response()->json(['error' => 'Rodada inexistente'], 404);
        }


        if (null != $request->input('nome')) {
            $rodada->nome = $request->input('nome');
        }

        if (null != $request->input('inicio')) {
            $rodada->inicio = $request->input('inicio');
        }

        if (null != $request->input('fim')) {
            $rodada->fim = $request->input('fim');
        }

        $rodada->save();
        
        return response()->json(['rodada' => $rodada], 200);
        
    }

    public function buscar(Request $request) {

        $this->validate($request, [
            'nome' => 'nullable | alpha_num',
            'inicio' => 'nullable | date',
            'fim' => 'nullable | date',
            'limit' => 'nullable | integer | between:1,20'
        ]);

        $limit = $request->input('limit');

        $rodadas = Rodada::select(
            'id',
            'nome',
            'inicio',
            'fim',
            'created_at',
            'updated_at'
        );

        if (null != $request->input('nome')) {
            $rodadas->where('nome', 'like', '%'.$request->input('nome').'%');
        }

        if (null != $request->input('inicio')) {
            $rodadas->whereDate('inicio', '>=', $request->input('inicio'));
        }

        if (null != $request->input('fim')) {
            $rodadas->whereDate('fim', '<=', $request->input('fim'));
        }

        $rodadas = $rodadas->orderBy('inicio', 'ASC');
                if ($limit != null) {
                    $rodadas = $rodadas->paginate($limit);
                } else {
                    $rodadas = $rodadas->paginate(10);
                }

        return response()->json($rodadas, 200);

    }

    private function jogosRodada($id) {
        $rodadas = Rodada::select(
            'id',
            'nome',
            'inicio',
            'fim'
        );

        if(isset($id) && $id != null) {
            $rodadas = $rodadas->where('id', $id);
        }else{
            $rodadas = $rodadas->whereDate('fim', '>', Carbon::now('America/Fortaleza'));
        }
        $rodadas = $rodadas->with(['jogos.equipeCasa', 'jogos.equipeVisitante']);

        $rodadas = $rodadas->with(['jogos' => function($query) {
            $query->whereDate('inicio', '>', Carbon::now('America/Fortaleza'));
        }])->get();

        return $rodadas;
    } 

    public function buscarJogosPorRodada(Request $request) {
        
        $id = $request->query('id');

        $rodadas = $this->jogosRodada($id);
        
        return response()->json($rodadas, 200);
    }

    // private function jogosRodada($id) {
    //     $rodadas = Rodada::select(
    //         'id',
    //         'nome',
    //         'inicio',
    //         'fim'
    //     );

    //     if(isset($id) && $id != null) {
    //         $rodadas = $rodadas->where('id', $id);
    //     }else{
    //         $rodadas = $rodadas->whereDate('fim', '>', Carbon::now('America/Fortaleza'));
    //     }
    //     $rodadas = $rodadas->with(['jogos.equipeCasa', 'jogos.equipeVisitante'])
    //                         ->get();

    //     return $rodadas;
    // } 

    // public function buscarJogosPorRodada(Request $request) {
        
    //     $id = $request->query('id');

    //     $rodadas = $this->jogosRodada($id);
        
    //     return response()->json($rodadas, 200);
    // }

    public function buscarPorId($id) {

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Id inválido'], 404);
        }
        
        return response()->json(['rodada' => $rodada], 200);

    }

    private function groupBy($query) {
        $result = [];
        foreach ($query as $key => $value) {
            $isExist = array_key_exists($value->aposta_id, $result);
            if ($isExist) {
                array_push($result[$value->aposta_id], $value);
            } else {
                $result[$value->aposta_id] = [];
                array_push($result[$value->aposta_id], $value);
            }
        }
        return $result;
    }

    private function getDataAposta ($id) {

        $query = DB::select('SELECT a.id 
            AS aposta_id, a.usuario_id 
            AS usuario_id, jogo_aposta.equipe_id 
            AS equipe_id, jogos.id 
            AS jogo_id, jogos.gol_casa 
            AS gol_casa, jogos.gol_visitante 
            AS gol_visitante, jogos.equipe_casa 
            AS equipe_casa, jogos.equipe_visitante 
            AS equipe_visitante, a.rodada_id 
            AS rodada_id
            FROM (
                SELECT * FROM apostas WHERE apostas.rodada_id = :id
            ) 
            AS a
            JOIN jogo_aposta 
            ON a.id = jogo_aposta.aposta_id 
            JOIN jogos
            ON jogo_aposta.jogo_id = jogos.id', ['id' => $id]);

        return $query;
    }

    public function ranking(Request $request, ApostaController $apostaController) {
        
        $this->validate($request, [
            'nome' => ['nullable', 'regex:/^[a-zA-Z.\/]/'],
            'id' => 'nullable | integer | digits_between:1,6'
        ]);
        
        $id = $request->input('id');

        $query = $this->getDataAposta($id);

        if ($query == null) {
            return response()->json([], 200);
        }

        $result = $this->groupBy($query);

        foreach ($result as $b => $apostas) {
            $pontuacao = 0;
            $saldo_gol = 0;
            
            foreach ($apostas as $c => $aposta) {
                $diffGol = $aposta->gol_casa - $aposta->gol_visitante;
                if ($diffGol == 0) {
                    $pontuacao = $pontuacao + 1;
                    continue;
                }

                if ($diffGol > 0) {
                    if ($aposta->equipe_casa == $aposta->equipe_id) {
                        $pontuacao = $pontuacao + 3;
                        $saldo_gol = $saldo_gol + abs($diffGol);
                        continue;
                    }
                }

                if ($diffGol < 0) {
                    if ($aposta->equipe_visitante == $aposta->equipe_id) {
                        $pontuacao = $pontuacao + 3;
                        $saldo_gol = $saldo_gol + abs($diffGol);
                        continue;
                    }
                }

                $saldo_gol = $saldo_gol - abs($diffGol);
            }

            
            $aposta = $apostaController->getApostaPorId($b);
            $aposta->pontuacao = $pontuacao;
            $aposta->saldo_gol = $saldo_gol;
            $aposta->save();
        }
        $ranking = $apostaController->ranking( $id);
        return response()->json($ranking, 200);
    }

    // public function ranking(Request $request) {
    //     $this->validate($request, [
    //         'nome' => ['nullable', 'regex:/^[a-zA-Z.\/]/'],
    //         'id' => 'nullable | integer | digits_between:1,6'
    //     ]);
        
    //     $id = $request->input('id');
        
    //     $rodada = Rodada::where('id', $id)
    //                     // TODO change inequality sign
    //                     ->whereDate('fim', '>', Carbon::now('America/Fortaleza'))
    //                     ->get();

    //     if (count($rodada) == 0) {
    //         return response()->json(['Error' => 'Rodada ativa']);
    //     }

    //     $result = $this->jogosRodada($id);

    //     $jogos = $result[0]->jogos->toArray();

    //     $winners = [];
    //     $draws = [];

    //     foreach ($jogos as $key => $jogo) {
    //         $jogoTO = new JogoTO();
    //         $jogoTO->id = $jogo['id'];
    //         $jogoTO->saldo_gol = $jogo['gol_casa'] - $jogo['gol_visitante'];
            
    //         if ($jogoTO->saldo_gol == 0) {
    //             array_push($draws, $jogoTO);
    //             continue;
    //         }

    //         if ($jogoTO->saldo_gol > 0) {
    //             $jogoTO->winner = $jogo['equipe_casa']['id'];
    //             $jogoTO->saldo_gol = abs($jogoTO->saldo_gol);
    //             array_push($winners, $jogoTO);
    //         } else {
    //             $jogoTO->winner = $jogo['equipe_visitante']['id'];
    //             $jogoTO->saldo_gol = abs($jogoTO->saldo_gol);
    //             array_push($winners, $jogoTO);
    //         }
    //     }

    //     print_r($winners);die;

    //     // $apostas = DB::table('apostas')
    //     //     ->join('usuarios', 'apostas.usuario_id', '=', 'usuarios.id')
    //     //     ->join('jogo_aposta', 'apostas.id', '=', 'jogo_aposta.aposta_id')
    //     //     ->join('equipes', 'jogo_aposta.equipe_id', '=', 'equipes.id')
    //     //     ->join('rodadas', 'apostas.rodada_id','=','rodadas.id')
    //     //     ->select('apostas.id','apostas.created_at','usuarios.nome','usuarios.celular', 'rodadas.id as rodadaId',
    //     //     'usuarios.nome','equipes.nome AS equipe', 'rodadas.nome AS rodada')
    //     //     ->get();

    //     return response()->json($apostas, 200);

    // }

    // public function buscarJogosPorRodada(Request $request) {

    //     $id = $request->query('id');

    //     if (!is_numeric($id)) {
    //         return response()->json(['error' => 'Id inválido'], 404);
    //     }
        
    //     $rodada = Rodada::select('*')
    //     ->where('id', $id)                
    //     ->with(['jogos.equipeCasa', 'jogos.equipeVisitante'])
    //     ->get();

    //     return response()->json(['rodada' => $rodada], 200);

    // }
}
