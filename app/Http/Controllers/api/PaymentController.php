<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Payment;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    use ApiTrait;

    public function create(PaymentRequest $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();

        $payment = Payment::create($data);

        return $this->success('payment added successfully' , 200 , new PaymentResource($payment));
    }

    public function updateMain(Request $request , $id)
    {
        $payment = Payment::find($id);

        if(!$payment)
        {
            return $this->failed('payment not found' , 404 , null);
        }

        $user = User::find(auth()->id());
        $user_payments = $user->payments;

        foreach($user_payments as $paymentt)
        {
            $paymentt->update([
                'status'=>'not_main',
            ]);
        }

        $pay = $payment->update([
            'status'=>'main',
        ]);

        return $this->success('payment updated to main' , 200 , $pay);
    }
}
