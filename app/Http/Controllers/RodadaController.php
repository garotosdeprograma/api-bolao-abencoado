<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rodada;
use Carbon\Carbon;

class RodadaController extends Controller
{
    public function cadastro(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required | alpha_num | between:3,30',
            'inicio' => 'required | date | before:fim',
            'fim' => 'required | date',
        ]);

        $rodada = new Rodada();
        $rodada->nome = $request->input('nome');
        $rodada->inicio = $request->input('inicio');
        $rodada->fim = $request->input('fim');
        $rodada->save();

        return response()->json(['rodada' => $rodada], 201);
    }

    public function edit(Request $request, $id)
    {
        
        $this->validate($request, [
            'nome' => 'nullable | alpha_num | between:3,30',
            'inicio' => 'date',
            'fim' => 'date | after:inicio',
        ]);

        $rodada = Rodada::find($id);

        if ($rodada == null) {
            return response()->json(['error' => 'Rodada inexistente'], 404);
        }


        if (null != $request->input('nome')) {
            $rodada->nome = $request->input('nome');
        }

        if (null != $request->input('inicio')) {
            $rodada->inicio = $request->input('inicio');
        }

        if (null != $request->input('fim')) {
            $rodada->fim = $request->input('fim');
        }

        $rodada->save();
        
        return response()->json(['rodada' => $rodada], 200);
        
    }

    public function buscar(Request $request) {

        $this->validate($request, [
            'nome' => 'nullable | alpha_num',
            'inicio' => 'nullable | date',
            'fim' => 'nullable | date',
        ]);

        $rodadas = Rodada::select(
            'id',
            'nome',
            'inicio',
            'fim',
            'created_at',
            'updated_at'
        );

        if (null != $request->input('nome')) {
            $rodadas->where('nome', 'like', '%'.$request->input('nome').'%');
        }

        if (null != $request->input('inicio')) {
            $rodadas->whereDate('inicio', '>=', $request->input('inicio'));
        }

        if (null != $request->input('fim')) {
            $rodadas->whereDate('fim', '<=', $request->input('fim'));
        }

        $rodadas = $rodadas->orderBy('inicio', 'ASC')
                            ->paginate(10);

        return response()->json($rodadas, 200);

    }

    public function buscarJogosPorRodada(Request $request) {

        
        $id = $request->query('id');

        $rodadas = Rodada::select(
            'id',
            'nome',
            'inicio',
            'fim'
        );

        if(isset($id) && $id != null) {
            $rodadas = $rodadas->where('id', $id);
        }else{
            $rodadas = $rodadas->whereDate('fim', '<', Carbon::now('America/Fortaleza'));
        }
        $rodadas = $rodadas->with(['jogos.equipeCasa', 'jogos.equipeVisitante'])
                            ->get();

        return response()->json($rodadas, 200);
    }

    public function buscarPorId($id) {

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Id inválido'], 404);
        }
        
        $rodada = Rodada::find($id);

        return response()->json(['rodada' => $rodada], 200);

    }

    // public function buscarJogosPorRodada(Request $request) {

    //     $id = $request->query('id');

    //     if (!is_numeric($id)) {
    //         return response()->json(['error' => 'Id inválido'], 404);
    //     }
        
    //     $rodada = Rodada::select('*')
    //     ->where('id', $id)                
    //     ->with(['jogos.equipeCasa', 'jogos.equipeVisitante'])
    //     ->get();

    //     return response()->json(['rodada' => $rodada], 200);

    // }
}
