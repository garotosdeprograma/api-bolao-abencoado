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
        $this->validate($request, [
            'nome' => 'required | alpha_spaces | between:3,50',
            'logo' =>  ['nullable', 'between:10,60', 'regex:/^[a-zA-Z.\/]/'],
            'campeonato' => 'required | array | max:5'
        ]);

        $equipe = new Equipe();
        $equipe->nome = $request->input('nome');
        $equipe->logo = $request->input('logo');
        $equipe->save();

        $equipe->campeonatos()->attach($request->input('campeonato'));
        
        return response()->json($equipe, 200);
    }

    public function edit(Request $request, $id)
    {

        $this->validate($request, [
            'nome' => 'required | alpha_spaces | between:3,50',
            'campeonato' => 'required | array | max:5',
            'logo' =>  ['nullable', 'between:10,60', 'regex:/^[a-zA-Z.\/]/']
        ]);

        if ($id == null) {
            return response()->json(['error' => 'O id da equipe não foi informado']);
        }

        $equipe = Equipe::find($id);

        if ($equipe == null) {
            return response()->json(['Error' => 'equipe não encontrado'], 400);
        }

        if ($request->input('logo') != null) {
            $equipe->logo = $request->input('logo');
        }

        if ($request->input('nome') != null) {
            $equipe->nome = $request->input('nome');
        }

        if (null == $request->input('detach')) {
            $equipe->campeonatos()->detach($request->input('detach'));
        }

        $equipe->save();

        $campeonato = $request->input('campeonato');

        if (count($campeonato) > 0) {
            $equipe->campeonatos()->attach($request->input('campeonato'));
        }

        
        return response()->json(['equipe' => $equipe], 200);
        
    }

    public function buscar(Request $request) {

        $equipes = Equipe::select(
            'id',
            'nome',
            'logo'
        );

        if ($request->query('nome') != null) {
            $equipes = $equipes->where('nome','like','%'.$request->query('nome').'%');
        }

        $equipes = $equipes
                ->with('campeonatos')
                ->orderBy('nome', 'ASC')
                ->paginate(10);

        return response()->json($equipes, 200);

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
