<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function processPayment()
    {
        $post_data = array();
        $post_data['store_id'] = "store_key_here";
        $post_data['store_passwd'] = "store_password_here";
        $post_data['total_amount'] = "50";
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = now()->format('d-m-Y') . '-' . uniqid();
        $post_data['success_url'] = url('/payment-status');
        $post_data['fail_url'] = url('/payment-status');
        $post_data['cancel_url'] = url('/payment-status');
        $post_data['shipping_method'] = "no";
        $post_data['product_name'] = "demo";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = fake()->name;
        $post_data['cus_email'] = fake()->email;
        $post_data['cus_add1'] = "Dhaka";
        $post_data['cus_add2'] = "Dhaka";
        $post_data['cus_city'] = "Dhaka";
        $post_data['cus_state'] = "Dhaka";
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '01733499574';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1 '] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country'] = "Bangladesh";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b '] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # EMI STATUS
        $post_data['emi_option'] = "1";

        # CART PARAMETERS
        $post_data['cart'] = json_encode(array(
            array("product" => "DHK TO BRS AC A1", "amount" => "200.00"),
            array("product" => "DHK TO BRS AC A2", "amount" => "200.00"),
            array("product" => "DHK TO BRS AC A3", "amount" => "200.00"),
            array("product" => "DHK TO BRS AC A4", "amount" => "200.00")
        ));
        $post_data['product_amount'] = "100";
        $post_data['product_category'] = "garments products";
        $post_data['product_profile'] = "non-physical-goods";
        $post_data['vat'] = "5";
        $post_data['discount_amount'] = "5";
        $post_data['convenience_fee'] = "3";


        //$post_data['allowed_bin'] = "3,4";
        //$post_data['allowed_bin'] = "470661";
        //$post_data['allowed_bin'] = "470661,376947";


        # REQUEST SEND TO SSLCOMMERZ
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }

        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            // this is important to show the popup, return or echo to sent json response back
            return  json_encode(['status' => 'success', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
        } else {
            return  json_encode(['status' => 'fail', 'data' => null, 'message' => "JSON Data parsing error!"]);
        }
    }

    public function paymentStatus(Request $request)
    {
        dd(request()->all(), request()->ip());
    }
}
