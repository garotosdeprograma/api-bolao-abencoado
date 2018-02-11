<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Jogo;
use App\Campeonato;
use App\Equipe;
use Carbon\Carbon;

class JogoController extends Controller
{
    public function cadastro(Request $request)
    {
        $this->validate($request, [
            'id' => 'nullable | integer',
            'estadio' => 'alpha_spaces | between:3, 100',
            'equipe_casa' => 'integer | max:1000',
            'equipe_visitante' => 'integer | max:1000',
            'campeonato_id' => 'required | integer | max:100',
            'rodada_id' => 'integer | max:1000000',
            'inicio' => 'required | date_format:Y-m-d H:i',
            'gol_casa' => 'integer | max: 20',
            'gol_visitante' => 'integer | max: 20',
        ]);

        $gol_casa = $request->input('gol_casa');
        $gol_visitante = $request->input('gol_visitante');

        $jogo = new Jogo();
        if($request->input('id') != null){
            $jogo = Jogo::find($request->input('id'));
        }
        $jogo->estadio = $request->input('estadio');
        $jogo->campeonato_id = $request->input('campeonato_id');
        $jogo->rodada_id = $request->input('rodada_id');
        $jogo->inicio = $request->input('inicio');
        $jogo->equipe_casa = $request->input('equipe_casa');
        $jogo->equipe_visitante = $request->input('equipe_visitante');
        if(isset($gol_casa)){
            $jogo->gol_casa = $gol_casa;
        }
        if(isset($gol_visitante)){
            $jogo->gol_visitante = $gol_visitante;
        }
        $jogo->save();

        return response()->json(['jogo' => $jogo], 201);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'estadio' => 'alpha_spaces | between:3, 100',
            'equipe_casa' => 'integer | max:1000',
            'equipe_visitante' => 'integer | max:1000',
            'campeonato_id' => 'integer | max:100',
            'rodada_id' => 'integer | max:1000000',
            'inicio' => 'date | before:fim',
            'fim' => 'date',
            'gol_casa' => 'integer | max: 20',
            'gol_visitante' => 'integer | max: 20'
        ]);

        if ($id == null) {
            return response()->json(['error' => 'O id da rodada não foi informado']);
        }

        $jogo = Jogo::find($id);

        if ($jogo == null) {
            return response()->json(['Error' => 'jogo não encontrado'], 404);
        }

        if ($request->input('estadio') != null) {
            $jogo->estadio = $request->input('estadio');
        }

        if ($request->input('inicio') != null) {
            $jogo->inicio = $request->input('inicio');
        }

        if ($request->input('fim') != null) {
            $jogo->fim = $request->input('fim');
        }
        
        if ($request->input('campeonato_id') != null) {
            $jogo->campeonato_id = $request->input('campeonato_id');
        }

        if ($request->input('rodada_id') != null) {
            $jogo->rodada_id = $request->input('rodada_id');
        }

        if ($request->input('equipe_casa') != null) {
            $jogo->equipe_casa = $request->input('equipe_casa');
        }

        if ($request->input('equipe_visitante') != null) {
            $jogo->equipe_visitante = $request->input('equipe_visitante');
        }


        if ($request->input('gol_casa') != null) {
            $jogo->gol_casa = $request->input('gol_casa');
        }

        if ($request->input('gol_visitante') != null) {
            $jogo->gol_visitante = $request->input('gol_visitante');
        }

        $jogo->save();
        
        return response()->json(['jogo' => $jogo], 200);
        
    }

    public function buscar(Request $request) {

        // \print_r(Carbon::now());die;

        $jogos = Jogo::select('*');

        if ($request->input('campeonato_id') != null) {
            $jogos->where('campeonato_id',$request->input('campeonato_id'));
        }

        if ($request->input('rodada_id') != null) {
            $jogos = $jogos->where('rodada_id',$request->input('rodada_id'));
        }

        if ($request->input('estadio') != null) {
            $jogos = $jogos->where('estadio','like','%'.$request->input('estadio').'%');
        }

        if ($request->input('equipe_casa') != null) {
            $jogos = $jogos->where('equipe_casa',$request->input('equipe_casa'));
        }

        if ($request->input('equipe_visitante') != null) {
            $jogos = $jogos->where('equipe_visitante',$request->input('equipe_visitante'));
        }

        if ($request->input('gol_casa') != null) {
            $jogos = $jogos->where('gol_casa', $request->input('gol_casa'));
        }

        if ($request->input('gol_visitante') != null) {
            $jogos = $jogos->where('gol_visitante', $request->input('gol_visitante'));
        }

       
        // $jogos = $jogos->where('fim','>=', Carbon::now());
        

        $jogos = $jogos->with(['rodada', 'campeonato', 'equipeVisitante', 'equipeCasa'])
                        ->get();

        // $lista = [];
        // foreach ($jogos as $key => $value) {
        //     $campeonato = Campeonato::find($value->campeonato_id);
        //     if (!isset($lista[$campeonato->nome])) {
        //         $equipeCasa = Equipe::select('id', 'nome')->where('id', $value->equipe_casa)->first();
        //         $equipeVisitante = Equipe::select('id', 'nome')->where('id', $value->equipe_visitante)->first();
        //         $value->equipe_casa = $equipeCasa;
        //         $value->equipe_visitante = $equipeVisitante;
        //         $lista[$campeonato->nome] = [$value];
        //     } else {
        //         $equipeCasa = Equipe::select('id', 'nome')->where('id', $value->equipe_casa)->first();
        //         $equipeVisitante = Equipe::select('id', 'nome')->where('id', $value->equipe_visitante)->first();
        //         $value->equipe_casa = $equipeCasa;
        //         $value->equipe_visitante = $equipeVisitante;
        //         array_push($lista[$campeonato->nome], $value); 
        //     }
        // }

        return response()->json($jogos, 200);

    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do jogo nao foi informado'], 400);
        }

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Id inválido'], 404);
        }
        
        $jogo = Jogo::find($id);

        if ($jogo == null) {
            return response()->json(['error' => 'jogo não encontrado'], 400);
        }

        return response()->json(['jogo' => $jogo], 200);

    }
}
