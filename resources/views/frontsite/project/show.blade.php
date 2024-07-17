@extends('layouts.frontsite-layout')

@section('style')
    <script src="https://kit.fontawesome.com/767f1baa4a.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<!--Page Title-->
<section class="page-title" style="background-color: #232323">
    <div class="auto-container">
        <h1>{{ str_limit($project->title, 45) }}</h1>
        <!-- <ul class="bread-crumb clearfix">
            <li><a href="/">Home</a></li>
            <li><a href="{{ route(getLang() .'frontsite.project.index') }}">Project</a></li>
            <li>{{ str_limit($project->title, 45) }}</li>
        </ul> -->
    </div>
</section>
<!--End Page Title-->

<!--Sidebar Page Container-->
<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">

            <!--Content Side / Blog Sidebar-->
            <div class="content-side col-lg-8 col-md-12 col-sm-12">
                <div class="blog-single">
                    <!-- News Block Three -->
                    <div class="news-block">
                        <div class="inner-box">
                            <div class="lower-content" style="margin-top:-20px;">
                                <!-- <h2>{{ $project->title }}</h2> -->
                                {!! $project->desc !!}
                            </div>
                            <div class="image-box" style="margin-top:25px;">
                                <div id="myCarousel" class="carousel slide shadow">
                                    <!-- main slider carousel items -->
                                    <div class="carousel-inner">
                                        @forelse ($project->images as $key => $img)
                                            <div class="{{ $key == 0 ? 'active' : '' }} carousel-item" data-slide-number="{{ $key }}">
                                                @if (env('RESOURCES_PROJECT') == 'ONLINE')
                                                    <img src="https://technofest.stiki.ac.id/{{ str_replace('project', 'berkas/karya/', $img->ori_image) }}" class="img-fluid">
                                                @else
                                                    <img src="/storage/{{ $img->ori_image }}" class="img-fluid">
                                                @endif
                                                
                                            </div>

                                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                            @empty
                                            Poster Karya Kosong
                                        @endforelse
                                    </div>
                                    <!-- main slider carousel nav controls -->


                                    <ul class="carousel-indicators list-inline mx-auto border px-2">
                                        @forelse ($project->images as $key => $img)
                                        <li class="list-inline-item {{ $key == 0 ? 'active' : '' }}">
                                            <a id="carousel-selector-{{ $key }}" class="selected" data-slide-to="{{ $key }}" data-target="#myCarousel">
                                                @if (env('RESOURCES_PROJECT') == 'ONLINE')
                                                    <img src="https://technofest.stiki.ac.id/{{ str_replace('project', 'berkas/karya/', $project->thumb->small_image) }}" class="img-fluid" width="100px">
                                                @else
                                                    <img src="/storage/{{ $img->small_image }}" class="img-fluid" width="100px">
                                                @endif
                                            </a>
                                        </li>
                                        @empty
                                            Poster Karya Kosong
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Options -->
                    <div class="post-share-options clearfix">
                        <!-- <div class="pull-left">
                                <ul class="tags">
                                    <li><a href="#">Eventa</a></li>
                                    <li><a href="#">Conference</a></li>
                                    <li><a href="#">Business</a></li>
                                </ul>
                            </div> -->

                        <div class="social-icon-three pull-right">
                            <ul class="social-icon-three">
                                <li><a href="http://www.facebook.com/sharer.php?m2w&s=100&p[url]={{ url()->current() }}&&p[title]={{ $project->title }}"><span class="fab fa-facebook-f"></span></a></li>
                                <li><a href="https://twitter.com/share?text={{ $project->title }};url={{ url()->current() }}"><span class="fab fa-twitter"></span></a></li>
                                <li><a href="http://pinterest.com/pin/create/button/?url={{ url()->current() }};description={{ $project->desc }};media={{ $project->title }}"><span class="fab fa-pinterest"></span></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!--Sidebar Side-->
            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                <aside class="sidebar padding-left">

                    <!-- Search -->
                    <!-- <div class="sidebar-widget search-box">
                        <form method="GET" action="{{ route(getLang() .'frontsite.project.index') }}">
                            <div class="form-group">
                                <input type="text" name="search" value="" placeholder="Search..." required>
                                <button type="submit"><span class="icon fa fa-search"></span></button>
                            </div>
                        </form>
                    </div> -->

                    <!-- Category Widget -->
                    <div class="sidebar-widget categories">
                        <h4 class="sidebar-title2">@trans('frontsite.project.type')</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                <li><a>{{ ucfirst($project->type) }}</a></li>
                            </ul>
                        </div>
                        @if ($project->type == 'copyright')
                            <h4 class="sidebar-title2">@trans('frontsite.project.copyright_id')</h4>
                            <div class="widget-content">
                                <!-- Blog Category -->
                                <ul class="blog-categories2">
                                    <li><a>{{ ucfirst($project->copyright_id) }}</a></li>
                                </ul>
                            </div>
                        @endif
                        <h4 class="sidebar-title2">Author</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                @foreach($project->projectUsers as $author)
                                    <li><a href="{{ route(getLang() .'frontsite.user.index', $author->email) }}">{{ $author->name }} ({{ $author->nrp }})</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <h4 class="sidebar-title2">Links</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                @if (!empty($project->demo_link))
                                    <li><a href="{{ $project->demo_link }}" target="_blank"><i class="fa-solid fa-laptop-code"></i> Demo</a></li>
                                @endif
                                @if (!empty($project->github_link))
                                    <li><a href="{{ $project->github_link }}" target="_blank"><i class="fa-brands fa-github"></i> Source Code</a></li>
                                @endif
                                @if (!empty($project->video_link))
                                    <li><a href="{{ $project->video_link }}" target="_blank"><i class="fa-solid fa-video"></i> Video</a></li>
                                @endif
                            </ul>
                        </div>
                        <h4 class="sidebar-title2">Supervisor</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                @if (!$project->projectSupervisors->isEmpty())
                                    @forelse ($project->projectSupervisors as $sp)
                                        <li><a>{{ $loop->iteration.'. '.$sp->supervisor }}</a></li>
                                    @empty
                                    @endforelse
                                @else
                                    <li><a>{{ $project->lecture->name ?? "-" }}</a></li>
                                @endif
                            </ul>
                        </div>

                        <h4 class="sidebar-title2">Production Year</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                <li><a>{{ explode(' ', explode('/', $project->created_at)[2])[0] }}</a></li>
                            </ul>
                        </div>

                        <h4 class="sidebar-title2">College / University</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                <li><a>{{ $project->user->college_origin }}</a></li>
                            </ul>
                        </div>

                        <h4 class="sidebar-title2">Major</h4>
                        <div class="widget-content">
                            <!-- Blog Category -->
                            <ul class="blog-categories2">
                                <li><a>{{ $project->user->major->name ?? $project->user->custom_major }}</a></li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Sidebar Page Container -->
@endsection