<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\EventRequest;
use App\Models\Event;
use App\Models\Semester;
use DataTables;
use Illuminate\Http\Request;
use Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        return view('backsite.event.intro');
    }

    public function listEvent($semId)
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));
        
        $data['semester'] = Semester::find($semId);

        return view('backsite.event.index', $data);
    }

    public function datatable(Request $request)
    {
        $lang = $request->query('lang') ?? "en";
        $data = Event::where(['semester_id' => $request->semester_id, 'lang' => $lang]);

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
    public function create($semId)
    {
        $data['semester'] = Semester::find($semId);

        return view('backsite.event.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request, $semId)
    {
        $lang = $request->query('lang') ?? "en";

        try {
            $ev = new Event;
            $ev->semester_id = $semId;
            $ev->title = $request->title;
            if ($request->has('photo')) {
                $ev->photo = str_replace('public/', '', $this->uploadImage($request->file('photo'), 'event'));
            }
            $visible = 1;
            if ($request->visible == 0)
                $visible = 0;
            $ev->visible = $visible;
            $ev->youtube = $request->youtube;
            $ev->lang = $lang;
            $ev->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success add item !');
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
    public function edit($semId, $id)
    {
        $data['semester'] = Semester::find($semId);
        $data['item'] = Event::find($id);

        return view('backsite.event.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $semId, $id)
    {
        $lang = $request->query('lang') ?? "en";

        try {
            $ev = Event::find($id);

            if ($request->has('photo')) {
                $this->removeImage($ev->photo);
                $ev->photo = str_replace('public/', '', $this->uploadImage($request->file('photo'), 'event'));
            }
            $visible = 1;
            if ($request->visible == 0)
                $visible = 0;
            $ev->visible = $visible;
            $ev->youtube = $request->youtube;
            $ev->title = $request->title;
            $ev->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed update item !');
        }

        return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success update item !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semId, $id)
    {
        $lang = request()->query('lang') ?? "en";

        try {
            $ev = Event::findOrFail($id);
            $this->removeImage($ev->photo);
            $ev->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.event.list-event', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success delete item !');
    }
}
