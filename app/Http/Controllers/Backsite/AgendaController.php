<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\AgendaRequest;
use App\Models\Agenda;
use App\Models\Semester;
use App\Models\Speaker;
use App\Models\Year;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Log;

class AgendaController extends Controller
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

        return view('backsite.agenda.intro');
    }

    public function listAgenda($semId)
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));
        
        \Session::forget('dz-sess');
        // $data['semId']  = $semId;
        $data['semester'] = Semester::find($semId);
        // $data['categories'] = Category::all();

        return view('backsite.agenda.index', $data);
    }

    public function datatable(Request $request)
    {
        $data = Agenda::with('speaker');
        if ($request->has('semester_id'))
            $data = $data->whereSemesterId($request->semester_id);

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
        // $data['semesters'] = Semester::all();
        $data['speakers'] = Speaker::all();
        $data['semesterId'] = $semId;

        return view('backsite.agenda.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgendaRequest $request, $semId)
    {
        try {
            $agenda = new Agenda;
            $agenda->title = $request->title;
            $agenda->semester_id = $semId;
            $agenda->speaker_id = $request->speaker;
            $agenda->poster = str_replace('public/', '', $this->uploadImage($request->file('poster'), 'agenda'));
            $agenda->event_date = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');
            $agenda->status = $request->status;
            $agenda->save();
        } catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->withSuccess('Success add item !');
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
        $data['item'] = Agenda::findOrFail($id);
        $data['semesterId'] = $semId;
        $data['speakers'] = Speaker::all();

        return view('backsite.agenda.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgendaRequest $request, $semId, $id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            $agenda->title = $request->title;
            $agenda->semester_id = $semId;
            $agenda->speaker_id = $request->speaker;
    
            if ($request->has('poster')) {
                $this->removeImage($agenda->poster);
                $agenda->poster = str_replace('public/', '', $this->uploadImage($request->file('poster'), 'agenda'));
            }
            
            $agenda->event_date = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');
            $agenda->status = $request->status;
            $agenda->save();
        } catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->withSuccess('Success add item !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semId, $id)
    {
        try {
            $agenda = Agenda::findOrFail($id);
            $this->removeImage($agenda->poster);
            $agenda->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.agenda.list-agenda', $semId)->withSuccess('Success delete item !');
    }
}
