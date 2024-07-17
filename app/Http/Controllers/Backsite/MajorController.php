<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\MajorRequest;
use App\Models\Major;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        return view('backsite.major.index');
    }

    public function datatable(Request $request)
    {
        $data = Major::query();

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
        return view('backsite.major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorRequest $request)
    {
        try {
            $major = new Major;
            $major->name = $request->major;
            $major->desc = $request->desc;
            $major->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.major.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.major.index')->withSuccess('Success add item !');
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
        $data['item'] = Major::findOrFail($id);

        return view('backsite.major.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MajorRequest $request, $id)
    {
        try {
            $major = Major::findOrFail($id);
            $major->name = $request->major;
            $major->desc = $request->desc;
            $major->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.major.index')->with('error_msg', 'Failed update item !');
        }

        return redirect()->route(getLang() . 'backsite.major.index')->withSuccess('Success update item !');
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
            Major::findOrFail($id)->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.major.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.major.index')->withSuccess('Success delete item !');
    }
}
