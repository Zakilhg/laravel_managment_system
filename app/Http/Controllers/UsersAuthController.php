<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersAuthController extends Controller
{
    public function home()
    {
        $products = Product::where('quantite', '>=','2' )->limit(6)->get();
        return view('Components.homepage',compact('products'));
    }

    public function profile(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();

            return view('user.profile');
        }
        return redirect('/login');
    }

    public function index()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            //   return redirect()->intended('dashboard') hadi katsiftk le lien li knti biti dkhl lih o maqdertish ms mn b3d ma tlogiti ghaydwzk le lien laravel kay3qel ela dak lien
            return redirect()->intended('dashboard')->with('message', 'Signed in!');
        }

        return redirect('/login')->with('message', 'Login details are not valid!');
    }

    public function signup()
    {
        return view('user.registration');
    }

    public function signupsave(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'local' => 'required'
    ]);

    $imagePath = null;
    if (isset($request['image'])) {
        $imagePath = $request['image']->store('public/images');
        $imagePath = str_replace('public/', '', $imagePath);
    }

    $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
        'image' => $imagePath,
        'local' => $request['local']
    ]);

    return redirect("dashboard");
}

    public function edit(User $user)
    {
        return view('user.edit');
    }



    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'local' => 'required'

        ]);

        $user = User::findOrFail(auth()->user()->id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->local = $request->input('local');


        if (!empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::delete('public/' . $user->image);

            // Store the new image
            $imagePath = $request->file('image')->store('public/images');
            $imagePath = str_replace('public/', '', $imagePath);
            $user->image = $imagePath;
        }


        $user->save();

        return redirect('/profile')->with('message', 'User updated successfully!');
    }



    public function dashboard(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $query = $user->vents();
            $vents = $query->where('date_vent', '>=', Carbon::now()->firstOfMonth())->limit(10)->get();
            $products = Product::count(); // Retrieve

            // Calculate values
            $total_prix_vent = $vents->sum('prix_vent');
            $total_prix_achat = $vents->sum('prix_achat');
            $total_profit = $total_prix_vent - $total_prix_achat;
            $percentage = $total_prix_vent > 0 ? round(($total_profit / $total_prix_vent) * 100, 2) : 0;


            return view('user.dashboard',compact('vents','products', 'total_prix_vent', 'total_prix_achat', 'total_profit', 'percentage'));
        }
        return redirect('/login');
    }



    public function signOut() {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
