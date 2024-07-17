<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\SpeakerRequest;
use App\Models\Speaker;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SpeakerController extends Controller
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

        return view('backsite.speaker.index');
    }

    public function datatable(Request $request)
    {
        $data = Speaker::query();

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
        return view('backsite.speaker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpeakerRequest $request)
    {
        try {
            $sp = new Speaker;
            $sp->image = str_replace('public/', '', $this->uploadImage($request->file('photo'), 'speakers'));
            $sp->name = $request->speaker_name;
            $sp->position = $request->position;
            $sp->desc = $request->desc;
            $sp->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.speaker.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.speaker.index')->withSuccess('Success add item !');
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
        $data['item'] = Speaker::findOrFail($id);

        return view('backsite.speaker.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpeakerRequest $request, $id)
    {
        try {
            $sp = Speaker::find($id);

            if ($request->has('photo')) {
                $this->removeImage($sp->image);
                $sp->image = str_replace('public/', '', $this->uploadImage($request->file('photo'), 'speakers'));
            }
            $sp->name = $request->speaker_name;
            $sp->position = $request->position;
            $sp->desc = $request->desc;
            $sp->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.speaker.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.speaker.index')->withSuccess('Success add item !');
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
            $sp = Speaker::findOrFail($id);
            $this->removeImage($sp->image);
            $sp->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.speaker.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.speaker.index')->withSuccess('Success delete item !');
    }
}
