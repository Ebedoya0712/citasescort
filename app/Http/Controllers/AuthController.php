<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Also attempt to log in to the web guard to set the session cookie for Filament
        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();
        }

        return $this->respondWithToken($token);
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
            'password' => 'required|string|min:6',
            'role' => 'sometimes|string|in:user,escort,establishment',
            // Escort specific fields
            'category' => 'nullable|required_if:role,escort|string',
            'phone' => 'nullable|required_unless:role,user|string',
            'gender' => 'nullable|required_if:role,escort|string',
            // Establishment specific fields
            'establishment_type' => 'nullable|required_if:role,establishment|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => $request->get('role', 'user'),
            ]);

            // If registering as an escort, create the escort profile
            if ($user->role === 'escort') {
                \App\Models\Escort::create([
                    'user_id' => $user->id,
                    'name' => $user->name, // Default to user name, can be updated later
                    'category' => $request->get('category'),
                    'phone' => $request->get('phone'),
                    'gender' => $request->get('gender'),
                    'is_active' => false, // Pending verification
                    'verified' => false,
                ]);
            } elseif ($user->role === 'establishment') {
                \App\Models\Establishment::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'type' => $request->get('establishment_type'),
                    'address' => '', // Needs to be filled in dashboard
                    'latitude' => 0,
                    'longitude' => 0,
                    'phone' => $request->get('phone'),
                    'is_active' => false,
                ]);
            }

            DB::commit();

            $token = auth('api')->login($user);
            auth('web')->login($user); // Login to web session for dashboard access

            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user,
                'redirect_to' => $user->role === 'escort' ? '/dashboard' : ($user->role === 'establishment' ? '/establishment' : route('user.dashboard')),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Web-based login for session persistence.
     */
    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Generate API token as well for hybrid usage if needed
            $user = Auth::guard('web')->user();
            $token = auth('api')->login($user);

            return response()->json([
                'message' => 'Login successful',
                'redirect_to' => $user->isEscort() 
                    ? '/dashboard' 
                    : ($user->isEstablishment() ? '/establishment' : ($user->isAdmin() ? '/admin' : route('user.dashboard'))),
                'user' => $user,
                'access_token' => $token 
            ]);
        }

        return response()->json([
            'errors' => ['email' => ['Credenciales incorrectas.']]
        ], 422);
    }

    /**
     * Web-based logout.
     */
    public function webLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
