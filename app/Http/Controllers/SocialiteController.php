<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
      
            $socialiteUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate([
                'provider_id' => $socialiteUser->getId(),
            ], [
                'email' => $socialiteUser->getEmail(),
                'name' => $socialiteUser->getName(),
            ]);

            Auth::login($user);

            return redirect()->intended('dashboard');
       
            // $finduser = User::where('provider_id', $user->id)->first();
       
            // if ($finduser) {
       
            //     Auth::login($finduser);
      
            //     return redirect()->intended('dashboard');
       
            // } else {
            //     $newUser = User::create([
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'provider_id'=> $user->id,
            //     ]);
      
            //     Auth::login($newUser);
      
            //     return redirect()->intended('dashboard');
            // }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
