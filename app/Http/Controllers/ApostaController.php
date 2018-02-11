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

    public function buscar(Request $request) {

        $this->validate($request, [
            'nome' => 'nullable | max:30'
        ]);

        try {
            $apostas = Aposta::select('*');
            
            if (null != $request->input('nome')) {
                $aposta->where('rodada_id', $rodada_id);
            }

            $apostas = $apostas
                        ->orderBy('created_at', 'DESC')
                        ->with(['jogoAposta', 'usuario'])
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
