<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Campeonato;

class CampeonatoController extends Controller
{
    public function cadastro(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required | between:4,100 | alpha_spaces'
        ]);

        $campeonato = new Campeonato();
        $campeonato->nome = $request->input('nome');
        $campeonato->save();

        return response()->json(['campeonato' => $campeonato], 200);
    }

    public function edit(Request $request, $id)
    {

        $this->validate($request, [
            'nome' => 'alpha_spaces | between:4, 100'
        ]);

        if ($id == null) {
            return response()->json(['error' => 'O id do usuario não fpi informado']);
        }

        $campeonato = Campeonato::find($id);

        if ($campeonato == null) {
            return response()->json(['Error' => 'Campeonato não encontrado'], 400);
        }

        if (null != $request->input('nome')) {
            $campeonato->nome = $request->input('nome');
            $campeonato->save();
        }
        
        return response()->json(['campeonato' => $campeonato], 200);
        
    }

    public function buscar(Request $request) {

        $this->validate($request, [
            'nome' => 'nullable | alpha_spaces'
        ]); 

        $campeonatos = Campeonato::select(
                        'id',
                        'nome',
                        'created_at', 
                        'updated_at'
                        );
                        if ($request->query('nome') != null) {
                            $campeonatos->where('nome','like', '%'.$request->query('nome').'%' );
                        }
                        $campeonatos = $campeonatos->orderBy('nome', 'ASC')
                                        ->paginate(10);

        return response()->json($campeonatos, 200);

    }

    public function buscarTodos(Request $request) {

        $campeonatos = Campeonato::select(
                        'id',
                        'nome'
                        )
                        ->orderBy('nome', 'ASC')
                        ->get();

        return response()->json($campeonatos, 200);

    }

    public function buscarPorId($id) {

        $this->validate($request, [
            'nome' => 'required | between:4,100 | alpha_spaces'
        ]);

        if ($id == null && is_numeric($id)) {
            return response()->json(['error' => 'O id do campeonato nao foi informado'], 400);
        }
        
        $campeonato = Campeonato::find($id);

        if ($campeonato == null) {
            return response()->json(['error' => 'Campeonato não encontrado'], 400);
        }

        $campeonato = $campeonato->save();

        return response()->json(['campeonatos' => $campeonato, 200]);

    }
}


