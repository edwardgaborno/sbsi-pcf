<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => 'required|string'
        ]);

        DB::beginTransaction();
        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type
            ]);

            //assign default role   
            $user->assignRole($request->user_type);

            //assign default permission
            if ($request->user_type == 'psr') {
                $user->givePermissionTo([
                    'add', 
                    'view', 
                    'edit', 
                    'update',
                    'delete',
                ]);
            } else if($request->user_type == 'accounting') {
                $user->givePermissionTo([
                    'view', 
                    'approve', 
                    'disapprove',
                ]);
            } else if($request->user_type == 'nsm') {
                $user->givePermissionTo([
                    'view', 
                    'second approve', 
                    'second disapprove',
                ]);
            } else {
                $user->givePermissionTo([
                    'view', 
                    'final approve', 
                    'final disapprove',
                ]);
            }
            
            DB::commit();

            event(new Registered($user));

            // Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        try {
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register')->withErrors($th);
        }

        
    }
}
