<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        $role = $user->usertype;

        return response([
            'message' => $token,
            'role' => $role
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function users20()
    {
        return User::paginate(20);
    }

    public function users40()
    {
        return User::paginate(40);
    }

    public function users60()
    {
        return User::paginate(60);
    }

    public function nbOfRegisteredUsers(Request $request)
    {
        $i=1;
        $usersRegisterdToday=0;
        $today = Carbon::today();
        $sum = 0;
        $nbDays = $request->days;
        for ($i; $i <= $nbDays; $i++) {
            $usersRegisterdToday = User::whereDate('created_at','=',$today)->count();
            $sum = $sum + $usersRegisterdToday;
            $today= $today->subDays(1);
        }
        $average = $sum/$i;
        return response([
            'message' => $average
        ]);
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
}