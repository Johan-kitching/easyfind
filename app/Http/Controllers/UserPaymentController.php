<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    public $userPackage;

    public function index()
    {
        $this->userPackage = auth()->user()->package_id;
        return view('user.payments', ['payments' => UserPayment::where('user_id', auth()->user()->id)->get(), 'packages' => Package::all(), 'userPackage' => $this->userPackage]);
    }

    public function indexAdmin()
    {
        return view('payments.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'package_id' => ['required', 'exists:packages'],
            'amount' => ['required'],
            'response' => ['required'],
        ]);

        return UserPayment::create($data);
    }

    public function show(UserPayment $userPayment)
    {
        return $userPayment;
    }

    public function update(Request $request, UserPayment $userPayment)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'package_id' => ['required', 'exists:packages'],
            'amount' => ['required'],
            'response' => ['required'],
        ]);

        $userPayment->update($data);

        return $userPayment;
    }

    public function destroy(UserPayment $userPayment)
    {
        $userPayment->delete();

        return response()->json();
    }

    public function logPayment(Request $data)
    {
        logger('PayFast Callback Data:', $data->all());
        $user = User::find($data['m_payment_id']);
        $package = Package::find($data['custom_int1']);
        $userPayment = new UserPayment();
        $pfHost = config('payfast.sandbox') ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $expectedFields = [
            'm_payment_id', 'pf_payment_id', 'payment_status', 'item_name',
            'item_description', 'amount_gross', 'amount_fee', 'amount_net',
            'custom_str1', 'custom_str2', 'custom_str3', 'custom_str4', 'custom_str5',
            'custom_int1', 'custom_int2', 'custom_int3', 'custom_int4', 'custom_int5',
            'name_first', 'name_last', 'email_address', 'merchant_id', 'token',
            'billing_date', 'signature'
        ];

        // Extract ONLY the expected PayFast data from the request
        $pfData = $data->only($expectedFields);

        // Validate that required fields exist (adjust as needed)
        if (!isset($pfData['m_payment_id'], $pfData['signature'])) {
            return response('Invalid data', 400);
        }

        // Process the payment data
        $user = User::find($pfData['m_payment_id']);
        $package = $user->package()->first();

        // Generate the parameter string for signature validation
        $pfParamString = '';
        foreach ($pfData as $key => $val) {
            if ($key !== 'signature') {
                $pfParamString .= $key . '=' . urlencode(stripslashes($val)) . '&';
            }
        }

        // Validate the signature (assuming you have this method)
        $checkSignature = $pfData['signature'] === $this->pfValidSignature($pfData, rtrim($pfParamString, '&'), config('payfast.passphrase'));
        $checkPrice =$this->pfValidPaymentData($package->price, $pfData);
        $checkDomain = $this->pfValidIP();
        $checkServer = $this->pfValidServerConfirmation($pfParamString, $pfHost);

        \Log::info('PayFast Callback:', [
            'data' => $pfData,
            'checkSignature' => $checkSignature,
            'priceCheck' => $checkPrice,
            'checkDomain' => $checkDomain,
            'checkServer' => $checkServer,
            'packagePrice' => $package->price,
        ]);
        // Check if the payment is valid
        if($checkSignature && $checkPrice && $checkDomain && $checkServer) {
            // Update the user and package
//            $user->package_id = $pfData['custom_int1'];
            $user->pf_token = $pfData['token'];
            $user->pf_status = 'Active';
            $user->save();

            // Save the payment data
            $userPayment->user_id = $pfData['m_payment_id'];
            $userPayment->package_id = $package->id;
            $userPayment->amount = $pfData['amount_gross'];
            $userPayment->response = json_encode($pfData);
            $userPayment->pf_token = $pfData['token'];
            $userPayment->save();
        }

        return response('OK', 200)
            ->header('Content-Type', 'text/plain');
    }

    public function pfValidSignature($pfData, $pfParamString, $pfPassphrase = null)
    {
        // Calculate security signature
        if ($pfPassphrase === null) {
            $tempParamString = $pfParamString;
        } else {
            $tempParamString = $pfParamString . '&passphrase=' . urlencode($pfPassphrase);
        }

        $signature = md5($tempParamString);
        return ($signature);
    }

    public function pfValidServerConfirmation( $pfParamString, $pfHost = 'sandbox.payfast.co.za', $pfProxy = null ) {
        // Use cURL (if available)
        if( in_array( 'curl', get_loaded_extensions(), true ) ) {
            // Variable initialization
            $url = 'https://'. $pfHost .'/eng/query/validate';

            // Create default cURL object
            $ch = curl_init();

            // Set cURL options - Use curl_setopt for greater PHP compatibility
            // Base settings
            curl_setopt( $ch, CURLOPT_USERAGENT, NULL );  // Set user agent
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );      // Return output as string rather than outputting it
            curl_setopt( $ch, CURLOPT_HEADER, false );             // Don't include header in output
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );

            // Standard settings
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $pfParamString );
            if( !empty( $pfProxy ) )
                curl_setopt( $ch, CURLOPT_PROXY, $pfProxy );

            // Execute cURL
            $response = curl_exec( $ch );
            curl_close( $ch );
            if ($response === 'VALID') {
                return true;
            }
        }
        return false;
    }

    public function pfValidIP() {
        // Variable initialization
        $validHosts = array(
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        );

        $validIps = [];

        foreach( $validHosts as $pfHostname ) {
            $ips = gethostbynamel( $pfHostname );

            if( $ips !== false )
                $validIps = array_merge( $validIps, $ips );
        }

        // Remove duplicates
        $validIps = array_unique( $validIps );
        $referrerIp = gethostbyname(parse_url($_SERVER['HTTP_REFERER'])['host']);
        if( in_array( $referrerIp, $validIps, true ) ) {
            return true;
        }
        return false;
    }

    public function pfValidPaymentData( $cartTotal, $pfData ) {
        return !(abs((float)$cartTotal - (float)$pfData['amount_gross']) > 0.01);
    }
}
