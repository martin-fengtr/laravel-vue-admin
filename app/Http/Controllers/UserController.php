<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('User/List', [
            'users' => User::where('username', '<>', 'Admin')->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'status' => $user->status,
                    'role' => $user->role,
                    'editUrl' => URL::route('user.edit', $user),
                    'deleteUrl' => URL::route('user.destroy', $user),

                ];
            }),
            'createUrl' => URL::route('user.create'),
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Edit', [
            'companies' => Company::all()->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'editUrl' => URL::route('company.edit', $company),
                    'deleteUrl' => URL::route('company.destroy', $company),
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
            'roles' => Role::all(),
            'statuses' => UserStatus::all(),
            'backUrl' => URL::route('user.index'),
            'saveUrl' => URL::route('user.store'),
        ]);
    }

    public function edit($userId)
    {
        $user = User::where('id', $userId)->first();
        return Inertia::render('User/Edit', [
            'selectedUser' => $user,
            'companies' => Company::all()->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'editUrl' => URL::route('company.edit', $company),
                    'deleteUrl' => URL::route('company.destroy', $company),
                ];
            }),
            'projects' => Project::all()->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'editUrl' => URL::route('project.edit', $project),
                    'deleteUrl' => URL::route('project.destroy', $project),
                    'allowQR'   => $project->allowQR,
                ];
            }),
            'roles' => Role::all(),
            'statuses' => UserStatus::all(),
            'backUrl' => URL::route('user.index'),
            'saveUrl' => URL::route('user.update', $user),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password],
            'firstName' => ['required', 'string', 'max:100'],
            'lastName' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'companyId' => ['required', 'integer', 'exists:companies,id'],
            'address' => ['nullable', 'string'],
            'roleId' => ['nullable', 'integer', 'exists:roles,id'],
            'statusId' => ['nullable', 'integer', 'exists:user_statuses,id'],
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phoneNumber,
            'company_id' => $request->companyId,
            'address' => $request->address,
            'role_id' => $request->roleId,
            'status_id' => $request->statusId,
        ]);

        return Redirect::route('user.index');
    }

    public function update(Request $request, $userId)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'firstName' => ['required', 'string', 'max:100'],
            'lastName' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'companyId' => ['required', 'integer', 'exists:companies,id'],
            'address' => ['nullable', 'string'],
            'roleId' => ['nullable', 'integer', 'exists:roles,id'],
            'statusId' => ['nullable', 'integer', 'exists:user_statuses,id'],
        ]);

        $user = User::where('id', $userId)->first();
        if ($user) {
            $user->username = $request->username;
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->email = $request->email;
            $user->phone = $request->phoneNumber;
            $user->company_id = $request->companyId;
            $user->address = $request->address;
            $user->role_id = $request->roleId;
            $user->status_id = $request->statusId;
            $user->save();
        }

        return Redirect::route('user.index');
    }

    public function destroy($userId)
    {
        User::destroy($userId);

        return Redirect::route('user.index');
    }

    public function login(Request $request)
    {
        $input = $request->only('username');

        $rules = [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', new Password],
        ];

        if (filter_var($input['username'], FILTER_VALIDATE_EMAIL)) {
            $rules['username'][] = 'email';
        }

        $request->validate($rules, [
            'username.required' => 'Enter username or email to login.',
        ]);

        $username = $request->username;
        $password = $request->password;

        $user = User::with(['status', 'role', 'company'])->where('username', $username)->orWhere('email', $username)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => "The provided credentials are incorrect.",
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken($user->role->name)->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'accessToken' => $token,
                'user' => $user,
            ],
        ], Response::HTTP_OK);
    }

}
