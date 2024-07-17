<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeSemester = Semester::active()->first();

        $speakers = Speaker::all();
        $agendas = Agenda::with('speaker')
            ->whereSemesterId($activeSemester->id)
            // ->whereLang(clearDot(getLang()))
            ->orderBy('event_date', 'asc')
            ->get();

        $projects = Project::active()->approved()->with(['category', 'thumb'])
            ->whereSemesterId($activeSemester->id)
            ->whereLang(clearDot(getLang()))
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        
        $projectCount = Project::whereSemesterId($activeSemester->id)
            ->whereLang(clearDot(getLang()))
            ->active()
            ->approved()
            ->count();
                
        $participant = DB::select('
            select pu.user_id uid from projects p
            join project_users pu on pu.project_id = p.id
            where semester_id = '.$activeSemester->id.' 
            group by uid'
        );

        $data['speakers'] = $speakers;
        $data['agendas'] = $agendas;
        $data['projects'] = $projects;
        $data['participantCount'] = count($participant);
        $data['projectsCount'] = $projectCount;
        $data['semesters'] = Semester::where('visible', 1)->orderBy('position', 'desc')->take(6)->get();

        return view('frontsite.home.index', $data);
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
    public function destroy($id)
    {
        //
    }
}
