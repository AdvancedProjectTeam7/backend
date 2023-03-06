<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class AuthController extends Controller
{

    /**
     * edit a specific admin by id
     */
    public function edituser(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user->isE)
                $inputs = $request->except('_method');
            $user->update($inputs);
            return response()->json([
                'message' => 'Successful update'
            ]);
        } catch (\Exception $e) { // catch any exception
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function getadmin($id)
    {
        try {
            $user = User::find($id);
            if ($user->isE)
                $user->Get();
            return response()->json([
                'message' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
    }


    /**
     * get all users
     */

    public function getAlluser()
    {
        try {
            $users = User::all();
            return response()->json([
                'message' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch users',
                'message' => $e->getMessage()
            ], 404);
        }
    }


    /**
     * delete a specific admin by its id
     */
    public function deleteuser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }

        try {
            $user->delete();
            return response()->json([
                'message' => 'Successful deletion'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete user',
                'message' => $e->getMessage()
            ], 404);
        }
    }


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
            
        ));
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
$user->image = $image;
            $user->save();
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
