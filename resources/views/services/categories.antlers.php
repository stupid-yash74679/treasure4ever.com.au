<!-- start page title -->
<section class="parallax" data-parallax-background-ratio="0.5"
    style="background-image:url('{{ website_settings:page_header_background_image }}');">
    <div class="opacity-extra-medium bg-extra-dark-gray"></div>
    <div class="container">
        <div class="row align-items-stretch justify-content-center small-screen">
            <div
                class="col-12 position-relative page-title-extra-small text-center d-flex align-items-center justify-content-center flex-column">
                <h1 class="alt-font text-white opacity-6 margin-20px-bottom">{{ title }}</h1>
                <h2
                    class="text-white alt-font font-weight-500 w-55 md-w-65 sm-w-80 center-col xs-w-100 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">
                    Capturing moments that last a lifetime</h2>
            </div>
            <div class="down-section text-center"><a href="#about" class="section-link"><i
                        class="ti-arrow-down icon-extra-small text-white bg-transparent-black padding-15px-all xs-padding-10px-all border-radius-100"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- end page title -->
<!-- start section -->
<section class="big-section wow animate__fadeIn">
    <div class="container">
        <div class="row justify-content-center">

        </div>
        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center">
            {{ entries }}
            <!-- start interactive banner item -->
            <div class="col interactive-banners-style-14 md-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn"
                data-wow-delay="0.2s" style="margin-bottom: 20px;">
                <figure class="mb-0">
                    <img src="/images/hotel-resort-img-13.jpg" alt="" />
                    <figcaption>
                        <div
                            class="hover-content align-items-center d-flex flex-column h-100 text-center last-paragraph-no-margin">
                            <h6 class="alt-font font-weight-500 text-white w-50 mb-auto" style="margin-top: 20%;">{{ title }}</h6>
                            <div class="hover-show-content">
                                <a href="{{ url }}"
                                    class="btn btn-very-small btn-fancy btn-yellow-ochre margin-30px-top lg-margin-20px-top">Explore</a>
                            </div>
                        </div>
                        <div class="hover-action-btn text-center">
                            <span
                                class="w-40px h-40px line-height-44px d-inline-block bg-yellow-ochre rounded-circle"><i
                                    class="feather icon-feather-arrow-right text-dark-purple icon-extra-small"></i></span>
                        </div>
                        <div class="opacity-medium bg-dark-purple z-index-minus-1"></div>
                        <div class="overlayer-box bg-dark-purple z-index-minus-1"></div>
                    </figcaption>
                </figure>
            </div>
            <!-- end interactive banner item -->
            {{ /entries }}
        </div>
    </div>
</section>
<!-- end section -->

{{ partial src="_parts/blogs" }}

{{ partial src="_parts/testimonials" }}
