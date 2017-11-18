<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Campeonato;

class CampeonatoController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required | between:4,100'
        ], $message = [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $campeonato = new Campeonato();
        $campeonato->nome = $request->input('nome');
        $campeonato->save();

        return response()->json(['campeonato' => $campeonato, 200]);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'between:4, 100'
        ], $message = [
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id do usuario não fpi informado']);
        }

        $campeonato = Campeonato::find($id);

        if ($campeonato == null) {
            return response()->json(['Error' => 'Campeonato não encontrado'], 400);
        }

        $campeonato->nome = $request->input('nome');
        
        $campeonato->save();
        
        return response()->json(['campeonato' => $campeonato], 200);
        
    }

    public function buscar() {

        $campeonatos = Campeonato::all();

        return response()->json(['campeonatos' => $campeonatos, 200]);

    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do campeonato nao foi informado'], 400);
        }
        
        $campeonato = Campeonato::find($id);

        if ($campeonato == null) {
            return response()->json(['error' => 'Campeonato não encontrado'], 400);
        }

        return response()->json(['campeonatos' => $campeonato, 200]);

    }
}
