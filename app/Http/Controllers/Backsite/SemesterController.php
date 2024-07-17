<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use DataTables;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\SemesterRequest;
use App\Models\Semester;
use App\Models\Role;
use App\Traits\AjaxTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SemesterController extends Controller
{
    use AjaxTrait;

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

        return view('backsite.semester.index');
    }

    public function datatable()
    {
        $data = Semester::orderBy('status', 'desc')->orderBy('position', 'asc');
        
        if (Auth::user()->role_id == Role::ROLES['participant'])  {
            $data = $data->where('status', 1);
        }

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
        return view('backsite.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterRequest $request)
    {
        try {
            $semester = new Semester;
            $semester->semester = $request->semester;
            $semester->title = $request->title;
            $semester->position = $request->position;
            $semester->status = 0;
            
            $visible = 1;
            if ($request->visible == 0)
                $visible = 0;
            $semester->visible = $visible;
            $semester->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            return redirect()->route(getLang().'backsite.semester.index')->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang().'backsite.semester.index')->withSuccess('Success add item !');
    }

    public function updateStatus($id)
    {
        try {
            Semester::where('id', '>', 0)->update(['status' => 0]);

            $semester = Semester::find($id);
            $semester->status = $semester->status == 1 ? 0 : 1;
            $semester->save();
            
            $this->status = true;
            $this->code = \Illuminate\Http\Response::HTTP_OK;
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            $this->status = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->json();
    }

    public function updatePosition(Request $request, $id)
    {
        try {
            $semester = Semester::find($id);
            $semester->position = $request->position;
            $semester->save();
            
            $this->status = true;
            $this->code = \Illuminate\Http\Response::HTTP_OK;
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            $this->status = false;
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->json();
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
        $data['item'] = Semester::findOrFail($id);

        return view('backsite.semester.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SemesterRequest $request, $id)
    {
        try {
            $semester = Semester::findOrFail($id);
            $semester->semester = $request->semester;
            $semester->title = $request->title;
            $semester->position = $request->position;
            $visible = 1;
            if ($request->visible == 0)
                $visible = 0;
            $semester->visible = $visible;
            $semester->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang().'backsite.semester.index')->with('error_msg', 'Failed update item !');
        }

        return redirect()->route(getLang().'backsite.semester.index')->withSuccess('Success update item !');
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
            Semester::findOrFail($id)->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang().'backsite.semester.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang().'backsite.semester.index')->withSuccess('Success delete item !');
    }
}
