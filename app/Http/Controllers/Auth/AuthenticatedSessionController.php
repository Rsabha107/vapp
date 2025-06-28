<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use TechEd\SimplOtp\SimplOtp;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EmailOtpVerification;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.sign-in');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    // : RedirectResponse
    {
        Log::info('AuthenticatedSessionController:store');
        Log::info($request);

        session()->forget('OTPSESSIONKEY');

        $request->authenticate();

        // $user = User::find(Auth::user()->id);
        $user = auth()->user();

        $request->session()->regenerate();

        Auth::logoutOtherDevices($request->password);

        Log::info('AuthenticatedSessionController:store user: '.$user);
        Log::info('cms.use_otp: '.config('cms.use_otp'));
        if (config('cms.use_otp')) {
            // $this->showOtp();
            // $simpleOTP = new SimpleOTP();
            // $code = $simpleOTP->create(auth()->user()->email);
            $otp = SimplOtp::generate(auth()->user()->email);
            if($otp->status === true){
                $user->notify(new EmailOtpVerification($otp->token));
            }
            return view('auth/otp');
        }

                // //set the default workspace as set during user creation
                // session()->put('workspace_id', $request->user()->workspace_id);
                // Log::info('AuthenticatedSessionController:store workspace_id: '.$request->user()->workspace_id);

        // Log::info($request->authenticate());
        // Log::info($request->user()->role);
        $url = '';
        if ($request->user()->is_admin) {
            $url = 'vapp/admin';
            return redirect()->intended($url);
        } else {
            $url = 'vapp/customer';
            return redirect()->intended($url);
        }

        // if ($request->user()->role === 'admin'){
        //     $url = 'mds/admin/booking';
        //     return redirect()->intended($url);
        // } elseif  ($request->user()->role === 'user'){
        //     $url = 'mds/customer/booking';
        //     return redirect()->intended($url);
        // }

        // return back()->withErrors([
        //     'email' => 'Username and password don\'t match.',
        // ])->onlyInput('email');


        return redirect()->intended($url);
        // return redirect()->intended(RouteServiceProvider::HOME);.
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
