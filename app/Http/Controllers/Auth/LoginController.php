<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return response()->json([
            'success' => true,
            'message' => 'Login formini ko\'rsatish.',
        ]);
    }

    public function showRegisterForm()
    {
        return response()->json([
            'success' => true,
            'message' => 'Register formini ko\'rsatish.',
        ]);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Tizimga kirdingiz.',
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'errors' => ['email' => 'Email yoki parol noto\'g\'ri.'],
    //     ], 401);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        Auth::attempt($request->only('email', 'password'));

        if (Auth::check()) {
            $token = Auth::user()->createToken('Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'data' => Auth::user(),
                'token' => $token,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Tizimga muvvaffaqiyatli kirdingiz'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $roles = ['user', 'admin', 'creator', 'editor'];
        $role = $roles[array_rand($roles)];

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $role,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Token')->plainTextToken;

        Auth::login($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => 'Ro\'yxatdan o\'tdingiz va tizimga kirdingiz.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ], 200);
    }
}
