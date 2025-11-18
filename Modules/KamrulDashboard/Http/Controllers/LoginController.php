<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        $data = array();
        $data['title']        = 'login';
        return view('kamruldashboard::auth.login',$data);
    }
}
