<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Designation;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="d-flex">
                                          <a href="'.url("admin/users/".$row->id."/edit").'" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.create', [
            'designations' => Designation::all(),
            'courts' => Court::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $attributes = $this->validateUser();
        $attributes['password'] = bcrypt($attributes['password']);

        $attributes['image'] = basename(request()->file('image')->store('public/images'));

        DB::transaction(function () use ($attributes) {

            User::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => $attributes['password'],
                'designation_id' => $attributes['designation'],
                'court_id' => $attributes['court']
            ])->profile()->create([
                'image' => $attributes['image']
            ]);
        });

        return back()->with('success', 'User Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        return view('admin.users.edit', [
            'user' => User::findOrFail($id),
            'designations' => Designation::all(),
            'courts' => Court::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $user = User::findOrFail($id);

        $attributes = $this->validateUser($user);
        $attributes['password'] = bcrypt($attributes['password']);

        if(request('image') ?? false)
            $attributes['image'] = basename(request()->file('image')->store('public/images'));



        DB::transaction(function () use ($user, $attributes) {
            $user->update([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => $attributes['password'],
                'designation_id' => $attributes['designation'],
                'court_id' => $attributes['court']
            ]);

            if(request('image') ?? false) {
                $user->profile()->update(
                    ['image' => $attributes['image']]
                );
            }

        });

        return back()->with('success', 'User Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateUser(?User $user = null): array
    {
        $user ??= new User();

        return request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user)],
            'password' => 'required',
            'designation' => 'required',
            'court' => 'required',
            'image' => $user->exists ? ['image'] : ['required', 'image']
        ]);
    }


}
