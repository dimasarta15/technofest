@extends('layouts.frontsite-layout')

@section('content')
<!--Page Title-->
<section class="page-title" style="background-color: #232323">
    <div class="auto-container">
        <h1>@trans('frontsite.archiveprojects')</h1>
        <ul class="bread-crumb clearfix">
            <li><a href="/">Home</a></li>
            <li>@trans('frontsite.archiveprojects')</li>
        </ul>
    </div>
</section>
<!--End Page Title-->

<!-- News Section -->
<section class="news-section alternate">
    <div class="auto-container">
        <div class="row news-block col-md-12">
            <div class="col-md-12">
                <form method="GET" action="{{ route(getLang() . 'frontsite.project-archive.index') }}" id="contact-form" class="form-horizontal">
                    <div class="row">
                        <!-- <div class="form-group"> -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="@trans('frontsite.archive.searchplaceholder')" name="search" required style="height: 50px;" value="{{ request()->search }}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn-style-one" type="submit">
                                <span class="btn-title"><i class="fas fa-search"></i> @trans('frontsite.archive.searchbtn')</span>
                            </button>
                        </div>
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- News Block Three -->
            <div class="outer-box">
                <div class="row">
                    <!-- Unduhan Block -->
                    @forelse ($semesters as $semester)
                        <div class="pricing-block-three col-lg-4 col-md-6 col-sm-12 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;width:100%;">
                            <div class="inner-box" style="width:400px;">
                                <div class="title">
                                    <strong>{{ $semester->title }}</strong>
                                </div>
                                <p class="features">
                                    {{ $semester->semester }}
                                </p>
                                <div class="btn-box">
                                    <a href="{{ route(getLang() . 'frontsite.project.index', ['semester_id' => $semester->id]) }}" class="theme-btn btn-style-one"><span class="btn-title">@trans('frontsite.seemore')</span></a>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <!-- <div class="row" id="data-wrapper">
            </div> -->
        <!--Styled Pagination-->
        {!! $semesters->links('vendor.pagination.custom') !!}
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