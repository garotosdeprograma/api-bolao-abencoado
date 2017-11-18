<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Campeonato;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required | between:4,100',
            'sobrenome' => 'required | between:2,100',
            'email' => 'required | email',
            'senha' => 'required | min:6',
            'celular' => 'required | integer | size:11',
            'ativo' => 'required | boolean',
            'tipo_usuario' => 'required | alpha'
        ], $message = [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'sobrenome.required' => 'O campo sobrenome é obrigatório',
            'sobrenome.between' => 'O campo sobrenome aceita apenas entre 2 e 100 carateres',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Email inválido',
            'senha.required' => 'O campo senha é obrigatório',
            'senha.min' => 'O campo senha aceita no mínimo 6b carateres',
            'celular.required' => 'O campo celular é obrigatório',
            'celular.integer' => 'O campo celular aceita apenas numeros inteiros',
            'celular.size' => 'O campo celular aceita apenas 11 digitos',
            'ativo.required' => 'O campo ativo é obrigatório',
            'ativo.boolean' => 'O campo ativo aceita apenas booleanos',
            'tipo_usuario.required' => 'O campo tipo de usuario é obrigatório',
            'tipo_usuario.alpha' => 'O campo tipo de usuário aaceita apenas letras' 
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $usuario = new Usuario();
        $usuario->nome = $request->input('nome');
        $usuario->sobrenome = $request->input('sobrenome');
        $usuario->email = $request->input('email');
        $usuario->senha = $request->input('senha');
        $usuario->celular = $request->input('celular');
        $usuario->ativo = $request->input('ativo');
        $usuario->tipo_usuario = $request->input('tipo_usuario');
        $usuario->save();

        return response()->json(['usuario' => $usuario, 200]);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'isEmpty | between:4,100',
            'sobrenome' => 'isEmpty | between:2,100',
            'email' => 'isEmpty | email',
            'senha' => 'isEmpty | min:6',
            'celular' => 'isEmpty | integer | size:11',
            'ativo' => 'isEmpty | boolean',
            'tipo_usuario' => 'isEmpty | alpha'
        ], $message = [
            'nome.isEmpty' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'sobrenome.isEmpty' => 'O campo sobrenome é obrigatório',
            'sobrenome.between' => 'O campo sobrenome aceita apenas entre 2 e 100 carateres',
            'email.isEmpty' => 'O campo email é obrigatório',
            'email.email' => 'Email inválido',
            'senha.isEmpty' => 'O campo senha é obrigatório',
            'senha.min' => 'O campo senha aceita no mínimo 6b carateres',
            'celular.isEmpty' => 'O campo celular é obrigatório',
            'celular.integer' => 'O campo celular aceita apenas numeros inteiros',
            'celular.size' => 'O campo celular aceita apenas 11 digitos',
            'ativo.isEmpty' => 'O campo ativo é obrigatório',
            'ativo.boolean' => 'O campo ativo aceita apenas booleanos',
            'tipo_usuario.isEmpty' => 'O campo tipo de usuario é obrigatório',
            'tipo_usuario.alpha' => 'O campo tipo de usuário aaceita apenas letras' 
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id do usuario não fpi informado']);
        }

        $usuario = Usuario::find($id);

        if ($usuario == null) {
            return response()->json(['Error' => 'Usuario não encontrado'], 400);
        }

        $usuario = new Usuario();

        if ($request->input('nome')) {
            $usuario->nome = $request->input('nome');
        }
        if ($request->input('sobrenome')) {
            $usuario->sobrenome = $request->input('sobrenome');
        }
        if ($request->input('email')) {
            $usuario->email = $request->input('email');
        }
        if ($request->input('senha')) {
            $usuario->senha = $request->input('senha');
        }
        if ($request->input('celular')) {
            $usuario->celular = $request->input('celular');
        }
        if ($resquest->input('ativo')) {
            $usuario->ativo = $request->input('ativo');
        }
        if ($request->input('tipo_usuario')) {
            $usuario->tipo_usuario = $request->input('tipo_usuario');
        }
        $usuario->save();

        return response()->json(['usuario' => $usuario, 200]);
        
    }

    public function buscarPagination(Request $request) {



        $campeonatos = Campeonato::all();

        return response()->json(['campeonatos' => $campeonatos, 200]);

    }

    public function countUsuarios()
    {
        return $count = DB::table('usuarios')->count();
    }

    public function buscarPorId($id) {

        if ($id == null) {
            return response()->json(['error' => 'O id do usuario nao foi informado'], 400);
        }
        
        $usuario = Usuario::find($id);

        if ($usuario == null) {
            return response()->json(['error' => 'Usuario não encontrado'], 400);
        }

        return response()->json(['usuario' => $usuario, 200]);

    }
}
