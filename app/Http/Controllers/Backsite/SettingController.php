<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backsite\SettingRequest;
use App\Models\Setting;
use Alert;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function intro()
    {
        return view('backsite.setting.intro');
    }

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

        $data['setting'] = (new Setting);
        return view('backsite.setting.form', $data);
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
    public function store(SettingRequest $request)
    {
        try {
            if (!$request->has('allow_upload')) 
                $request->request->add(['allow_upload' => 0]);
            
            if ($request->has('logo_img')) {
                $logo = Setting::key('logo')->value;
                $this->removeImage($logo);

                $fixLogo = str_replace('public/', '', $this->uploadImage($request->file('logo_img'), 'setting'));
                $request->request->add(['logo' => $fixLogo]);
                $request->request->remove('logo_img');
            }

            if ($request->has('logo_img_home')) {
                $logo = Setting::key('logo_home')->value;
                $this->removeImage($logo);

                $fixLogo = str_replace('public/', '', $this->uploadImage($request->file('logo_img_home'), 'setting'));
                $request->request->add(['logo_home' => $fixLogo]);
                $request->request->remove('logo_img_home');
            }

            foreach ($request->except(['_token', 'logo_img', 'logo_img_home']) as $key => $value) {
                $fixVal = trim($value);
                
                if ($key == 'custom_css') {
                    $fixVal = htmlspecialchars_decode(strip_tags($fixVal));
                }

                Setting::updateorCreate([
                    'key' => $key
                ],['value' => $fixVal]);
            }

        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());

            Log::error('error : '. $e->getMessage());
            return redirect()->route('backsite.setting.index')->with('error_msg', 'Failed update item !');
        }

        return redirect()->route('backsite.setting.index')->withSuccess('Success update item !');
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
