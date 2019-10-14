<?php

namespace App\Http\Controllers\Usuarios;

use Avatar;
use Storage;
use App\Modelos\TipoAgenda;
use App\Modelos\Actividaduser;
use App\Modelos\Especialidade;
use App\User;
use App\Modelos\Estado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function all()
    {
        $user = User::with('roles')->get();

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $resul = Validator::make($request->all(),[
            'name'     => 'required|string',
            'apellido'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        if ($resul->fails())
        {
            $errores = $resul->errors(); 
            return response()->json($errores, 422); 			          
        }
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user->assignRole($request->roles);
            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::disk('public')->put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        return response()->json([
            'message' => 'Usuario creado con Exito!'], 201);
    }

    public function show(User $user)
    {
        $user->getRoleNames();
        return response()->json($user, 200);

    }

    public function update(Request $request, User $user )
    {
        $user->update($request->all());
        $user->syncRoles($request->roles);
        return response()->json([
            'message' => 'Usuario Actualizado con Exito!'
        ], 200);
    }

    public function updatepass(Request $request, User $user)
    {
      
       $pass=bcrypt($request['password']);
       $user->password=$pass;
       $user->save();
       return response()->json([
        'message'  => 'Contraseña actualizada con Exito!'
        ], 200);

    }

    public function available(Request $request, User $user)
    {
        $user->update(['estado_user' => $request->estado_user]);
        $pivote = [
            'Actualizado_por' => auth()->id()
        ];
        $user->estados()->attach($request->estado_user, $pivote);
        return response()->json([
            'message' => 'Estado del usuario Actualizado con Exito!'
        ], 200);
    }

    public function especialidadMedico($Especialidade){
        $medicos = User::where('estado_user', 1)
            ->whereHas("roles", function($q) use ($Especialidade){ $q->where("name", "Medico $Especialidade"); })
            ->get();
        return response()->json($medicos,200);
    }

    public function medicos(){
        $medicos = User::permission('medico')
        ->where('estado_user', 1)
        ->get();
        return response()->json($medicos, 200);
    }
}
