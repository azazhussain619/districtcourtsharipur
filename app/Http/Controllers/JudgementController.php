<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Judgement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JudgementController extends Controller
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
            $data = Judgement::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('court_id', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $row->court->name;
                })
                ->addColumn('file', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="text-center">
                                          <a href="' . asset("storage/judgements/" . $row->file) . '" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-download"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {

//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    $btn = ' <div class="text-center">
                                          <a href="' . url("admin/judgements/" . $row->id . "/edit") . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                          <!--<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>-->
                                      </div>';

                    return $btn;
                })
                ->rawColumns(['action', 'file'])
                ->make(true);
        }

        return view('admin.judgements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.judgements.create', [
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
        $attributes = $this->validateJudgement();

        $attributes['file'] = basename(request()->file('file')->store('public/judgements'));

        DB::transaction(function () use ($attributes) {

            Judgement::create([
                'court_id' => $attributes['court'],
                'case_no' => $attributes['case_no'],
                'case_title' => $attributes['case_title'],
                'date' => $attributes['date'],
                'file' => $attributes['file']
            ]);


        });

        return back()->with('success', 'Judgement Uploaded!');


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
        return view('admin.judgements.edit', [
            'judgement' => Judgement::findOrFail($id),
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
        $judgement = Judgement::findOrFail($id);

        $attributes = $this->validateJudgement($judgement);

        if (request('file'))
            $attributes['file'] = basename(request()->file('file')->store('public/judgements'));

        DB::transaction(function () use ($attributes, $judgement) {

            $judgement->update([
                'court_id' => $attributes['court'],
                'case_no' => $attributes['case_no'],
                'case_title' => $attributes['case_title'],
                'date' => $attributes['date'],
            ]);

            if (request('file'))
                $judgement->update([
                    'file' => $attributes['file']
                ]);


        });

        return back()->with('success', 'Judgement Updated!');
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

    public function validateJudgement(?Judgement $judgement = null): array
    {
        $judgement ??= new Judgement();
        return request()->validate([
            'court' => 'required',
            'case_no' => 'required',
            'case_title' => 'required',
            'date' => 'required',
            'file' => ($judgement->exists ? ['file'] : ['file', 'required'])
        ]);
    }
}
