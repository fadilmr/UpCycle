<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Nette\Utils\Validators;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'data' => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.r5sVD13FJ3a9eTGKsfZaksdgx2odA16xxmjtgl3GK9s"
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ];

        $this->validate($request, $rules);
        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 200);
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min:6'
        ];

        $this->validate($request, $rules);

        if (Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Successfully logged in!',
            ], 200);
        }
        // if (Auth::user()->role == 1) {
        //     return response()->json([
        //         'message' => 'Successfully logged in as an admin!',
        //     ], 200);
        // }
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out!',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = User::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        if (Hash::check($request->password, Auth::user()->password)) {
            $user->update($request->all());
            return response()->json([
                'message' => 'Successfully updated user!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        $user->delete();
    }
}
