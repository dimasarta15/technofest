@extends('layouts.frontsite-layout')

@section('content')
	<!-- Banner Conference Two -->
    <section class="banner-conference-two" style="background-image: url(/frontsite-assets/images/bg.jpg);background-repeat: no-repeat;background-position: center center;">
    @php
    $length = 0;
    if (!empty(setting('event_start')->value)) {
        $now = \Carbon\Carbon::now();
        $end = \Carbon\Carbon::parse(\Carbon\Carbon::createFromFormat('d/m/Y', setting('event_start')->value)->format('Y-m-d H:i:s'));
        // $length = $end->diff($now);
        
    }
    @endphp
        <div class="auto-container">
            <div class="content-box">
                <span class="title">{{ setting('event_start')->value }} - {{ setting('event_end')->value }}</span>
                <h2>{{ setting('title')->value }}</h2>
                @if ($now->lessThanOrEqualTo($end))
                    @if(setting('event_start')->value ?? null)
                    <div class="time-counter"><div class="time-countdown clearfix" data-countdown="{{ \Carbon\Carbon::createFromFormat('d/m/Y', setting('event_start')->value)->format('m/d/Y') }}"></div></div>
                    @endif
                @else
                    <div class="time-counter">
                        <a href="{{ route('frontsite.project.index') }}" class="theme-btn btn-style-one btn-lg"><span class="btn-title">@trans('frontsite.seeworks')</span></a>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!--End Banner Conference Two -->

	<!-- About Section -->
    <section class="about-section-two" id="about">
        <div class="anim-icons full-width">
            <span class="icon icon-circle-blue wow fadeIn"></span>
            <span class="icon icon-dots wow fadeInleft"></span>
            <span class="icon icon-circle-1 wow zoomIn"></span>
        </div>
        <div class="auto-container">
            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="title">@trans('frontsite.about')</span>
                            <h2>@trans('frontsite.welcome') <br>{{ setting('title')->value }}</h2>
                            @if(str_replace('.', '', getLang()) == 'id')
                                <div class="text">{{ strip_tags(setting('about')->value) }}</div>
                            @else
                                <div class="text">{{ strip_tags(setting('about_en')->value) }}</div>
                            @endif
                            <br/>
                        </div>
                        <div class="row">
                            <div class="counter-column col-lg-4 col-md-4 col-sm-12 wow fadeInUp">
                                <div class="count-box">
                                    <span class="count-text" data-speed="3000" data-stop="{{ $participantCount }}">0</span>
                                    <h6 class="counter-title">@trans('frontsite.participant')</h6>
                                </div>
                            </div>
        
                            <!--Column-->
                            <div class="counter-column col-lg-4 col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
                                <div class="count-box">
                                    <span class="count-text" data-speed="3000" data-stop="{{ $projectsCount }}">0</span>
                                    <h6 class="counter-title">@trans('frontsite.project')</h6>
                                </div>
                            </div>
        
                            <!--Column-->
                            <div class="counter-column col-lg-4 col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
                                <div class="count-box">
                                    <span class="count-text" data-speed="3000" data-stop="{{ count($agendas) }}">0</span>
                                    <h6 class="counter-title">@trans('frontsite.agenda')</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="image-box">
                        <img src="{{ empty(setting('logo_home')->value) ? "/frontsite-assets/images/logo.png" : '/storage/'.setting('logo_home')->value }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End About Section -->

    <!-- Arsip Section -->
    <section class="pricing-section-three" id="sect-arsip" style="background-color: #fafafa;">
        <div class="anim-icons">
            <span class="icon icon-line-1 wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;"></span>
            <span class="icon icon-circle-1 wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;"></span>
            <span class="icon icon-dots wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;"></span>
        </div>

        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="title">@trans('frontsite.archiveprojects')</span>
                <h2>@trans('frontsite.archiveprojects')</h2>
            </div>

            <div class="outer-box">
                <div class="row">
                    <!-- Unduhan Block -->
                    @foreach ($semesters as $semester)
                        <div class="pricing-block-three col-lg-4 col-md-6 col-sm-12 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="inner-box">
                                <div class="title">
                                    <strong>{{ $semester->title }}</strong>
                                </div>
                                <p class="features">
                                    {{ $semester->semester }}
                                </p>
                                <div class="btn-box">
                                    <a href="{{ route('frontsite.project.index', ['semester_id' => $semester->id]) }}" class="theme-btn btn-style-one" target="_blank"><span class="btn-title">LIHAT</span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End Arsip Section -->

    <!-- Speakers Section -->
    <section class="speakers-section-three" id="pembicara">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="title">@trans('frontsite.speaker')</span>
                <h2>@trans('frontsite.speakerdesc')</h2>
            </div>

            <div class="row">
                @forelse ($speakers as $speaker)
                    <!-- Speaker Block -->
                    <div class="speaker-block-three col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image img-speaker" data-poster="/storage/{{ $speaker->image }}"><a href="javascript:void(0)"><img src="/storage/{{ $speaker->image }}" alt=""></a></figure>
                            </div>
                            <div class="info-box">
                                <h4 class="name"><a href="#">{{ $speaker->name }}</a></h4>
                                <span class="designation">{{ $speaker->position }}</span>
                            </div>
                            <!-- <div class="social-box">
                                <ul class="social-links social-icon-colored">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    @empty
                        <div class="auto-container sec-title text-center">
                            <h4>@trans('frontsite.speaker.empty') !</h4>
                        </div>
                    @endforelse
                </div>
        </div>
    </section>
    <!-- End Speakers Section -->
    <!-- Agenda Section -->
    <section class="schedule-section" id="agenda">
        <div class="anim-icons">
            <span class="icon icon-circle-4 wow zoomIn"></span>
            <span class="icon icon-circle-3 wow zoomIn"></span>
        </div>

        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="title">{{ setting('title')->value }}</span>
                <h2>@trans('frontsite.agenda')</h2>
            </div>

            <div class="schedule-tabs tabs-box">
                <div class="schedule-timeline">
                    <!-- schedule Block -->
                    @forelse ($agendas as $agenda)
                    <div class="schedule-block {{ $loop->iteration % 2 == 0 ? 'even' : '' }}">
                        <div class="inner-box">
                            <div class="inner">
                                <div class="date">{{ $agenda->event_date }}</div>
                                <h4><a class="btn-agenda" href="javascript:void(0)" data-poster="{{ $agenda->poster }}" data-desc="{{ $agenda->speaker->desc ?? "" }}">{{ $agenda->title }}</a></h4>
                                
                                @if (!empty($agenda->speaker->name))
                                    <div class="text">@trans('frontsite.speaker'): {{ $agenda->speaker->name ?? "" }}</div>
                                @endif
                                <!-- <div class="btn-box">
                                    <a href="#" class="theme-btn">Selengkapnya</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="auto-container sec-title text-center">
                        <h4>@trans('frontsite.agenda.empty') !</h4>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- End Schedule -->
    <!-- Karya Section -->
    <section class="news-section" id="karya">
        <div class="anim-icons">
        </div>

        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="title">@trans('frontsite.project')</span>
                <h2>@trans('frontsite.projectdesc')</h2>
            </div>

            <div class="row">
                @forelse ($projects as $project)
                    <!-- News Block Three -->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="400ms">
                        <a href="{{ route('frontsite.project.show', $project->id) }}">
                            <!-- <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        <img src="/frontsite-assets/images/sample-karya.png" alt="">
                                        <div class="container-karya">
                                            <div class="title">
                                                <h3>Antar loundry</h3>
                                                <p class="sub-title">Desain Prototype UI-UX</p>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div> -->
                            <div class="inner-box">
                                <div class="image-box">
                                    @if (env('RESOURCES_PROJECT') == 'ONLINE')
                                        <figure class="image">
                                            <img src="@if(!empty($project->thumb->small_image)) https://technofest.stiki.ac.id/storage/{{ $project->thumb->small_image }} @else https://mgmall.s3.amazonaws.com/img/062023/390bed03e54f6440416f0568f61a82b563176996.jpg @endif" alt="">
                                            <div class="container-karya">
                                                <div class="title">
                                                    <h3>{{ \Illuminate\Support\Str::limit($project->title, 45) }}</h3>
                                                    <p class="sub-title">{{ $project->category->name }}</p>
                                                </div>
                                            </div>
                                        </figure>
                                    @else
                                        <figure class="image">
                                            <img src="@if(!empty($project->thumb->small_image)) /storage/{{ $project->thumb->small_image }}@else https://mgmall.s3.amazonaws.com/img/062023/390bed03e54f6440416f0568f61a82b563176996.jpg @endif " alt="">
                                            <div class="container-karya">
                                                <div class="title">
                                                    <h3>{{ \Illuminate\Support\Str::limit($project->title, 45) }}</h3>
                                                    <p class="sub-title">{{ $project->category->name }}</p>
                                                </div>
                                            </div>
                                        </figure>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="auto-container sec-title text-center">
                        <h4>@trans('frontsite.project.empty') !</h4>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="btn-box col-md-12" style="text-align: center;">
                    <a href="{{ route('frontsite.project.index') }}" class="theme-btn btn-style-one btn-lg"><span class="btn-title">@trans('frontsite.projectbtn')</span></a>
                </div>
            </div>
            
        </div>
    </section>
    <!--End Karya Section -->
    <!-- Modal -->
    <div id="popup-agenda" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body body-agenda">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="popup-speaker" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body body-speaker">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.btn-agenda').click(function() {
            let src = $(this).data('poster')
            let desc = $(this).data('desc')

            $('.body-agenda').html(`<center><img src="/storage/${src}" width="500px"></center><hr><br><p>${desc}</p>`)
            $('#popup-agenda').modal('show')
        })

        $('.img-speaker').click((e) => {
            let v = $(e.currentTarget).data('poster')
            $('.body-agenda').html(`<center><img src="${v}" width="500px"></center>`)
            $('#popup-agenda').modal('show')
        })
    </script>
@endsection