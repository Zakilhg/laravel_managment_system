<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersAuthController extends Controller
{
    public function home()
    {
        $products = Product::where('quantite', '>=', 2)->limit(6)->get();

        return view('Components.homepage', compact('products'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function index()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Prevent session fixation.
            $request->session()->regenerate();

            // intended() sends the user back to the page they originally tried to open.
            return redirect()->intended('dashboard')->with('message', 'Signed in!');
        }

        return redirect('/login')
            ->withInput($request->only('email'))
            ->with('message', 'Login details are not valid!');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'local' => 'required|in:Marrakech,Rabat',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'image' => $imagePath,
            'local' => $request->input('local'),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('dashboard');
    }

    public function edit()
    {
        return view('user.edit');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'local' => 'required|in:Marrakech,Rabat',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->local = $request->input('local');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('images', 'public');
        }

        $user->save();

        return redirect('/profile')->with('message', 'User updated successfully!');
    }

    public function dashboard(Request $request)
    {
        $monthSales = $request->user()->vents()
            ->where('date_vent', '>=', Carbon::now()->firstOfMonth());

        // Totals cover every sale this month; the table only shows the latest 10.
        $total_prix_vent = (clone $monthSales)->sum('prix_vent');
        $total_prix_achat = (clone $monthSales)->sum('prix_achat');
        $vents = (clone $monthSales)->with('product')->latest('date_vent')->limit(10)->get();

        $products = Product::count();
        $total_profit = $total_prix_vent - $total_prix_achat;
        $percentage = $total_prix_vent > 0 ? round(($total_profit / $total_prix_vent) * 100, 2) : 0;

        return view('user.dashboard', compact('vents', 'products', 'total_prix_vent', 'total_prix_achat', 'total_profit', 'percentage'));
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
