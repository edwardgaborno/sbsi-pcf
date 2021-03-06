<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(8)->uncompromised(3)],
        ]);

        DB::beginTransaction();
        
        try {

            $user = User::firstOrCreate([
                'email' => $request->email,
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //assign role   
            $user->assignRole('PSR');
            
            DB::commit();

            event(new Registered($user));

            // Auth::login($user);

            // return redirect(RouteServiceProvider::HOME);

            return redirect()->route('login')->withStatus('Your account is awaiting administrative approval. You may login once an approval has been made.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register')->withErrors($th);
        }  
    }
}
