<?php

namespace App\Http\Controllers\Frontsite;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activeSemester = Semester::active()->first();
        $semesterId = $activeSemester->id;

        $projects = Project::with(['category', 'thumb'])
            ->whereLang(clearDot(getLang()))
            ->active()->approved();
            
        if ($request->has('search'))
            $projects = $projects->where('title', 'LIKE', "%$request->search%");
        if ($request->has('semester_id'))
            $semesterId = $request->semester_id;
            
        $projects = $projects->whereSemesterId($semesterId)
            ->orderBy('id', 'desc')
            ->paginate(6);
        $projects->appends(request()->query());
        /* $html = '';
        if ($request->ajax()) {
            foreach ($projects as $project) {
                $thumb = $project->thumb->small_image;
                $category = $project->category->name;
                $title = $project->title;

                $html .=<<<CARD
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><a href="blog-single.html"><img src="/storage/$thumb" alt=""></a></figure>
                            </div>
                            <div class="lower-content">
                                <ul class="post-info">
                                    <!-- <li><span class="far fa-user"></span> Admin</li> -->
                                    <li><span class="far fa-clipboard"></span>$category</li>
                                </ul>
                                <h4><a href="">$title</a></h4>
                                <div class="btn-box"><a href="#" class="read-more">Selengkapnya</a></div>
                            </div>
                        </div>
                    </div>
                CARD;
            }
            return $html;
        } */

        $data['projects'] = $projects;
        return view('frontsite.project.index', $data);
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
        $project = Project::with(['lecture', 'images', 'projectUsers', 'projectSupervisors', 'user'])
            ->whereId($id)
            ->whereStatus(1)
            ->firstOrFail();
        // dd($project->toArray());
        $data['project'] = $project;

        return view('frontsite.project.show', $data);
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
