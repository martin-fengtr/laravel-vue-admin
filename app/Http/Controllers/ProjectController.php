<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Project/List', [
            'projects' => Project::all()->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'company' => $project->company,
                    'editUrl' => URL::route('project.edit', $project),
                    'deleteUrl' => URL::route('project.destroy', $project),
                    'allowQR'   => $project->allowQR,

                ];
            }),
            'createUrl' => URL::route('project.create'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Project/Edit', [
            'users' => User::where('username', '<>', 'Admin')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'editUrl' => URL::route('user.edit', $user),
                    'deleteUrl' => URL::route('user.destroy', $user),
                ];
            }),
            'companies' => Company::all()->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'editUrl' => URL::route('company.edit', $company),
                    'deleteUrl' => URL::route('company.destroy', $company),
                ];
            }),
            'backUrl' => URL::route('project.index'),
            'saveUrl' => URL::route('project.store'),
            'appUrl'  => config('app.url'),
        ]);
    }

    public function edit($projectId)
    {
        $project = Project::where('id', $projectId)->first();
        return Inertia::render('Project/Edit', [
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'companyId' => $project->company ? $project->company->id : '',
                'hash'      => $project->hash,
            ],
            'users' => User::where('username', '<>', 'Admin')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'editUrl' => URL::route('user.edit', $user),
                    'deleteUrl' => URL::route('user.destroy', $user),
                ];
            }),
            'companies' => Company::all()->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'editUrl' => URL::route('company.edit', $company),
                    'deleteUrl' => URL::route('company.destroy', $company),
                ];
            }),
            'backUrl' => URL::route('project.index'),
            'saveUrl' => URL::route('project.update', $project),
            'appUrl'  => config('app.url'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'companyId' => ['required', 'integer', 'exists:companies,id'],
            'name' => ['required', 'max:255'],
        ]);

        Project::create([
            'company_id' => $request->companyId,
            'name' => $request->name,
            'hash' => Str::random(10),
        ]);

        return Redirect::route('project.index');
    }

    public function update(Request $request, $projectId)
    {
        $request->validate([
            'companyId' => ['required', 'integer', 'exists:companies,id'],
            'name' => ['required', 'max:255'],
        ]);

        $project = Project::where('id', $projectId)->first();
        if ($project) {
            $project->company_id = $request->companyId;
            $project->name = $request->name;
            $project->save();
        }

        return Redirect::route('project.index');
    }

    public function destroy($projectId)
    {
        Project::destroy($projectId);

        return Redirect::route('project.index');
    }

    public function updateQRfield(Request $request)
    {
        Project::whereId($request->id)->update(['allowQR'=>$request->status]);

        return $request->status;
    }

    public function getInfoQR($hush)
    {
        $response = Project::where('hash',$hush)->first();

        return response()->json($response);
    }
}
