<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /*function __construct()
    {
       $this->middleware('permission:role-list');
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        
    }*/
    
    public function all()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles, 200);
    }

    public function store(Request $request)
    {
        //return ($request->all());
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|unique:roles',
            'permissions' => 'required',
        ]); 
        if ($validate->fails())
        {
            $errores = $validate->errors(); 
            return response()->json($errores, 422); 			          
        }
            $input = $request->name;
            $role = Role::create(['name' => $input]);
            $role->syncPermissions($request->permissions);
            
        return response()->json([
            'message' => 'Rol creado con Exito!'], 201);
    }

    public function show($role)
    {   $role = Role::find($role);
        if (!isset($role)) {
            return response()->json([
                'message' => 'El Role buscado no Existe!'], 404);
        }
        $role->getPermissionNames();
        return response()->json($role, 200);
    }

    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return response()->json([
            'message' => 'Role Actualizado con Exito!'
        ], 200);

        
    }

    public function destroy(Role $role)
    {
        DB::table("roles")->where('id',$role)->delete();
        return response()->json([
            'message' => 'Role Eliminado con Exito!'], 200);
    }
}
