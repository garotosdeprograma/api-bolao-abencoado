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
