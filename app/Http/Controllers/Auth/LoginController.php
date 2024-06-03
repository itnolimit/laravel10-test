<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use TMS\Core\Events\DeviceLogout;
use TMS\Core\Support\Services\AcceptInvitationService;
use TMS\User\Models\UserInvitation;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Display Login page.
     *
     * @return Renderable
     */
    public function showLoginForm(Request $request)
    {
        if ($request->get('utm_source') != 'invite' && Cookie::get('invite_code')) {
            Cookie::queue(Cookie::forget('invite_code'));

            return redirect(route('login'));
        }

        $invitation = Cookie::get('invite_code') ? UserInvitation::where('code', Cookie::get('invite_code'))->first() : '';

        return view('auth.login', compact('invitation'));
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Auth::logoutOtherDevices($request->input('password'));

        event(new DeviceLogout());

        $invitation = Cookie::get('invite_code') ? UserInvitation::where('code', Cookie::get('invite_code'))->first() : '';

        if (! empty($invitation)) {
            (new AcceptInvitationService($user, $invitation))->accept();
        }

        if (Cookie::get('invite_code') && empty($invitation)) {
            Cookie::queue(Cookie::forget('invite_code'));
            flash()->error("We're sorry, the invite is no longer valid.");
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {
            return '/cp';
        }

        return '/dashboard';
    }
}
