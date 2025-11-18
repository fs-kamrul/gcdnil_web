<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Modules\KamrulDashboard\Providers\RouteServiceProvider;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        $this->middleware('auth');
    }
    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        $data = array();
        $data['title']        = 'confirm_password';
        return view('kamruldashboard::auth.passwords.confirm',$data);
    }

}
