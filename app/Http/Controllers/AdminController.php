<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|min:3',
            'password' => 'required|max:255|min:3'
        ]);

        if ($validator->fails()) {
            return Response::json(['message' => $validator->errors()], 400);
        }

        $adminAlreadyExists = Admin::where('username', $request->username)->first();
        if ($adminAlreadyExists) {
            return Response::json(['message' => 'Usuário Admin já existe'], 400);
        }

        $admin = new Admin();
        $admin->username = $request->username;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return Response::json(['message' => 'Usuário Admin criado com sucesso', 'data' => $admin], 201);
    }
}
