<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Usuario;

class UsuarioController extends Controller
{
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required | between:4,100',
            'sobrenome' => 'required | between:2,100',
            'email' => 'required | email | unique:usuarios',
            'senha' => 'required | min:6',
            'celular' => 'required | integer',
            'ativo' => 'required | boolean',
            'tipo_usuario' => 'required | alpha'
        ], $message = [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'sobrenome.required' => 'O campo sobrenome é obrigatório',
            'sobrenome.between' => 'O campo sobrenome aceita apenas entre 2 e 100 carateres',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email já cadastrado no sistema',
            'senha.required' => 'O campo senha é obrigatório',
            'senha.min' => 'O campo senha aceita no mínimo 6b carateres',
            'celular.required' => 'O campo celular é obrigatório',
            'celular.integer' => 'O campo celular aceita apenas numeros inteiros',
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
        $usuario->password = app('hash')->make($request->input('senha'));
        $usuario->celular = $request->input('celular');
        $usuario->ativo = $request->input('ativo');
        $usuario->tipo_usuario = $request->input('tipo_usuario');
        
        try {
            $usuario = $usuario->save();
        } catch(Execption $e) {
            return response()->json(['error' => $e], 400);
        }

        return response()->json(['usuario' => $usuario, 200]);
    }

    public function edit(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nome' => ' between:4,100',
            'sobrenome' => ' between:2,100',
            'email' => ' email',
            'senha' => ' min:6',
            'celular' => ' integer',
            'ativo' => ' boolean',
            'tipo_usuario' => ' alpha'
        ], $message = [
            'nome.isEmpty' => 'O campo nome é obrigatório',
            'nome.between' => 'O campo nome aceita apenas entre 4 e 100 carateres',
            'sobrenome.between' => 'O campo sobrenome aceita apenas entre 2 e 100 carateres',
            'email.email' => 'Email inválido',
            'senha.min' => 'O campo senha aceita no mínimo 6b carateres',
            'celular.integer' => 'O campo celular aceita apenas numeros inteiros',
            'ativo.boolean' => 'O campo ativo aceita apenas booleanos',
            'tipo_usuario.alpha' => 'O campo tipo de usuário aaceita apenas letras' 
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($id == null) {
            return response()->json(['error' => 'O id do usuario não foi informado']);
        }

        $usuario = Usuario::find($id);

        if ($usuario == null) {
            return response()->json(['Error' => 'Usuario não encontrado'], 400);
        }

        if ($request->input('nome') != null) {
            $usuario->nome = $request->input('nome');
        }
        if ($request->input('sobrenome')) {
            $usuario->sobrenome = $request->input('sobrenome');
        }
        if ($request->input('email')) {
            $usuario->email = $request->input('email');
        }
        if ($request->input('senha')) {
            $usuario->password = app('hash')->make($request->input('senha'));
        }
        if ($request->input('celular')) {
            $usuario->celular = $request->input('celular');
        }
        if ($request->input('ativo')) {
            $usuario->ativo = $request->input('ativo');
        }
        if ($request->input('tipo_usuario')) {
            $usuario->tipo_usuario = $request->input('tipo_usuario');
        }
        
        $usuario->save();

        return response()->json(['usuario' => $usuario, 200]);
        
    }

    public function countUsuarios(Request $request)
    {
        $pagina = 0;
        $qtd = 10;
        $ativo = null;

        if($request->query('pagina') != null && is_numeric($request->query('pagina'))){
            $pagina = $request->query('pagina');
        }
        if($request->query('qtd') != null && is_numeric($request->query('qtd')) && $request->query('qtd') <= 30){
            $qtd = $request->query('qtd');
        }
        if($request->query('ativo') != null && ($request->query('ativo') === "true" || $request->query('ativo') === "false")){
            $ativo = $request->query('ativo');
        }
        $usuario = Auth::Usuario();
        
        $users = User::select(
            'id',
            'nome',
            'email',
            'status',
            'perfil',
            'tipo_usuario'
            );
        if($request->query('nome') != null){
            $users = $users->where('users.name', 'like', '%'.$request->query('nome').'%');
        }
        if($request->query('sobrenome') != null){
            $users = $users->where('sobrenome', 'like', '%'.$request->query('sobrenome').'%');
        }
        if($request->query('email') != null){
            $users = $users->where('email', 'like', '%'.$request->query('email').'%');
        }
        if($ativo != null){
            $users = $users->where('ativo',($ativo === 'true'));
        }
        $count = $users->count();
        
        return response()->json($count, '200');
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

    public function buscarList(Request $request)
    {
        $pagina = 0;
        $qtd = 10;
        $ativo = null;

        if($request->query('pagina') != null && is_numeric($request->query('pagina'))){
            $pagina = $request->query('pagina');
        }
        if($request->query('qtd') != null && is_numeric($request->query('qtd')) && $request->query('qtd') <= 30){
            $qtd = $request->query('qtd');
        }
        if($request->query('ativo') != null && ($request->query('ativo') === "true" || $request->query('ativo') === "false")){
            $ativo = $request->query('ativo');
        }
        $usuario = Auth::Usuario();
        
        $users = User::select(
            'id',
            'nome',
            'email',
            'status',
            'perfil',
            'tipo_usuario'
            );
        if($request->query('nome') != null){
            $users = $users->where('users.name', 'like', '%'.$request->query('nome').'%');
        }
        if($request->query('sobrenome') != null){
            $users = $users->where('sobrenome', 'like', '%'.$request->query('sobrenome').'%');
        }
        if($request->query('email') != null){
            $users = $users->where('email', 'like', '%'.$request->query('email').'%');
        }
        if($ativo != null){
            $users = $users->where('ativo',($ativo === 'true'));
        }
        $users = $users
            ->orderBy('nome')
            ->offset($pagina*$qtd)
            ->limit($qtd)
            ->get();
        
        return response()->json($users, '200');
    }
}
