<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Speaker;
use App\Models\Project;
use App\Models\Role;
use App\Models\Semester;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectActiveTotal = Project::status(1);
        $projectNonActiveTotal = Project::status(0);
        $speakerTotal = Speaker::count();
        $agendaActiveTotal = Agenda::count();
        $semesterActive = Semester::active()->first()->id ?? 1;

        if (Auth::user()->role_id == Role::ROLES['participant']) {
            $projectActiveTotal = $projectActiveTotal
                ->with('projectUsers')
                ->where('semester_id', $semesterActive)
                ->whereRelation('projectUsers', 'user_id', '=', Auth::id());

            $projectNonActiveTotal = $projectNonActiveTotal
                ->with('projectUsers')
                ->where('semester_id', $semesterActive)
                ->whereRelation('projectUsers', 'user_id', '=', Auth::id());
        }


        $data['projectActiveTotal'] = $projectActiveTotal->count();
        $data['projectNonActiveTotal'] = $projectNonActiveTotal->count();
        $data['speakerTotal'] = $speakerTotal;
        $data['agendaActiveTotal'] = $agendaActiveTotal;

        if (Auth::user()->role_id != Role::ROLES['participant']) {
            $semesters = Semester::orderBy('position', 'desc')
                ->take(5)
                ->join('projects', 'semesters.id', '=', 'projects.semester_id')
                ->select('semesters.*', DB::raw('count(*) as total_project'))
                ->groupBy('semesters.id')
                ->get();
            $data['semesters'] = $semesters;
        }

        return view('backsite.dashboard', $data);
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
