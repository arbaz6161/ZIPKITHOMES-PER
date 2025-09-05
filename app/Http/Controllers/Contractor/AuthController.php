<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register($subdomain) {
        $previousUrl = url()->previous();

        if (str_ends_with(parse_url($previousUrl, PHP_URL_PATH), 'project/create')) {
            Session::put('previous_url', $previousUrl);
        }

        return view('contractor.auth.register', ['subdomain' => $subdomain]);
    }

    public function store(Request $request, $subdomain) {
        $values = $request->validate([
            "first_name"  => "required|string|max:255",
            "last_name"  => "required|string|max:255",
            "email"  => "required|email|unique:users",
            "password" => "required|string|max:255"
        ]);

        try {
            $apiData = [
                'name' => $values['first_name'] . ' ' . $values['last_name'],
                'email' => $values['email'],
                'password' => $values['password'],
                'type' => 'home-buyer',
            ];

            $response = Http::post('https://app.focusproject.com/api/create-user', $apiData);

            if ($response->successful()) {

                $values['contractor_id'] = 13;
                $values['password'] = bcrypt($values['password']);
                $values['user_role_id'] = 5;

                $user = User::create($values);

                Auth::login($user);
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $previousUrl = session('previous_url');
        if ($previousUrl) {
            return redirect()->to($previousUrl)->with('success', 'Home buyer has been created successfully');
        }

        return redirect()->route('contractor.floorplans.index', ['subdomain' => $subdomain])->with('success', 'Home buyer has been created successfully');
    }

    public function login($subdomain) {
        $previousUrl = url()->previous();

        if (str_ends_with(parse_url($previousUrl, PHP_URL_PATH), 'project/create')) {
            Session::put('previous_url', $previousUrl);
        }

        return view('contractor.auth.login', ['subdomain' => $subdomain]);
    }

    public function authenticate(Request $request, $subdomain) {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Retrieve the token from the request
        $token = $request->input('g-recaptcha-response');

        // Build verification request to Google
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.v3_secret_key'),
                'response' => $token
            ]
        ]);

        // Decode the response
        $result = json_decode($response->getBody(), true);

        // Check "success" and set your own score threshold (e.g., 0.5)
        if ($result['success'] && $result['score'] >= 0.5) {
            $remember_me = $request->has('remember') ? true : false;

            if (Auth::attempt($credentials, $remember_me)) {
                $user_details = Auth::user();

                if (isset($user_details) && $user_details->user_role_id == 5) {
                    $request->session()->regenerate();

                    $previousUrl = session('previous_url');
                    if ($previousUrl) {
                        return redirect()->to($previousUrl)->with('success', 'Home buyer has been logged in successfully');
                    }

                    return redirect()->route('contractor.floorplans.index', ['subdomain' => $subdomain])->with('success', 'Home buyer has been logged in successfully');
                } else {
                    Auth::logout();
                }
            }

            return back()->with('error', 'The provided credentials do not match our records.');
        } else {
            // The token is invalid or suspicious (score < 0.5)
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }
    }

    public function logout(Request $request, $subdomain)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect()->back()->with('success', 'Home buyer has been logged out successfully.');
    }

    /**
     * [GET] : Show forgot password form.
     */
    public function show_forgot_password_form(Request $request, $subdomain)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.forgot-password', ['subdomain' => $subdomain, "contractor" => $contractor]);
    }

    /**
     * [POST] : Forgot password handler.
     */
    public function forgot_password(Request $request, $subdomain)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails())
            return back()->with('error', "Email is required");

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['error' => __($status)]);
    }

    /**
     * [GET] : Reset password form.
     */
    public function show_reset_password_form(Request $request, $subdomain, $token)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.reset_password', ["subdomain" => $subdomain, 'contractor' => $contractor, "token" => $token]);
    }

    /**
     * [POST] : Reset password handler.
     */
    public function reset_password(Request $request, $subdomain)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails())
            return back()->with('error', "Fill the form with exact values");

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('contractor.admin.login', ['subdomain' => $subdomain])->with('success', __($status))
            : back()->with(['error' => [__($status)]]);
    }
}
