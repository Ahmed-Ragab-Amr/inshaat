<?php

namespace App\Http\Controllers\api;

use App\Models\Offer;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    use ApiTrait;
    public function create(OfferRequest $request)
    {
        $data = $request->except(['cost' , 'technical' , 'plan']);

        $file1 = $request->file('cost');
        $path1 = $file1->store('cost_files' , 'uploads');
        $data['cost'] = $path1;

        $file2 = $request->file('technical');
        $path2 = $file1->store('technical_files' , 'uploads');
        $data['technical'] = $path2;

        $file3 = $request->file('plan');
        $path3 = $file1->store('plan_files' , 'uploads');
        $data['plan'] = $path3;

        $data['user_id'] = auth()->id();

        $offer = Offer::create($data);

        $offer->load('user');

        return $this->success('offer created successfuly' , 200 , new OfferResource($offer));
    }

    public function ShowProjectOffer($id)
    {
        $offers = Offer::with('user')->where('project_id' , $id)->get();

        if(count($offers) > 0)
        {
            return $this->success('All Offers' , 200 , OfferResource::collection($offers));
        }

        return $this->success('No Offers For This Project' , 200 , null);

    }

    public function ShowUserOffer()
    {
        $offers = Offer::where('user_id' , auth()->id())->get();

        if(count($offers) > 0)
        {
            return $this->success('All Offers' , 200 , OfferResource::collection($offers));
        }

        return $this->success('No Offers For This Project' , 200 , null);
    }

    public function acceptOffer(Request $reqeust , $id)
    {
        $offer = Offer::find($id);

        if(!$offer)
        {
            return $this->failed('offer not found' , 404 , null);
        }

        $offers = Offer::where('project_id' , $offer->project_id)->get();

        foreach($offers as $offerr)
        {
            $offerr->update([
                'status'=>'reject',
            ]);
        }

       $o =  $offer->update([
            'status'=>'accept',
        ]);

        return $this->success('offer is accepted' , 200 , $o);


    }
}
