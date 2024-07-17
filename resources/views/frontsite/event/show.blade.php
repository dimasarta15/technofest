@extends('layouts.frontsite-layout')

@section('content')
<!--Page Title-->
<section class="page-title" style="background-color: #232323">
    <div class="auto-container">
        <h1 style="font-size:50px;">@trans('frontsite.event') {{ ucfirst($semester->title) }}</h1>
        <ul class="bread-crumb clearfix">
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('frontsite.project.index') }}">@trans('frontsite.event')</a></li>
            <li>{{ ucfirst($semester->title) }} ({{ ucfirst($semester->semester) }})</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<!-- Gallery Section -->
<section class="gallery-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="title">@trans('frontsite.event.title')</span>
            <h2>@trans('frontsite.event.title') {{ ucfirst($semester->title) }}</h2>
        </div>

        <section class="pb-5">
            <div class="container text-center">
                <!-- Masonry grid -->
                <div class="gallery-wrapper">
                    <!-- Grid sizer -->
                    <div class="grid-sizer col-lg-4 col-md-6"></div>

                    <!-- Grid item -->

                    @forelse ($events as $event)
                    <!-- Grid item -->
                    <div class="col-lg-4 col-md-6 grid-item mb-4">
                        @if (empty($event->youtube))
                            <img class="img-fluid w-100 mb-3 img-thumbnail shadow-sm rounded-0" src="/storage/{{ $event->photo }}" alt="">
                        @else
                            <div class="item-video">
                                <a href="#" class="box-video popup-play-video" data-toggle="modal" data-target="#popup-video" data-src="{{ ytParse($event->youtube) }}">
                                    <div class="overlay-video" style="height: 190px;">
                                        <i class="fa fa-play-circle" style="font-size: 60px; color: {{ setting('style_btn_style_one')->value ?? "#ec167f" }}; position: absolute; top: 35%; left: 42%;"></i>
                                    </div>
                                    <iframe width="545" height="190px" src="https://www.youtube.com/embed/{{ ytParse($event->youtube) }}" title="Killing Me Inside - Biarlah (Official Music Video)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </a>
                            </div>
                        @endif
                        <h2 class="h4">{{ $event->title }}</h2>
                    </div>

                    @empty
                    <div class="col-lg-4 col-md-6 grid-item mb-4">
                        <h2 class="h4">@trans('frontsite.event.empty')</h2>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!--Styled Pagination-->
        {!! $events->links('vendor.pagination.custom') !!}
        <!--End Styled Pagination-->
    </div>

    <!-- Modal -->
    <div id="popup-video" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <center>
                    <div class="modal-body modal-play-video">
                    </div>
                </center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</section>
<!--End Gallery Section -->
@endsection

@section('script')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4.1.4/imagesloaded.pkgd.min.js"></script>
<script>
    $(function() {
        // Initate masonry grid
        var $grid = $('.gallery-wrapper').masonry({
            temSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true,
        });

        // Initate imagesLoaded
        $grid.imagesLoaded().progress(function() {
            $grid.masonry('layout');
        });

    });

    $('.popup-play-video').click(function(e) {
        e.preventDefault()

        let src = $(this).data('src')
        let canv = `
        <iframe width="727" 
            height="409" 
            src="https://www.youtube.com/embed/${src}"
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
        `
        $('.modal-play-video').html(canv)
    })

    $('#popup-video').on('hidden.bs.modal', function () {
        $('.modal-play-video').html(``)
    })
</script>
@endsection