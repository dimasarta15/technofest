<?php

namespace App\Http\Controllers\Frontsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontsite\QuizionerRequest;
use App\Models\FormCustom;
use App\Models\FormResponse;
use App\Models\Semester;
use DB;
use Illuminate\Http\Request;
use Log;

class QuizionerController extends Controller
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

        $activeSemester = Semester::active()->first();
        $fc = FormCustom::where('semester_id', $activeSemester->id)->orderBy('seq', 'asc')->get();
        $data['forms'] = $fc;

        return view('frontsite.quizioner.form', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizionerRequest $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->except('_token', 'submit-form', 'g-recaptcha-response') as $key => $v) {
                $fc = FormCustom::whereName($key)->firstOrFail();
                
                if ($fc->type == 'checkbox')
                    $v = json_encode($v);
                $fr = new FormResponse;
                $fr->form_custom_id = $fc->id;
                $fr->value = $v;
                $fr->save();
            }

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route('frontsite.quizioner.index')->with('error_msg', 'Maaf, Sistem Terjadi Kesalahan !');
        }

        return redirect()->route('frontsite.quizioner.index')->withSuccess('Terima kasih, sudah bersedia mengisi kuesioner !');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
