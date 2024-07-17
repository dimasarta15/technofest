<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Alert;
use App\Http\Requests\Backsite\YearRequest;
use App\Models\Year;
use DataTables;
use Illuminate\Http\Request;
use Log;

class YearController extends Controller
{
    public function index()
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        return view('backsite.year.index');
    }

    public function datatable()
    {
        $data = Year::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backsite.year.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(YearRequest $request)
    {
        try {
            $year = new Year;
            $year->year = $request->year;
            $year->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.year.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route('backsite.year.index')->withSuccess('Success add item !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['item'] = Year::findOrFail($id);

        return view('backsite.year.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(YearRequest $request, $id)
    {
        try {
            $cat = Year::findOrFail($id);
            $cat->year = $request->year;
            $cat->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.year.index')->with('error_msg', 'Failed update item !');
        }

        return redirect()->route('backsite.year.index')->withSuccess('Success update item !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Year::findOrFail($id)->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.year.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route('backsite.year.index')->withSuccess('Success delete item !');
    }
}
