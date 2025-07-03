<!-- start page title -->
<section class="parallax" data-parallax-background-ratio="0.5"
    style="background-image:url('{{ website_settings:page_header_background_image }}');">
    <div class="opacity-extra-medium bg-extra-dark-gray"></div>
    <div class="container">
        <div class="row align-items-stretch justify-content-center small-screen">
            <div
                class="col-12 position-relative page-title-extra-small text-center d-flex align-items-center justify-content-center flex-column">
                <h1 class="alt-font text-white opacity-6 margin-20px-bottom">Gallery</h1>
                <h2
                    class="text-white alt-font font-weight-500 w-55 md-w-65 sm-w-80 center-col xs-w-100 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">
                    Timeless moments, captured forever. </h2>
            </div>
            <div class="down-section text-center"><a href="#gallery" class="section-link"><i
                        class="ti-arrow-down icon-extra-small text-white bg-transparent-black padding-15px-all xs-padding-10px-all border-radius-100"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- end page title -->
<!-- start section -->
<section class="pt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 filter-content">
                <ul class="portfolio-colorful portfolio-wrapper grid grid-loading grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large text-center"
                    data-opacity="0.9"
                    data-backgroundcolor="#58bc4b,#d9a026,#813ea9,#82bc13,#214bdf,#e28e1a,#04c05c,#e52d8c,#029bd3,#e77345,#0575c4,#e2731a,">
                    <li class="grid-sizer"></li>
                 {{ images sort="random" }}
                    <!-- start portfolio item -->
                    <li class="grid-item wow animate__fadeIn">
                        <a href="javascript:void(0);">
                            <div class="portfolio-box">
                                <div class="portfolio-image">
                                    <img src="{{ url }}" alt="" />
                                </div>
                            </div>
                        </a>
                    </li>
                    <!-- end portfolio item -->
                    {{ /images }}
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end section -->
