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
use App\Usuario;
use App\CheckAposta;
use App\ApostaTO;

class ApostaController extends Controller
{
    public function cadastro(Request $request)
    {

        $this->validate($request, [
            'telefone' => 'required | integer | digits_between:9,11',
            // 'usuario_id' => 'required | integer | digits_between:1,10',
            'nome' => ['nullable', 'regex:/^[\pL\s]+$/u'],
            'rodada_id' => 'required | integer',
            'times' => 'required | array | size:4'
        ]);

        $celular = $request->input('telefone');
        $nome = $request->input('nome');

        $usuario = Usuario::select('*')->where('celular', $celular)->first();

        if (is_null($usuario)) {
            if (is_null($nome)) {
                return response()->json(['Error' => 'Por favor informe seu nome para fazer o cadastro'], 404);
            }
            $usuario = new Usuario();
            $usuario->nome = $request->input('nome');
            $usuario->celular = $celular;
            $usuario->save();
        }

        $jogos = $request->input('times');

        $idsJogos = [];
        $idsTimes = [];

        foreach ($jogos as $key => $value) {
            $jogo = Jogo::find($value['idJogo']);
            if ($jogo == null) {
                return response()->json(['Error' => 'Dados informados incorretos'], 404);
            }

            if ($value['idTime'] != $jogo->equipe_casa && $value['idTime'] != $jogo->equipe_visitante) {
                return response()->json(['error' => 'Dados informados incorretos'], 404);
            }
            array_push($idsJogos, $value['idJogo']);
            array_push($idsTimes, $value['idTime']);
        }

        sort($idsJogos);
        sort($idsTimes);

        $chave_aposta = '';

        $jogoFrequency = array_count_values($idsJogos);

        foreach ($jogoFrequency as $key => $value) {
            if ($value > 1) {
                return response()->json(['Error' => 'Dados informados incorretos'], 400);
            }
        }

        foreach ($idsJogos as $key => $value) {
            $chave_aposta = $chave_aposta.''.$value.'-';
        }

        foreach ($idsTimes as $key => $value) {
            $chave_aposta = $chave_aposta.''.$value.'-';
        }

        try {
            $checkAposta = new CheckAposta();
            $checkAposta->rodada_id = $request->input('rodada_id');
            $checkAposta->chave_aposta = $chave_aposta;
            $checkAposta->save();
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Aposta já feita, crie uma combinação de times diferente'], 500);
        }

        try {

            $aposta = new Aposta();
            $aposta->usuario_id = $usuario->id;
            $aposta->rodada_id = $request->input('rodada_id');
            
            $aposta->save();

        } catch(\Illuminate\Database\QueryException $e) {
            DB::table('check_aposta')->where('id',$checkAposta->id)->delete();
            return response()->json(['error' => 'Occoreu um problema ao salvar a aposta, por favor tente mais tarde'], 500);
        }

        $apostaJogoList = [];

        foreach ($jogos as $key => $value) {
            $apostaJogo = new ApostaJogo();
            $apostaJogo->jogo_id = $value['idJogo'];
            $apostaJogo->time_id = $value['idTime'];
            array_push($apostaJogoList, $apostaJogo);
        }
        
        foreach ($apostaJogoList as $key => $value) {
            $aposta->jogoAposta()->attach($value->jogo_id, ['equipe_id' => $value->time_id]);
        }

        return response()->json(['aposta' => $aposta], 201);
    }

    private function getApostas($ids) {
        $apostas = DB::table('apostas')
            ->join('usuarios', 'apostas.usuario_id', '=', 'usuarios.id')
            ->join('jogo_aposta', 'apostas.id', '=', 'jogo_aposta.aposta_id')
            ->join('equipes', 'jogo_aposta.equipe_id', '=', 'equipes.id')
            ->join('rodadas', 'apostas.rodada_id','=','rodadas.id')
            ->select('apostas.id','apostas.created_at','usuarios.nome','usuarios.celular', 'rodadas.id as rodadaId',
            'usuarios.nome','equipes.nome AS equipe', 'rodadas.nome AS rodada');
            if (isset($ids)) {
                $apostas = $apostas->where('rodadas.id',  $ids)
                ->get();
            } else {
                $apostas = $apostas->get();
            }
        return $apostas;
    }



    public function buscar(Request $request) {

        $this->validate($request, [
            'nome' => 'nullable | max:30',
            'ids' => 'nullable | integer | digits_between:1,6'
        ]);

        $ids = json_decode($request->input('ids'));

        try {
            
            $apostas = $this->getApostas($ids);
            
            $result = [];
            foreach ($apostas as $key => $value) {
                $isExist = array_key_exists($value->id, $result);
                if ($isExist) {
                    array_push($apostaTO->equipes, $value->equipe);
                } else {
                    $apostaTO = new ApostaTO();
                    $apostaTO->id = $value->id;
                    $apostaTO->nome = $value->nome;
                    $apostaTO->rodada = $value->rodada;
                    $apostaTO->created_at = $value->created_at;
                    $apostaTO->celular = $value->celular;
                    array_push($apostaTO->equipes, $value->equipe);
                    $result[$value->id] = $apostaTO;
                }
            }

            $transformedResult = [];
            foreach ($result as $key => $value) {
                array_push($transformedResult, $value);
            }
        } catch(Exception $e) {
            return response()->json(['error' => 'Ocorreu um problema ao buscar as apostas'], 500);
        }

        return response()->json($transformedResult, 200);

    }

    public function ranking($rodada_id) {

        if(!is_numeric($rodada_id) || null == $rodada_id) {
            return response()->json(['error' => 'Id rodada inválido'], 404);
        }

        try {

            $ranking = Aposta::select(  "id", 
                                    "pontuacao",
                                    "saldo_gol",
                                    "created_at",
                                    "usuario_id"
                                )
                        ->where('rodada_id', $rodada_id)
                        ->orderBy('pontuacao', 'DESC')
                        ->orderBy('saldo_gol', 'DESC')
                        ->orderBy('created_at', 'ASC')
                        ->with('usuario')
                        ->get();

            return $ranking;
            
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Ocorreu um problema ao buscar ao ranking da rodada'], 500);
        }
    }

    public function getApostaPorId($id) {
        $aposta = Aposta::find($id);
        return $aposta;
    }
}
