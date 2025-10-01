<?php

namespace App\Livewire\User;

use App\Models\Package;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use PayFast\PayFastApi;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Subscription extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $package;
    public $button;

    public function mount(Package $package): void
    {
        $this->package = $package;
        $this->button = $this->button();
    }


    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        return view('user.update-subscription');
    }

    public function button(): string
    {
            $data = array(
                // Merchant details
                'merchant_id' => config('payfast.merchant_id'),
                'merchant_key' => config('payfast.merchant_key'),
                'return_url' => config('payfast.return_url'),
                'cancel_url' => config('payfast.cancel_url'),
                'notify_url' => config('payfast.notify_url').'/'.Auth::user()->id,
                'name_first' => Auth::user()->name,
                'email_address' => 'johankit2@gmail.com',//Auth::user()->email,
                'm_payment_id' => Auth::user()->id,
                'amount' => number_format(sprintf('%.2f', $this->package->price), 2, '.', ''),
                'item_name' => $this->package->name,
                'custom_int1' => $this->package->id,
//                'payment_method' => 'cc',
                // Buyer details
                'subscription_type' => '1',
                'frequency' => '3',
                'cycles'=>'0'
            );
            $signature = $this->generateSignature($data);
            $data['signature'] = $signature;

// If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
            $testingMode = config('payfast.test_mode');
            $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
            $htmlForm = '<form action="https://' . $pfHost . '/eng/process" method="post">';
            foreach ($data as $name => $value) {
                $htmlForm .= '<input name="'.$name.'" type="hidden" value=\''.$value.'\' />';
            }
            $htmlForm .= '<button type="submit" class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out bg-primary-400 hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]" />Pay Now</form>';

            return $htmlForm;
    }

    public function generateSignature(array $data): string
    {
        $passPhrase = config('payfast.passphrase'); //config('payfast.passphrase');
        $pfOutput = '';
        foreach( $data as $key => $val ) {
            if($val !== '') {
                $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
            }
        }
        // Remove last ampersand
        $getString = substr( $pfOutput, 0, -1 );
        if( $passPhrase !== null ) {
            $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
        }
//        dump( $getString );
        return md5( $getString );
    }

    public function confirmUpgrade(): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to change your subscription?',
            'acceptLabel' => 'Yes, change',
            'method' => 'upgrade',
            'icon' => 'warning',
        ]);
    }
    public function upgrade()
    {
        try {
            $api = new PayFastApi(
                [
                    'merchantId' => config('payfast.merchant_id'),
                    'merchantKey' => config('payfast.merchant_key'),
                    'passPhrase' => config('payfast.passphrase'),
                     'testMode' => config('payfast.test_mode')
                ]
            );
            $updateArray = $api->subscriptions->update(Auth::user()->pf_token, ['amount' => $this->package->price * 100, 'item_name' => $this->package->name, 'custom_int1' => $this->package->id]);
            if($updateArray['status'] == 'success') {
                Auth::user()->update(['package_id' => $this->package->id]);
                $this->notification()->success(
                    $title = 'Update',
                    $description = 'Your package has been updated.'
                );
                $this->dispatch('closeModal');
                return redirect()->route('user.subscription');
            }else{
                $this->notification()->error(
                    $title = 'Oops',
                    $description = 'There was an error: '. $updateArray['data']['message']
                );
            }
        } catch(Exception $e) {
            $this->notification()->error(
                $title = 'Oops',
                $description = 'There was an exception: '.$e->getMessage()
            );
        }
    }
    public function confirmCancel(): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to cancel your subscription?',
            'acceptLabel' => 'Yes, cancel',
            'method' => 'cancel',
            'icon' => 'warning',
        ]);
    }
    public function cancel(): void
    {
        try {
            $api = new PayFastApi(
                [
                    'merchantId' => config('payfast.merchant_id'),
                    'merchantKey' => config('payfast.merchant_key'),
                    'passPhrase' => config('payfast.passphrase'),
                     'testMode' => config('payfast.test_mode')
                ]
            );
            $updateArray =  $api->subscriptions->cancel(Auth::user()->pf_token);
            if($updateArray['status'] == 'success') {
                Auth::user()->update(['pf_status' => 'Inactive']);
                $this->notification()->success(
                    $title = 'Update',
                    $description = 'Your subscription has been canceled.'
                );
                $this->dispatch('closeModal');
            }else{
                $this->notification()->error(
                    $title = 'Oops',
                    $description = 'There was an error: '. $updateArray['data']['message']
                );
            }
        } catch(Exception $e) {
            $this->notification()->error(
                $title = 'Oops',
                $description = 'There was an exception: '.$e->getMessage()
            );
        }
    }
    public function confirmPause(): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to pause your subscription?',
            'acceptLabel' => 'Yes, pause',
            'method' => 'pause',
            'icon' => 'warning',
        ]);
    }
    public function pause(): void
    {
        try {
            $api = new PayFastApi(
                [
                    'merchantId' => config('payfast.merchant_id'),
                    'merchantKey' => config('payfast.merchant_key'),
                    'passPhrase' => config('payfast.passphrase'),
                     'testMode' => config('payfast.test_mode')
                ]
            );
            $updateArray =  $api->subscriptions->pause(Auth::user()->pf_token);
            if($updateArray['status'] == 'success') {
                Auth::user()->update(['pf_status' => 'Paused']);
                $this->notification()->success(
                    $title = 'Update',
                    $description = 'Your subscription has been paused.'
                );
                $this->dispatch('closeModal');
            }else{
                $this->notification()->error(
                    $title = 'Oops',
                    $description = 'There was an error: '. $updateArray['data']['message']
                );
            }
        } catch(Exception $e) {
            $this->notification()->error(
                $title = 'Oops',
                $description = 'There was an exception: '.$e->getMessage()
            );
        }
    }
    public function confirmResume(): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to resume your subscription?',
            'acceptLabel' => 'Yes, resume',
            'method' => 'resume',
            'icon' => 'warning',
        ]);
    }
    public function resume(): void
    {
        try {
            $api = new PayFastApi(
                [
                    'merchantId' => config('payfast.merchant_id'),
                    'merchantKey' => config('payfast.merchant_key'),
                    'passPhrase' => config('payfast.passphrase'),
                     'testMode' => config('payfast.test_mode')
                ]
            );
            $updateArray =  $api->subscriptions->unpause(Auth::user()->pf_token);
            if($updateArray['status'] == 'success') {
                Auth::user()->update(['pf_status' => 'Active']);
                $this->notification()->success(
                    $title = 'Update',
                    $description = 'Your subscription has been resumed.'
                );
                $this->dispatch('closeModal');
            }else{
                $this->notification()->error(
                    $title = 'Oops',
                    $description = 'There was an error: '. $updateArray['data']['message']
                );
            }
        } catch(Exception $e) {
            $this->notification()->error(
                $title = 'Oops',
                $description = 'There was an exception: '.$e->getMessage()
            );
        }
    }
}
