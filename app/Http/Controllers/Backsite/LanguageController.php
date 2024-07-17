<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Fragment;
use App\Traits\AjaxTrait;
use DataTables;
use Illuminate\Http\Request;

class LanguageController extends Controller
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

        return view('backsite.language.index');
    }

    public function datatable(Request $request)
    {
        $lang = $request->lang ?? 'en';
        $data = Fragment::whereLang($lang);

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $frag = Fragment::findOrFail($id);
    
            $this->success = true;
            $this->data = $frag;
            $this->code = 200;

        } catch (\Exception $e) {
            $this->success = false;
            $this->code = 500;
        }

        return $this->json();
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
        try {

            $frag = Fragment::findOrFail($id);
            $frag->setTranslation('text', $request->lang, $request->value);
            $frag->save();
    
            $this->success = true;
            $this->data = $frag;
            $this->code = 200;

        } catch (\Exception $e) {
            $this->success = false;
            $this->code = 500;
        }

        return $this->json();
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
