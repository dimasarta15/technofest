<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BackupController extends Controller
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

        $dirName = str_replace(' ', '-', env('APP_NAME', 'laravel-backup'));
        $backups = Storage::disk('public')->allFiles($dirName);
        $data['backups'] = $backups;
        // foreach ($backups as $key => $bk) {
        //     $bk = st
        // }
        return view('backsite.backup.index', $data);
    }

    public function run()
    {
        try {
            Artisan::call("backup:run --only-db --disable-notifications");
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            return redirect()->route(getLang() . 'backsite.backup.index')->with('error_msg', 'Failed backup DB !');
        }

        return redirect()->route(getLang() . 'backsite.backup.index')->withSuccess('Success backup DB !');
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
    public function destroy($file)
    {
        try {
            $dirName = str_replace(' ', '-', env('APP_NAME', 'laravel-backup'));

            if (Storage::disk('public')->exists("$dirName/$file")) {
                Storage::disk('public')->delete("$dirName/$file");
            }
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());

            return redirect()->route(getLang() . 'backsite.backup.index')->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.backup.index')->withSuccess('Success delete item !');
    }
}
