<?php

namespace App\Http\Controllers\Backsite;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\ProjectRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectExport;
use App\Traits\AjaxTrait;

use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Log;
use Storage;

use App\Models\Category;
use App\Models\Image;
use App\Models\Major;
use App\Models\Project;
use App\Models\ProjectSupervisor;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Models\Semester;
use App\Models\Year;
use Carbon\Carbon;

class ProjectController extends Controller
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

        \Session::forget('dz-sess');
        return view('backsite.project.intro');
    }

    public function datatable(Request $request)
    {
        $semId = $request->semester_id;
        $lang = $request->lang ?? "en";

        $data = Project::with([
            'category',
            'user.major',
            'projectUsers',
            'projectSupervisors',
            'major',
            'lecture'
        ])
        ->whereSemesterId($semId)
        ->whereLang($lang);

        if (Auth::user()->role_id == Role::ROLES['participant'])  {
            $data = $data->whereRelation('projectUsers', 'user_id', '=', Auth::id());
        }
        
        if ($request->has('category')) {
            if ($request->category != "")
                $data = $data->where('category_id', $request->category);
        }

        if ($request->has('status'))
            if ($request->status != "")
                $data = $data->where('status', $request->status);

        $data = $data->orderBy('id', 'desc');
        // dd($data->get()->toArray());
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listProject($semId)
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));
        
        \Session::forget('dz-sess');
        // $data['semId']  = $semId;
        $data['semester'] = Semester::find($semId);
        $data['categories'] = Category::all();

        return view('backsite.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($semId)
    {
        $this->authorize('access-upload');
        
        $data['categories'] = Category::all();
        $data['majors'] = Major::all();
        if (empty(\Session::get('dz-sess')))
            \Session::put('dz-sess', \Str::random(32));
        $data['semesterId'] = $semId;
        
        return view('backsite.project.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request, $semId)
    {
        // dd($request->all());
        $this->authorize('access-upload');
        $lang = $request->query('lang') ?? "en";

        if (empty(\Session::get('dz-sess')))
            \Session::put('dz-sess', \Str::random(32));
        
        DB::beginTransaction();
        try {

            $project = new Project;
            $project->category_id = $request->category;
            $project->semester_id = $semId;

            // if ($request->major != 'other')
            //     $project->major_id = $request->major;

            if (Auth::user()->role_id != Role::ROLES['participant']) {
                $project->user_id = $request->members[0] ?? \Auth::id();
                $project->status = $request->status;
                $project->approved_at = Carbon::now()->format('Y-m-d H:i:s');
            } else {
                $project->user_id = \Auth::id();
                $request->request->add(['members' => array_merge( [(string)Auth::id()], $request->members ?? [] )]);
                $project->status = null;
            }

            $project->type = $request->project_type;
            if (!empty($request->copyright_id)) {
                $project->copyright_id = $request->copyright_id;
            }

            // if (!empty($request->custom_major)) {
            //     $project->custom_major = $request->custom_major;
            // }
            
            $project->title = $request->title;
            $project->desc = $request->desc; 
            // $project->lecture_id = $request->lecture;
            $project->github_link = $request->github_link;
            $project->demo_link = $request->demo_link;
            $project->lang = $lang;
            $project->video_link = $request->video_link;
            $project->save();

            $project->projectUsers()->sync($request->members);

            foreach ($request->lecture as $key => $lect)
                $project->projectSupervisors()->create(['supervisor' => $lect]);

            Image::where('sid', \Session::get('dz-sess'))->update([
                'project_id' => $project->id,
            ]);
            Image::whereId($request->thumbnail)->update(['is_thumbnail' => 1]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success add item !');
    }

    public function storeImage(ProjectRequest $request)
    {
        if ($fileUid = $this->uploadImage($request->file('file'), 'project')) {
            $cols = [
                'sid' => $request->sid ?? \Session::get('dz-sess'),
                'ori_image' => str_replace('public/', '', $fileUid),
                'small_image' => str_replace('public/', '', str_replace("project/", 'project/small_', $fileUid)),
            ];

            if (!empty($request->parent_id)) 
                $cols['project_id'] = $request->parent_id;
            $cols['id'] = Image::insertGetId($cols);

            return $cols;
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($semId, $id)
    {
        $project = Project::with(['images', 'projectUsers', 'lecture'])->whereId($id)->firstOrFail();
        $data['categories'] = Category::all();
        $data['majors'] = Major::all();
        if (empty(\Session::get('dz-sess')))
            \Session::put('dz-sess', \Str::random(32));
        $data['project'] = $project;
        $data['yearId'] = $semId;
        $data['semesterId'] = $semId;

        $supervisors = ProjectSupervisor::where('project_id', $project->id)->get();
        $arrSupervisors = [];
        foreach ($supervisors as $key => $value) {
            $arrSupervisors[] = $value['supervisor'];
        }
        $data['projectSupervisor'] = json_encode($arrSupervisors);

        $thumb = "";
        if ($project->images->count() <= 0) {
            \Session::put('dz-sess', \Str::random(32));
            $data['dzSess'] = \Session::get('dz-sess');
        } else {
            $thumb = $project->images->first()->ori_image;
        }
        $data['thumb'] = $thumb;

        return view('backsite.project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($semId, $id)
    {
        $this->authorize('validate-project', $id);

        $project = Project::with(['images', 'projectUsers', 'lecture'])->whereId($id)->firstOrFail();
        $data['categories'] = Category::all();
        $data['majors'] = Major::all();
        if (empty(\Session::get('dz-sess')))
            \Session::put('dz-sess', \Str::random(32));
        $data['project'] = $project;
        $data['semesterId'] = $semId;

        $thumb = "";
        if ($project->images->count() <= 0) {
            \Session::put('dz-sess', \Str::random(32));
            $data['dzSess'] = \Session::get('dz-sess');
        } else {
            $thumb = $project->images->where('is_thumbnail', 1)->first()->ori_image ?? $project->images->first()->small_image;
        }

        $supervisors = ProjectSupervisor::where('project_id', $project->id)->get();
        $arrSupervisors = [];
        foreach ($supervisors as $key => $value) {
            $arrSupervisors[] = $value['supervisor'];
        }
        $data['projectSupervisor'] = json_encode($arrSupervisors);
        $data['thumb'] = $thumb;

        return view('backsite.project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $semId, $id)
    {
        // dd($request->all());
        $this->authorize('validate-project', $id);
        $lang = $request->query('lang') ?? "en";

        DB::beginTransaction();
        try {
            $project = Project::find($id);
            $project->category_id = $request->category;
            $project->semester_id = $semId;
            $project->title = $request->title;

            /* if ($request->major != 'other') {
                $project->major_id = $request->major;
                $project->custom_major = null;
            } else {
                $project->major_id = null;
                $project->custom_major = $request->major;
            } */
            
            if (Auth::user()->role_id != Role::ROLES['participant']) {
                $project->user_id = $request->members[0] ?? \Auth::id();
                $project->status = $request->status;
            } else {
                $project->user_id = \Auth::id();
            }

            $project->type = $request->project_type;
            if (!empty($request->copyright_id)) {
                $project->copyright_id = $request->copyright_id;
            }

            if (!empty($request->custom_major)) {
                $project->custom_major = $request->custom_major;
            }

            $project->desc = $request->desc; 
            // $project->lecture_id = $request->lecture;
            $project->github_link = $request->github_link;
            $project->demo_link = $request->demo_link;
            $project->video_link = $request->video_link;
            $project->save();
            $project->projectUsers()->sync($request->members);

            if (!empty(\Session::get('dz-sess'))) {
                Image::where('sid', \Session::get('dz-sess'))->update([
                    'project_id' => $project->id,
                ]);
                Image::whereProjectId($id)->update(['is_thumbnail' => '0']);
                Image::whereId($request->thumbnail)->update(['is_thumbnail' => '1']);
            }

            ProjectSupervisor::where('project_id', $project->id)->delete();
            foreach ($request->lecture as $key => $lect)
                $project->projectSupervisors()->create(['supervisor' => $lect]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success add item !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semId, $id)
    {
        $this->authorize('validate-project', $id);
        $lang = request()->query('lang') ?? "en";

        DB::beginTransaction();
        try {
            $project = Project::find($id);
            ProjectUser::whereProjectId($id)->delete();
            Image::whereProjectId($id)->delete();
            $project->delete();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_ENV') != 'production')
                dd($e->getMessage());
            Log::error('error : '. $e->getMessage());
            return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->with('error_msg', 'Failed add item !');
        }

        return redirect()->route(getLang() . 'backsite.project.list-project', ['semester' => $semId, 'lang' => $lang])->withSuccess('Success add item !');
    }

    public function updateStatus(ProjectRequest $request)
    {
        $this->authorize('cannot-update-status', $request->id);

        try {
            $project = Project::find($request->id);
            // $project->status = $project->status == 1 ? 0 : 1;
            
            if (empty($project->approved_at))
                $project->approved_at = Carbon::now()->format('Y-m-d H:i:s');
            
            if (is_null($request->status)) {
                $project->approved_at = null;
                $project->status = null;
            } else {
                $project->status = $request->status;
            }
                
            $project->save();
            $this->code = \Illuminate\Http\Response::HTTP_OK;
            $this->success = true;
            $data = 'Status updated !';
        } catch (\Exception $e) {
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->success = false;
            $data = $e->getMessage();
        }

        $this->data = $data;
        return $this->json();
    }

    public function destroyImage($id)
    {
        try {
            $data = Image::find($id);
            if (Storage::disk('public')->exists($data->ori_image))
                Storage::disk('public')->delete($data->ori_image);

            if (Storage::disk('public')->exists($data->small_image)) 
                Storage::disk('public')->delete($data->small_image);

            $data = $data->delete();
        } catch (\Exception $e) {
            $this->code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
            $data = $e->getMessage();
        }

        $this->data = $data;
        return $this->json();
    }

    public function exportExcel()
    {
        $semester = request()->semester;
        $status = request()->status;

        $text = [
            0 => 'NON_AKTIF',
            1 => 'AKTIF',
        ];
        $res = $text[$status] ?? $text[1];
        $fname =  time().'_DATA_KARYA_'.$res.'.xlsx';

        return Excel::download(new ProjectExport($status, $semester, $res), $fname);
    }
}
