<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
	public function create(Request $request)
	{
		$email = $request->query('email');
		return view('auth.set-password', compact('email'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'email' => 'required|email|exists:users,email',
			'password' => 'required|string|min:6|confirmed',
		]);

		$user = User::where('email', $request->email)->first();
		if (!$user) {
			return back()->with('error', 'Email tidak ditemukan.');
		}
		if ($user->password) {
			return back()->with('error', 'Password sudah pernah diatur.');
		}
		$user->password = Hash::make($request->password);
		$user->save();

		return redirect()->route('login')->with('success', 'Password berhasil disimpan. Silakan login.');
	}
}
