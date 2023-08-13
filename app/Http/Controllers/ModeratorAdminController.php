<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\ModeratorAdminSettings;
use App\Helper;
use Illuminate\Validation\Rule;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentGateways;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Str;

class ModeratorAdminController extends Controller
{
	public function __construct()
	{}

	public function paymentsGateways()
	{
		$data = ModeratorAdminSettings::first();
        $stripeToken = DB::table('admin_settings')->first();
        // $oSettings = AdminSettings::first();
		return view('admin.moderator-stripe-setting')->with([
            'data' => $data,
            'stripe_moderator_account_id' => $stripeToken->stripe_moderator_account_id
			]);
	}//<--- End Method

	public function savePaymentsGateways(Request $request)
	{
        if(! Auth()->user()->role == 'moderator_admin') {
            return back()->withErrorMessage(trans('general.give_access_error'));
        }
        $this->validate($request, [
            'key' => 'required',
            'key_secret' => 'required',
            'webhook_secret' => 'required',
        ]);

        $data  = ModeratorAdminSettings::first();
        $data->key = $request->key;
        $data->key_secret = $request->key_secret;
        $data->webhook_secret = $request->webhook_secret;
		$data->save();

        // Helper::envUpdate('MODERATOR_STRIPE_KEY', $request->key);
        // Helper::envUpdate('MODERATOR_STRIPE_SECRET', $request->key_secret);
        // Helper::envUpdate('MODERATOR_STRIPE_WEBHOOK_SECRET', $request->webhook_secret);

        return back()->withSuccessMessage(__('admin.success_update'));
	}//<--- End Method

    public function redirectToStripe()
  {
    $payment = PaymentGateways::whereName('Stripe')->first();
    $stripe = new StripeClient($payment->key_secret);
    $user = User::findOrFail(auth()->id());
    $token = Str::random();    
    try {
        // Create account
        $account = $stripe->accounts->create([
            'country' => $user->country()->country_code,
            'type'    => 'express',
            'email'   => $user->email,
        ]);

        $onboardLink = $stripe->accountLinks->create([
            'account'     => $account->id,
            'refresh_url' => route('moderator.redirect.stripe'),
            'return_url'  => route('moderator.save.stripe', ['token' => $token, 'stripe_connect_id' => $account->id]),
            'type'        => 'account_onboarding'
        ]);

        return redirect($onboardLink->url);

    } catch (\Exception $exception){
        return back()->withErrorMessage($exception->getMessage()) ;
    }
    try {

        $loginLink = $stripe->accounts->createLoginLink($user->stripe_connect_id);
        return redirect($loginLink->url);

    } catch (\Exception $exception){
        return back()->withErrorMessage($exception->getMessage()) ;
    }
  }

  public function redirectToStripeView(){
    $payment = PaymentGateways::whereName('Stripe')->first();
    $stripe = new StripeClient($payment->key_secret);
    $stripeToken = DB::table('admin_settings')->first();
    
    try {
        $loginLink = $stripe->accounts->createLoginLink($stripeToken->stripe_moderator_account_id);
        return redirect($loginLink->url);
    } catch (\Exception $exception) {
        return back()->withErrorMessage($exception->getMessage());
    }
  }


  public function saveStripeAccount($token, $stripe_connect_id)
  {
    DB::table('admin_settings')->where('id',1)->update(['stripe_moderator_account_id' => $stripe_connect_id]);
    return redirect('panel/admin/moderator-admin-stripe')->withSuccessMessage(trans('admin.success_update'));
  }

}// End Class
