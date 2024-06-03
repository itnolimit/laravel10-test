<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Rules\EmailSpamRule;
use App\Support\Services\InstallCompanyService;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Throwable;
use TMS\Core\Jobs\CRM\CRMImportAccountJob;
use TMS\Core\Jobs\DemoDriverCreateJob;
use TMS\Core\Jobs\Email\AccountIsNotActiveMailJob;
use TMS\Core\Jobs\Email\WelcomeEmailJob;
use TMS\Core\Notifications\Admin\CustomerRegistrationNotification;
use TMS\Core\Support\Services\AcceptInvitationService;
use TMS\Core\Support\Services\AdminNotificationService;
use TMS\User\Models\UserInvitation;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display Register page.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function showRegistrationForm(Request $request): Redirector|RedirectResponse|View
    {
        if ($request->get('utm_source') != 'invite' && Cookie::get('invite_code')) {
            Cookie::queue(Cookie::forget('invite_code'));

            return redirect(route('register'));
        }

        $invitation = Cookie::get('invite_code') ? UserInvitation::where('code', Cookie::get('invite_code'))->first() : '';

        return view('auth.register', compact('invitation'));
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data, $invitation = ''): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new EmailSpamRule],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if (empty($invitation)) {
            $rules['company'] = ['required', 'max:255'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Handle a registration request for the application.
     *
     * @return RedirectResponse|JsonResponse
     *
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $invitation = Cookie::get('invite_code') ? UserInvitation::Code(Cookie::get('invite_code'))->first() : '';

        $this->validator($request->all(), $invitation)->validate();

        $newCompany = false;

        DB::beginTransaction();
        try {
            $data = $request->all();

            if (! empty($invitation) && optional($invitation)->company) {
                $company = $invitation->company;
            } else {
                $newCompany = true;
                $company = (new InstallCompanyService())->create();
                $company->fill(['name' => $request->input('company')])->save();
            }

            $data['company_id'] = $company->id;
            $user = $this->create($data);

            if (! empty($invitation)) {
                (new AcceptInvitationService($user, $invitation))->accept();
            } else {
                setPermissionsTeamId($company->id);
                $company->users()->attach($user->id);
                $user->roles()->attach([2 => ['team_id' => $company->id]]);
                $user->permissions()->attach(Permission::all(), ['team_id' => $company->id]);
            }

            DB::commit();

            $user->refresh();
            $company->refresh();

            try {
                (new AdminNotificationService())
                    ->send(new CustomerRegistrationNotification($company, $user));
            } catch (Throwable $exception) {
                report($exception);
            }

            dispatch(new AccountIsNotActiveMailJob($user, $company))->delay(now()->addHours());
            dispatch(new AccountIsNotActiveMailJob($user, $company))->delay(now()->addDays());

            dispatch(new WelcomeEmailJob($user))->delay(now()->addHours(3));

            if (empty($invitation)) {
                dispatch(new DemoDriverCreateJob($company, $user));
            }

            if ($newCompany) {
                dispatch(new CRMImportAccountJob($company));
            }

            if (Cookie::get('invite_code') && empty($invitation)) {
                Cookie::queue(Cookie::forget('invite_code'));
                flash()->error("We're sorry, the invite is no longer valid.");
            }
        } catch (\Throwable $exception) {
            report($exception);
            DB::rollBack();
        }

        //event(new Registered($user));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_id' => $data['company_id'],
        ]);
    }
}
