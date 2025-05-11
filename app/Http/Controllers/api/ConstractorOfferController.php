<?php

namespace App\Http\Controllers\api;

use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Models\ConstractorOffer;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConstractorOferRequest;
use App\Http\Resources\ConstractorOfferResource;

class ConstractorOfferController extends Controller
{
    use ApiTrait;

    public function create(ConstractorOferRequest $request)
    {

        $data = $request->except(['table' , 'technical' , 'plan']);

        $file1 = $request->file('table');
        $path1 = $file1->store('table_files' , 'uploads');
        $data['table'] = $path1;

        $file2 = $request->file('technical');
        $path2 = $file1->store('technical_files' , 'uploads');
        $data['technical'] = $path2;

        $file3 = $request->file('plan');
        $path3 = $file1->store('plan_files' , 'uploads');
        $data['plan'] = $path3;

        $data['user_id'] = auth()->id();

        $offer = ConstractorOffer::create($data);

        $offer->load('user');

        return $this->success('offer created successfuly' , 200 , new ConstractorOfferResource($offer));
    }

    public function ShowoProjectOffer($id)
    {
        $offers = ConstractorOffer::where('project_id' , $id)->get();

        if(count($offers) > 0)
        {
            return $this->success('All Offers' , 200 , ConstractorOfferResource::collection($offers));
        }

        return $this->sucess('no offers' , 200 , null);
    }
}
