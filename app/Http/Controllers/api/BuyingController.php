<?php

namespace App\Http\Controllers\api;

use App\Models\Buying;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyingRequest;
use App\Http\Resources\BuyingResource;

class BuyingController extends Controller
{

    use ApiTrait;

    public function create(BuyingRequest $request)
    {
        $data = $request->except('images');
        $images = [];


        foreach ($request->file('images') as $image) {
            $path = $image->store('buying_images', 'uploads');
            $images[] = $path;
        }

        $data['images'] = json_encode($images);

        $data['user_id'] = auth()->id();

        $buying = Buying::create($data);

        return $this->success('buying created successfully' , 200 , new BuyingResource($buying));
    }

    public function show()
    {
        $buying = Buying::with('user')->get();

        return $this->success('All Buying' , 200 , BuyingResource::collection($buying));
    }

    public function ShowUserBuying()
    {
        $buying = Buying::where('user_id' , auth()->id())->get();

        if(count($buying) > 0)
        {
            return $this->success('All Buying' , 200 , BuyingResource::collection($buying));
        }
            return $this->success('no buying' , 200 , null);
    }
}
