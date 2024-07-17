<style>
    .sidebar-title2 {
        position: relative !important;
        display: block !important;
        font-size: 24px !important;
        line-height: 1.2em !important;
        color: #333333 !important;
        font-weight: 700 !important;
        margin-bottom: 20px !important;
        padding-bottom: 20px !important;
        border-bottom: 2px solid #eeeeee !important;
    }

    .blog-categories2 li a {
        position: relative;
        display: block;
        color: #333333;
        font-size: 18px;
        line-height: 30px;
        font-weight: 400;
        margin-bottom: 10px;
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
    }
    /* style_btn_style_one */
    .btn-style-one {
        background-color: {{ setting('style_btn_style_one')->value ?? "#ec167f"}};
    }

    .btn-style-one:hover{
        color: {{ setting('style_btn_style_one')->value ?? "#ec167f" }}; /* custom */
    }

    /* style_info_box */
    .speaker-block-three .info-box{
        background-color: {{ setting('style_info_box')->value ?? "#f20487" }}; /* custom */
    }

    .speaker-block-three .info-box:before{
        background-color: {{ setting('style_info_box')->value ?? "#f20487" }}; /* custom */
    }

    /* style_image_box */
    .speaker-block-three .image-box .image{
        border: 4px solid {{ setting('style_image_box')->value ?? "#682372" }}; /* custom */
    }

    /* style_scroll_to_top */
    .scroll-to-top{
        background:{{ setting('style_scroll_to_top')->value ?? "#e1137b" }};
    }

    /* style_scroll_to_top_hover */
    .scroll-to-top:hover{
        color:#ffffff;
        background: {{ setting('style_scroll_to_top_hover')->value ?? "#4c35a9" }};
    }

    /* style_selection */
    ::selection {
        background:{{ setting('style_selection')->value ?? "#ec167f"}};
    }

    ::-moz-selection {
        background:{{ setting('style_selection')->value ?? "#ec167f"}};
    }

    ::-webkit-selection {
        background:{{ setting('style_selection')->value ?? "#ec167f"}};
    }

    /* style_btn_box */
    .news-block .btn-box a{
        background-color: {{ setting('style_btn_box')->value ?? "#1d95d2"}};
    }

    /* style_pagination */
    .styled-pagination li a{
        border-bottom: 2px solid {{ setting('style_pagination')->value ?? "#ec167f" }};
    }

    .styled-pagination li a:hover,
    .styled-pagination li a.active{
        background-color: {{ setting('style_pagination')->value ?? "#ec167f" }};
    }

    /* style_footer */
    .main-footer{
        background-color: {{ setting('style_footer')->value ?? "#101130" }};
    }

    /* style_page_title */
    .page-title{
        background-color: {{ setting('style_page_title')->value ?? "#232323" }}; !important;
    }

    /* style_btn_style_two */
    .btn-style-two{
        background-color: {{ setting('style_btn_style_two')->value ?? "#faaC1D" }};
    }

    /* style_btn_style_two_hover */
    .btn-style-two:hover {
	    color: {{ setting('style_btn_style_two_hover')->value ?? "#faaC1D" }};
    }

    /* style_navigation_hover_1 */
    .main-menu .navigation > li > ul > li:hover > a{
        color: {{ setting('style_navigation_hover_1')->value ?? "#e1137b" }};
    }

    /* style_navigation_hover_2 */
    .main-menu .navigation > li > ul > li > ul > li:hover > a{
        color: {{ setting('style_navigation_hover_2')->value ?? "#e1137b" }};
    }

    @if (!empty(setting('custom_css')->value))
        {!! setting('custom_css')->value !!}
    @endif
    .bb-feedback-button-icon {
        margin-bottom: -10px;
        margin-left: -100px;
    }
</style>