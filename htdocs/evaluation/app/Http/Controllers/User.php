<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    /**
     * Displays the login-view
     *
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login() {
        return view('login');
    }

    /**
     * Logout the active user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        Auth::logout();
        return redirect()->intended();
    }

    /**
     * Authenticates the user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request) {
        if (Auth::attempt(['name' => $request->get('name'), 'password' => $request->get('password')])) {
            return redirect()->intended('listSurvey');
        } else {
            return redirect()->intended('/');
        }
    }

    /**
     * Shows all Surveys for the user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listSurvey() {
        $surveys = new Survey();
        $surveys = $surveys::all();
        return view('User/listSurvey', ['surveys' => $surveys]);
    }
}
