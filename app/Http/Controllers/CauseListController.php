<?php

namespace App\Http\Controllers;

use App\Models\CauseList;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CauseListController extends Controller
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
            $data = CauseList::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('court_id', function ($row) {

                    return CauseList::find($row->id)->court->name;
                })
                ->addColumn('normal_file', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="text-center">
                                          <a href="' . asset("storage/cause_lists/" . $row->normal_file . "") . '" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-download"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->addColumn('old_file', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="text-center">
                                          <a href="' . asset("storage/cause_lists/" . $row->old_file . "") . '" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-download"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="text-center">
                                          <a href="' . url("admin/cause_lists/" . $row->id . "/edit") . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->rawColumns(['action', 'normal_file', 'old_file'])
                ->make(true);
        }

        return view('admin.cause_lists.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.cause_lists.create', [
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
        $attributes = $this->validateCauseList();

        $attributes['normal_file'] = basename(request()->file('normal_file')->store('public/cause_lists'));
        $attributes['old_file'] = basename(request()->file('old_file')->store('public/cause_lists'));

        DB::transaction(function () use ($attributes) {

            CauseList::create([
                'court_id' => $attributes['court'],
                'date' => $attributes['date'],
                'normal_file' => $attributes['normal_file'],
                'old_file' => $attributes['old_file']
            ]);
        });

        return back()->with('success', 'Cause List Created!');
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
        return view('admin.cause_lists.edit', [
            'causeList' => CauseList::findOrFail($id),
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
        $causeList = CauseList::findOrFail($id);

        $attributes = $this->validateCauseList($causeList);

        if (request('normal_file') ?? false)
            $attributes['normal_file'] = basename(request()->file('normal_file')->store('public/cause_lists'));

        if (request('old_file') ?? false)
            $attributes['old_file'] = basename(request()->file('old_file')->store('public/cause_lists'));

        DB::transaction(function () use ($attributes, $causeList) {

            $causeList->update([
                'court_id' => $attributes['court'],
                'date' => $attributes['date']
            ]);

            if (request('normal_file') ?? false)
                $causeList->update([
                    'normal_file' => $attributes['normal_file'],
                ]);

            if (request('old_file') ?? false)
                $causeList->update([
                    'old_file' => $attributes['old_file'],
                ]);

        });

        return back()->with('success', 'Cause List Updated!');
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

    public function validateCauseList(?CauseList $causeList = null): array
    {
        $causeList ??= new CauseList();

        return request()->validate([
            'court' => 'required',
            'date' => ['required', 'date'],
            'normal_file' => $causeList->exists ? ['file'] : ['required', 'file'],
            'old_file' => $causeList->exists ? ['file'] : ['required', 'file']
        ]);
    }


}
