<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Provider;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Services\WhatsAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\UserProviderResource;
use Illuminate\Support\Facades\Http;

class ProviderController extends Controller
{
    use ApiTrait;

    public function create(ProviderRequest $reqeust)
    {
        $data = $reqeust->except('image');

        $file = $reqeust->file('image');
        $path = $file->store('provider_image' , 'uploads');
        $data['image'] = $path;

        $data['user_id'] = auth()->id();
        $data['status'] = 'waiting';
        $provider = Provider::create($data);

        return $this->success('provider data created successfully' , 200  , new ProviderResource($provider));
    }

    public function show()
    {
        $providers = Provider::with('user')->where('status' , 'waiting')->get();

        return $this->success('All Providers' , 200 , ProviderResource::collection($providers));
    }

    public function showOne($id)
    {
        $user = User::with('provider')->find($id);

        if(!$user)
        {
            return $this->failed('User Not Found' , 404 , null);
        }

        return $this->success('user details' , 200 , new UserProviderResource($user));

    }

    public function accept(Request $request, $id)
{
    $provider = Provider::find($id);
    if (!$provider) {
        return $this->failed('Provider not found', 404, null);
    }

    $updated = $provider->update([
        'status' => 'accept',
    ]);

    // تحديد رقم الهاتف والرسالة
    $phone = "+201003980876";
    $smsMessage = "تم قبول طلبك في نظامنا بنجاح.";

    // جلب بيانات تويليو من ملف البيئة
    $sid          = env('TWILIO_SID');
    $token        = env('TWILIO_AUTH_TOKEN');
    $twilioNumber = env('TWILIO_NUMBER');

    // URL الخاص بإرسال الرسائل في تويليو
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

    try {
        $response = Http::withBasicAuth($sid, $token)
            ->withOptions(['verify' => false]) // تجاوز التحقق من شهادة SSL
            ->asForm()
            ->post($url, [
                'From' => $twilioNumber,
                'To'   => $phone,
                'Body' => $smsMessage,
            ]);

        if (!$response->successful()) {
            return $this->failed('Provider accepted but failed to send SMS: ' . $response->body(), 500, null);
        }
    } catch (\Exception $e) {
        return $this->failed('Provider accepted but failed to send SMS: ' . $e->getMessage(), 500, null);
    }

    return $this->success('Provider accepted successfully and SMS sent', 200, $updated);
}

    public function reject(Request $reqeust  , $id)
    {
        $provider = Provider::find($id);
        if(!$provider)
        {
            return $this->failed('prvider not found' , 404 , null);
        }

        $updated = $provider->update([
            'status'=>'reject',
        ]);

        return $this->success('provider rejected succefuly' , 200 , $updated);
    }

}
