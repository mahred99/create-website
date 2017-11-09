<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ActivateController extends Controller
{
	public function active(Request $request) {
		$user = User::find($request->id);
		if (!$user->activate) {
			return redirect('/');
		}
		if ($user->activate->code == $request->code) {
			$user->activate->delete();
			$user->active = 1;
			$user->save();
			auth()->guard()->login($user);
		}
		return redirect()->home();
	}
	public function resend(Request $request) {
		$user = User::find($request->id);
		$user->activate()->save(['code' => str_random(40)]);
		\Mail::to($user)->send(new ActivateEmail($user));
		return back();
	}
}