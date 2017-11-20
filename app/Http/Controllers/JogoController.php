<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Jogo;

class JogoController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estadio' => 'required | between:3, 100',
            'equipe_casa' => 'required | integer',
            'equipe_visitante' => 'required | integer',
            'campeonato_id' => 'required | integer',
            'rodada_id' => 'required | integer',
            'inicio' => 'required | date',
            'fim' => 'required | date',
            'gol_casa' => 'required | integer | max: 20',
            'gol_visitante' => 'required | integer | max: 20',
        ], $message = [
            'estadio.required' => 'O campo estadio é obrigatório',
            'estadio.between' => 'O campo estádio aceita entre 3 e 100 carateres',
            'equipe_casa.required' => 'O campo equipe casa é obrigatório',
            'equipe_casa.integer' => 'o campo equipe casa aceita apenas inteiros',
            'equipe_visitante.required' => 'O campo equipe visitante é obrigatório',
            'equipe_casa.integer' => 'o campo equipe visitante aceita apenas inteiros',
            'inicio.required' => 'O campo início é obrigatório',
            'inicio.date' => 'O formato do campo inicio deve ser date',
            'fim.required' => 'O campo fim é obrigatório',
            'fim.date' => 'O formato do campo fim deve ser date',
            'gol_casa.required' => 'O campo gol casa é obrigatório',
            'gol_casa.integer' => 'O campo gol casa aceita apenas numeros interios',
            'gol_casa.max' => 'O campo gol casa não pode ser superior a 20',
            'gol_visitante.required' => 'O campo gol visitante é obrigatório',
            'gol_visitante.max' => 'O campo gol visitante não pode ser superior a 20',
            'gol_visitante.integer' => 'O campo gol visitante aceita apenas numeros interios',
            'campeonato_id.required' => 'O id do campeonato é obrigatório',
            'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios',
            'rodada_id.required' => 'O id do rodada é obrigatório',
            'rodada_id.integer' => 'O id do rodada aceita apenas numeros interios'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $jogo = new Jogo();
        $jogo->estadio = $request->input('estadio');
        $jogo->campeonato_id = $request->input('campeonato_id');
        $jogo->rodada_id = $request->input('rodada_id');
        $jogo->inicio = $request->input('inicio');
        $jogo->fim = $request->input('fim');
        $jogo->equipe_casa = $request->input('equipe_casa');
        $jogo->gol_casa = $request->input('gol_casa');
        $jogo->equipe_visitante = $request->input('equipe_visitante');
        $jogo->gol_visitante = $request->input('gol_visitante');
        $jogo->save();

        return response()->json(['jogo' => $jogo], 200);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'estadio' => 'between:3, 100',
            'equipe_casa' => 'integer',
            'equipe_visitante' => 'integer',
            'campeonato_id' => 'integer',
            'rodada_id' => 'integer',
            'inicio' => 'date',
            'fim' => 'date',
            'gol_casa' => 'integer | max: 20',
            'gol_visitante' => 'integer | max: 20',
        ], $message = [
            'estadio.between' => 'O campo estádio aceita entre 3 e 100 carateres',
            'equipe_casa.integer' => 'o campo equipe casa aceita apenas inteiros',
            'equipe_casa.integer' => 'o campo equipe visitante aceita apenas inteiros',
            'inicio.date' => 'O formato do campo inicio deve ser date',
            'fim.date' => 'O formato do campo fim deve ser date',
            'gol_casa.integer' => 'O campo gol casa aceita apenas numeros interios',
            'gol_casa.max' => 'O campo gol casa não pode ser superior a 20',
            'gol_visitante.integer' => 'O campo gol visitante aceita apenas numeros interios',
            'gol_visitante.max' => 'O campo gol visitante não pode ser superior a 20',
            'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios',
            'rodada_id.integer' => 'O id do rodada aceita apenas numeros interios'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id da rodada não foi informado']);
        }

        $jogo = Jogo::find($id);

        if ($jogo == null) {
            return response()->json(['Error' => 'jogo não encontrado'], 400);
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

        $jogos = Jogo::select(
            'id',
            'estadio',
            'equipe_casa',
            'gol_casa',
            'equipe_visitante',
            'gol_visitante'
        );

        if ($request->query('campeonato_id') != null) {
            $jogos = $jogos->where('campeonato_id',$request->query('campeonato_id'));
        }

        if ($request->query('rodada_id') != null) {
            $jogos = $jogos->where('rodada_id',$request->query('rodada_id'));
        }

        if ($request->query('estadio') != null) {
            $jogos = $jogos->where('estadio','like','%'.$request->query('estadio').'%');
        }

        if ($request->query('equipe_casa') != null) {
            $jogos = $jogos->where('equipe_casa',$request->query('equipe_casa'));
        }

        if ($request->query('equipe_visitante') != null) {
            $jogos = $jogos->where('equipe_visitante',$request->query('equipe_visitante'));
        }

        if ($request->query('gol_casa') != null) {
            $jogo = $jogo->where('gol_casa', $request->query('gol_casa'));
        }

        if ($request->query('gol_visitante') != null) {
            $jogos = $jogos->where('gol_visitante', $request->query('gol_visitante'));
        }

        $jogos = $jogos
                    ->orderBy('inicio', 'DESC')
                    ->get();

        return response()->json(['jogos' => $jogos], 200);

    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do jogo nao foi informado'], 400);
        }
        
        $jogo = Jogo::find($id);

        if ($jogo == null) {
            return response()->json(['error' => 'jogo não encontrado'], 400);
        }

        return response()->json(['jogo' => $jogo], 200);

    }
}
