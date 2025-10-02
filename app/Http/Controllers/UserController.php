<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\UserResource;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $data['email_verified_at'] = now();
        $data['type'] = UserType::PATIENT;
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $createUser = User::create($data);
        //login
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        } else {
            // logout current user and login with new user
            auth()->logout();
            $token = $createUser->createToken('auth_token')->plainTextToken;
            auth()->login($createUser);
        }

        // Return user resource with token
        $userResource = (new UserResource($createUser))->withoutPassword();
        return response()->json([
            'user' => $userResource,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json();
    }
    // Authentication Api [ Login,Logout ] using jwt
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $userResource = (new UserResource($user))->withoutPassword();

        // return user data + token
        $data = [
            'user' => $userResource,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
        return response()->json($data);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
    // refresh
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->login($request);
    }

    public function whoam()
    {
       // get current user
       $user = auth()->user();
       return new UserResource($user);

    }
}
