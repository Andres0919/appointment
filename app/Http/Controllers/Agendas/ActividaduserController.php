<?php

namespace App\Http\Controllers\Agendas;

use App\Modelos\Actividaduser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActividaduserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        //
    }

    public function store(Request $request)
    {
        $input = $request->all();
            $user = Actividaduser::create($input);
            $user->assignRole($request->roles);
            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::disk('public')->put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        return response()->json([
            'message' => 'Usuario creado con Exito!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelos\Actividaduser  $actividaduser
     * @return \Illuminate\Http\Response
     */
    public function show(Actividaduser $actividaduser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Actividaduser  $actividaduser
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividaduser $actividaduser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Actividaduser  $actividaduser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividaduser $actividaduser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Actividaduser  $actividaduser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actividaduser $actividaduser)
    {
        //
    }
}
