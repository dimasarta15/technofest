<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\UserRequest;
use App\Models\Major;
use App\Models\Role;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ref = request()->query('role');
        $role = Role::whereRef($ref)->firstOrFail();

        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        
        if ($ref == 1 && Auth::user()->role_id == Role::ROLES['moderator'])
            abort(403, 'Anda tidak berhak mengakses halaman ini.');

        $data['role'] = $role;

        return view('backsite.user.index', $data);
    }

    public function datatable(Request $request)
    {
        $role = Role::whereRef($request->ref)->firstOrFail();
        $data = User::where('role_id', $role->id)->where('id', '!=', Auth::id());
        // dd($data->get());
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
        $ref = request()->query('role');
        $role = Role::whereRef($ref)->firstOrFail();
        $data['role'] = $role;

        return view('backsite.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            /*  $user->ref = $request->ref;
            $user->role = $request->role; */
            $role = Role::whereRef($request->role_ref)->firstOrFail();

            $user = new User;
            $user->role_id = $role->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->nrp = $request->nrp;
            $user->college_origin = $request->college_origin;
            $user->telephone = $request->telephone;
            $user->email_verified_at = Carbon::now();
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.user.index', ['?role='.$request->role_ref])->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.user.index', ['?role='.$request->role_ref])->withSuccess('Success add item !');
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

    public function myProfile()
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        $data['user'] = Auth::user();
        $data['majors'] = Major::all();
        $data['isEagle'] = stripos(Auth::user()->college_origin, "STIKI") !== false ? 1 : 0;

        return view('backsite.user.my-profile', $data);
    }

    public function updateProfile(UserRequest $request)
    {
        try {
            $user = User::findOrFail(Auth::id());
            $user->country_id = $request->country;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->has('password'))
                $user->password = bcrypt($request->password);

            if (!empty($request->custom_major)) {
                $user->custom_major = $request->custom_major;
                $user->major_id = null;
            } else {
                $user->custom_major = null;
                $user->major_id = $request->major;
            }
            $user->nrp = $request->nrp;
            $user->college_origin = $request->has('is_eagle') ? "STIKI Malang" : $request->college_origin;
            $user->telephone = $request->telephone;
            $user->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.user.my-profile')->with('error_msg', 'Failed update profile !');
        }

        return redirect()->route(getLang() . 'backsite.user.my-profile')->withSuccess('Success update profile !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ref = request()->query('role');
        $role = Role::whereRef($ref)->firstOrFail();

        $data['item'] = User::findOrFail($id);
        $data['role'] = $role;

        return view('backsite.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $role = Role::whereRef($request->role_ref)->firstOrFail();

            $user = User::findOrFail($id);
            $user->role_id = $role->id;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->has('password'))
                $user->password = bcrypt($request->password);
            $user->nrp = $request->nrp;
            $user->college_origin = $request->college_origin;
            $user->telephone = $request->telephone;
            $user->email_verified_at = Carbon::now();
            $user->save();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.user.index', ['?role=' . $request->role_ref])->with('error_msg', 'Failed update item !');
        }

        return redirect()->route(getLang() . 'backsite.user.index', ['?role=' . $request->role_ref])->withSuccess('Success update item !');
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
            if (Auth::id() == $id)
                throw new \Exception("Error Processing Request", 1);
                
            User::findOrFail($id)->delete();
        } catch (\Exception $e) {
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.user.index', ['?role='. request()->role_ref])->with('error_msg', 'Failed delete item !');
        }

        return redirect()->route(getLang() . 'backsite.user.index', ['?role='. request()->role_ref])->withSuccess('Success delete item !');
    }

    public function select2(Request $request)
    {
        $term = trim($request->term);
        $participant = Role::ref(3)->first()->id;

        $data = User::select('id', DB::raw('concat(nrp,"-", name) as text'))->where('role_id', $participant);
        
        if (!empty($term))
            $data = $data->where('name', 'LIKE',  '%' . $term . '%')->orWhere('nrp', 'LIKE',  '%' . $term . '%');

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
