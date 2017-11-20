<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Equipe;

class EquipeController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required | between:4,100',
            'campeonato_id' => 'required | integer'
        ], $message = [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 3 e 100 carateres',
            'campeonato_id.required' => 'O id do campeonato deve ser informado',
            'campeonato_id.integer' => 'O id do campeonato deve apenas numero inteiro',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $equipe = new Equipe();
        $equipe->nome = $request->input('nome');
        $equipe->campeonato_id = $request->input('campeonato_id');
        $equipe->save();

        return response()->json(['equipe' => $equipe], 200);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'between:4, 100',
            'campeonato_id' => 'integer'
        ], $message = [
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'campeonato_id.integer' => 'O id do campeonato aceita apenas numeros interios'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id da equipe não foi informado']);
        }

        $equipe = Equipe::find($id);

        if ($equipe == null) {
            return response()->json(['Error' => 'equipe não encontrado'], 400);
        }

        if ($request->input('nome') != null) {
            $equipe->nome = $request->input('nome');
        }

        if ($request->input('campeonato_id') != null) {
            $equipe->campeonato_id = $request->input('campeonato_id');
        }

        $equipe->save();
        
        return response()->json(['equipe' => $equipe], 200);
        
    }

    public function buscar(Request $request) {

        $equipes = Equipe::select(
            'id',
            'nome',
            'campeonato_id'
        );

        if ($request->query('campeonato_id') != null) {
            $equipes = $equipes->where('campeonato_id',$request->query('campeonato_id'));
        }

        if ($request->query('nome') != null) {
            $equipes = $equipes->where('nome','like','%'.$request->query('nome').'%');
        }

        $equipes = $equipes
                    ->orderBy('nome')
                    ->get();

        return response()->json(['equipes' => $equipes], 200);

    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do equipe nao foi informado'], 400);
        }
        
        $equipe = Equipe::find($id);

        if ($equipe == null) {
            return response()->json(['error' => 'equipe não encontrado'], 400);
        }

        return response()->json(['equipe' => $equipe], 200);

    }
}
