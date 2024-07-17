<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Lecture;
use DataTables;
use Illuminate\Http\Request;
use Log;

class LectureController extends Controller
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

        return view('backsite.lecture.index');
    }

    public function datatable(Request $request)
    {
        $data = Lecture::query();

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
        return view('backsite.lecture.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $lec = new Lecture;
            $lec->name = $request->name;
            $lec->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.lecture.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.lecture.index')->withSuccess('Success add item !');
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
        $data['item'] = Lecture::findOrFail($id);

        return view('backsite.lecture.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $lec = Lecture::findOrFail($id);
            $lec->name = $request->name;
            $lec->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.lecture.index')->with('error_msg', 'Failed update item !');
        }

        return redirect()->route(getLang() . 'backsite.lecture.index')->withSuccess('Success update item !');
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
            Lecture::findOrFail($id)->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.lecture.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.lecture.index')->withSuccess('Success delete item !');
    }

    public function select2(Request $request)
    {
        $term = trim($request->term);

        $data = Lecture::select('id', 'name as text');
        
        if (!empty($term))
            $data = $data->where('name', 'LIKE',  '%' . $term . '%');

        $data = $data->simplePaginate(25);

        $morePages = true;
        $pagination_obj = json_encode($data);
        if (empty($data->nextPageUrl())) {
            $morePages = false;
        }
        $results = array(
            "results" => $data->items(),
            "pagination" => array(
                "more" => $morePages
            )
        );

        return \Response::json($results);
    }
}
