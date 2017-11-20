<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Rodada;

class RodadaController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required | integer',
            'inicio' => 'required | date',
            'fim' => 'required | date',
            'ano' => 'required | date',
            'campeonato_id' => 'required | integer'
        ], $message = [
            'numero.required' => 'O campo numero é obrigatório',
            'numero.integer' => 'O campo nome aceita numeros interios',
            'inicio.required' => 'O campo início é obrigatório',
            'inicio.date' => 'O formato do campo inicio deve ser date',
            'fim.required' => 'O campo fim é obrigatório',
            'fim.date' => 'O formato do campo fim deve ser date',
            'ano.required' => 'O campo ano é obrigatório',
            'ano.date' => 'O formato do campo ano deve ser date',
            'campeonato_id' => 'O id do campeonato é obrigatório',
            'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $rodada = new Rodada();
        $rodada->numero = $request->input('numero');
        $rodada->campeonato_id = $request->input('campeonato_id');
        $rodada->inicio = $request->input('inicio');
        $rodada->fim = $request->input('fim');
        $rodada->ano = $request->input('ano');
        $rodada->save();

        return response()->json(['rodada' => $rodada], 200);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'numero' => 'integer',
            'inicio' => 'date',
            'fim' => 'date',
            'ano' => 'date',
            'campeonato_id' => 'integer'
        ], $message = [
            'numero.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios',
            'fim.date' => 'O formato do campo fim deve ser date',
            'inicio.inicio' => 'O formato do campo inicio deve ser date',
            'ano.date' => 'O formato do campo ano deve ser date'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id da rodada não foi informado']);
        }

        $rodada = Rodada::find($id);

        if ($rodada == null) {
            return response()->json(['Error' => 'rodada não encontrado'], 400);
        }

        if ($request->input('numero') != null) {
            $rodada->numero = $request->input('numero');
        }

        if ($request->input('inicio') != null) {
            $rodada->inicio = $request->input('inicio');
        }

        if ($request->input('campeonato_id') != null) {
            $rodada->campeonato_id = $request->input('campeonato_id');
        }

        if ($request->input('fim') != null) {
            $rodada->fim = $request->input('fim');
        }

        if ($request->input('ano') != null) {
            $rodada->ano = $request->input('ano');
        }

        $rodada->save();
        
        return response()->json(['equipe' => $rodada], 200);
        
    }

    public function buscar(Request $request) {

        $rodadas = Rodada::select(
            'id',
            'numero',
            'campeonato_id',
            'ano'
        );

        if ($request->query('campeonato_id') != null) {
            $rodadas = $rodadas->where('campeonato_id',$request->query('campeonato_id'));
        }

        if ($request->query('numero') != null) {
            $rodadas = $rodadas->where('numero',$request->query('numero'));
        }

        if ($request->query('ano') != null) {
            $rodadas = $rodadas->where('ano','like',$request->query('ano'));
        }

        $rodadas = $rodadas
                    ->orderBy('numero')
                    ->get();

        return response()->json(['rodadas' => $rodadas], 200);

    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do rodada nao foi informado'], 400);
        }
        
        $rodada = Rodada::find($id);

        if ($rodada == null) {
            return response()->json(['error' => 'rodada não encontrado'], 400);
        }

        return response()->json(['rodada' => $rodada], 200);

    }
}
