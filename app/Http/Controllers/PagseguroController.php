<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Pagseguro_transaction;
use App\System_company;

class PagseguroController extends Controller
{
    public function autorization(Request $request)
    {
        $data = $request->all();

        $response = Http::asform()->post('https://ws.sandbox.pagseguro.uol.com.br/v2/checkout?email=cwrsiqueira@msn.com&token=BA4C77D506A043E9B943C0B0FFDAAD00', [
            'currency' => 'BRL',
            'itemId1' => $data['item_id'],
            'itemDescription1' => $data['item_description'],
            'itemAmount1' => $data['item_amount'],
            'itemQuantity1' => '1',
            'itemWeight1' => '0',
            'senderEmail' => 'c92477492287506544088@sandbox.pagseguro.com.br',
            'shippingAddressRequired' => 'false',
            'receiverEmail' => 'cwrsiqueira@msn.com',
            'reference' => $data['item_id'],
        ]);
        
        $xml = simplexml_load_string($response->body());
        $autorization_code = get_object_vars($xml)['code'];

        return redirect()->route('pagseguro_payment', ['code' => $autorization_code]);
    }

    public function payment($code) {

        return view('pagseguro_checkout', [
            'code' => $code
        ]);
    }

    public function response() {

        if (!empty($_GET['transaction_id'])) {
            $transaction_id = $_GET['transaction_id'];
            $action = new Pagseguro_transaction();
            $action->company_id = Auth::user()->id_company;
            $action->transaction_id = $transaction_id;
            $action->status_id = 1;
            $action->status_description = "Aguardando pagamento";
            $action->save();
        }
        
        return redirect()->route('home.index');
    }

    public function update() {
        var_dump($_POST);
        // $update = Http::withHeaders([
        //     'Authorization' => 'Bearer BA4C77D506A043E9B943C0B0FFDAAD00',
        // ])->post('https://sandbox.api.pagseguro.com/digital-payments/v1/transactions/'.$code.'/status');
        // dd($update);
    }
}
