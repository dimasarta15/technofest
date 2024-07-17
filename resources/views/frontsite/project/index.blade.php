@extends('layouts.frontsite-layout')

@section('content')
<!--Page Title-->
<section class="page-title" style="background-color: #232323">
    <div class="auto-container">
        <h1>Karya {{ getNameByEmail(request()->email) }}</h1>
        <ul class="bread-crumb clearfix">
            <li><a href="/">Home</a></li>
            <li>Karya</li>
        </ul>
    </div>
</section>
<!--End Page Title-->

<!-- News Section -->
<section class="news-section alternate">
    <div class="auto-container">
        <div class="row news-block col-md-12">
            <div class="col-md-12">
                <form method="GET" action="@actionSearch" id="contact-form" class="form-horizontal">
                    @if (!empty(request()->semester_id))
                        <input type="hidden" class="form-control" name="semester_id" value="{{ request()->semester_id }}">
                    @endif

                    <div class="row">
                        <!-- <div class="form-group"> -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cari Judul... " name="search" required style="height: 50px;" value="{{ request()->search }}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn-style-one" type="submit">
                                <span class="btn-title"><i class="fas fa-search"></i> Cari</span>
                            </button>
                        </div>
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- News Block Three -->
            @forelse ($projects as $project)
            <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight">
                <div class="inner-box">
                    <div class="image-box">
                        @if (env('RESOURCES_PROJECT') == 'ONLINE')
                            @if (!empty($project->thumb))
                                <figure class="image"><a href="{{ route(getLang() . 'frontsite.project.show', $project->id) }}"><img src="https://technofest.stiki.ac.id/{{ str_replace('project', 'berkas/karya/', $project->thumb->small_image) }}" alt=""></a></figure>
                            @else
                                <figure class="image"><a href="{{ route(getLang() . 'frontsite.project.show', $project->id) }}"><img src="https://www.instandngs4p.eu/wp-content/themes/fox/images/placeholder.jpg" alt=""></a></figure>
                            @endif
                        @else
                            <figure class="image">
                                <a href="{{ route(getLang() . 'frontsite.project.show', $project->id) }}">
                                    @if (!empty($project->thumb))
                                        <img src="/storage/{{ $project->thumb->small_image }}" alt="">
                                    @else
                                        <img src="https://www.instandngs4p.eu/wp-content/themes/fox/images/placeholder.jpg" alt="">
                                    @endif
                                </a>
                            </figure>
                        @endif
                    </div>
                    <div class="lower-content">
                        <ul class="post-info">
                            <!-- <li><span class="far fa-user"></span> Admin</li> -->
                            <li><span class="far fa-clipboard"></span> {{ $project->category->name }}</li>
                        </ul>
                        <h4><a href="{{ route(getLang() . 'frontsite.project.show', $project->id) }}">{{ str_limit($project->title, 45) }}</a></h4>
                        <div class="btn-box"><a href="{{ route(getLang() . 'frontsite.project.show', $project->id) }}" class="read-more">Selengkapnya</a></div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <!-- <div class="row" id="data-wrapper">
            </div> -->
        <!--Styled Pagination-->
        {!! $projects->links('vendor.pagination.custom') !!}
        <!-- <ul class="styled-pagination text-center">
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#"><span class="icon fa fa-angle-right"></span></a></li>
            </ul> -->
        <!--End Styled Pagination-->
    </div>
</section>
<!--End News Section -->
@endsection

@section('script')
<script>
    /* var ENDPOINT = "{{ route(getLang() . 'frontsite.project.index') }}";
        var page = 1;
        infinteLoadMore(page);

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });

        function infinteLoadMore(page) {
            $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.length == 0) {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }
                $('.auto-load').hide();
                $("#data-wrapper").append(response);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
        } */
</script>
@endsection