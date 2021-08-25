<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Company/List', [
            'companies' => Company::all()->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'editUrl' => URL::route('company.edit', $company),
                    'deleteUrl' => URL::route('company.destroy', $company),
                ];
            }),
            'createUrl' => URL::route('company.create'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Company/Edit', [
            'users' => User::where('username', '<>', 'Admin')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'editUrl' => URL::route('user.edit', $user),
                    'deleteUrl' => URL::route('user.destroy', $user),
                ];
            }),
            'projects' => Project::all()->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'editUrl' => URL::route('project.edit', $project),
                    'deleteUrl' => URL::route('project.destroy', $project),
                ];
            }),
            'backUrl' => URL::route('company.index'),
            'saveUrl' => URL::route('company.store'),
        ]);
    }

    public function edit($companyId)
    {
        $company = Company::where('id', $companyId)->first();
        return Inertia::render('Company/Edit', [
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'projects' => $company->projects,
            ],
            'users' => User::where('username', '<>', 'Admin')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'editUrl' => URL::route('user.edit', $user),
                    'deleteUrl' => URL::route('user.destroy', $user),
                ];
            }),
            'projects' => Project::all()->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'editUrl' => URL::route('project.edit', $project),
                    'deleteUrl' => URL::route('project.destroy', $project),
                ];
            }),
            'backUrl' => URL::route('company.index'),
            'saveUrl' => URL::route('company.update', $company),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        Company::create([
            'name' => $request->name,
        ]);

        return Redirect::route('company.index');
    }

    public function update(Request $request, $companyId)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $company = Company::where('id', $companyId)->first();
        if ($company) {
            $company->name = $request->name;
            $company->save();
        }

        return Redirect::route('company.index');
    }

    public function destroy($companyId)
    {
        Company::destroy($companyId);

        return Redirect::route('company.index');
    }

}
