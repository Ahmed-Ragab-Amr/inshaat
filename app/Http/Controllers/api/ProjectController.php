<?php

namespace App\Http\Controllers\api;

use App\Models\Project;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller
{
    use ApiTrait;
    public function create(CreateProjectRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();

        $project = Project::create($data);

        return $this->success('project created successfuly' , 200 , new ProjectResource($project));
    }

    public function showOne()
    {
        $project = Project::where('user_id' , auth()->user()->id)->get();

        if(count($project) > 0)
        {
            return $this->success('prjects' , 200 , ProjectResource::collection($project));
        }

        return $this->failed('no projects' , 200 , null);
    }

    public function showAll()
    {
        $projects = Project::with('user')->get();

        return $this->success('All Projects' , 200 , ProjectResource::collection($projects));
    }
}
