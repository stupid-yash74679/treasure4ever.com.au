<!-- start page title -->
<section class="no-padding one-third-screen position-relative wow animate__fadeIn">
    <div class="opacity-medium bg-extra-dark-gray z-index-0"></div>
    <div class="container">
        <div class="row align-items-center justify-content-center one-third-screen">
            <div class="col-xl-6 col-lg-7 col-md-10 position-relative page-title-large text-center">
                <span
                    class="d-block text-white opacity-6 margin-5px-bottom alt-font text-extra-medium font-weight-300">we
                    provide innovative solutions</span>
                <h1 class="alt-font text-white letter-spacing-minus-1px font-weight-500 no-margin-bottom">{{ title }}</h1>
            </div>
            <div class="down-section text-center"><a href="#down-section" class="section-link"><i
                        class="feather icon-feather-arrow-down icon-extra-small text-white bg-fast-blue padding-15px-all xs-padding-10px-all border-radius-100"></i></a>
            </div>
        </div>
    </div>
    <div class="swiper z-index-minus-2 position-absolute top-0px"
        data-slider-options='{ "loop": true, "slidesPerView": 1, "effect": "fade", "keyboard": { "enabled": true, "onlyInViewport": true }, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "fadeEffect": { "crossFade": true } }'>
        <div class="swiper-wrapper">
            <!-- start slider item -->
            <div class="swiper-slide cover-background one-third-screen"
                style="background-image:url('/images/page-title-bg-04.jpg');"></div>
            <!-- end slider item -->
            <!-- start slider item -->
            <div class="swiper-slide cover-background one-third-screen"
                style="background-image:url('/images/page-title-bg-05.jpg');"></div>
            <!-- end slider item -->
            <!-- start slider item -->
            <div class="swiper-slide cover-background one-third-screen"
                style="background-image:url('/images/page-title-bg-06.jpg');"></div>
            <!-- end slider item -->
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
                                <a href="#"
                                    class="btn btn-very-small btn-fancy btn-yellow-ochre margin-30px-top lg-margin-20px-top">Book
                                    Now</a>
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
