<?php

namespace App\Http\Controllers\api;

use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Models\ConsaltantProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsaltanrProjectRequest;
use App\Http\Resources\ConsaltantProjectResource;

class ConsaltantProjectController extends Controller
{
    use ApiTrait;

    public function create(ConsaltanrProjectRequest $request)
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

        $project = ConsaltantProject::create($data);

        $project->load('user');

        return $this->success('offer created successfuly' , 200 , new ConsaltantProjectResource($project));
    }

    public function showAll()
    {
        $projects = ConsaltantProject::with('user')->get();

        return $this->success('All Projects' , 200 , ConsaltantProjectResource::collection($projects));
    }

    public function ShowUserProject()
    {
        $projects = ConsaltantProject::where('user_id' , auth()->id())->get();

        if(count($projects) > 0 )
        {
            return $this->success('All Projects' , 200 , ConsaltantProjectResource::collection($projects));
        }

        return $this->success('no projects' , 200 , null);
    }
}
