<?php

namespace App\Http\Controllers\api;

use App\Models\Plan;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{

    use ApiTrait;

    public function create(PlanRequest $request)
    {
        $data = $request->except(['plan' , 'offer']);

        $file1 = $request->file('plan');
        $path1 = $file1->store('plan_files' , 'uploads');
        $data['plan'] = $path1;

        $file2 = $request->file('offer');
        $path2 = $file2->store('offer_files' , 'uploads');
        $data['offer'] = $path2;

        $data['user_id'] = auth()->id();

        $plan = Plan::create($data);

        $plan->load('user');

        return $this->success('plan created successfully' , 200 , new PlanResource($plan));
    }
}
