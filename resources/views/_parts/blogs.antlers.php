<section class="bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 text-center margin-5-rem-bottom wow animate__fadeIn">
                <span class="alt-font font-weight-500 text-uppercase d-inline-block">You may also like</span>
                <h5 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px">Related posts</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12 blog-content">
                <ul class="blog-clean blog-wrapper grid grid-loading grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                    <li class="grid-sizer"></li>
                    {{ collection:blogs limit="3" orderby="date" sort="desc" }}
                    <!-- start blog item -->
                    <li class="grid-item wow animate__fadeIn">
                        <div class="blog-post text-center border-radius-6px bg-white box-shadow box-shadow-large-hover">
                            <div class="blog-post-image bg-gradient-fast-blue-purple">
                                <a href="{{ url }}"><img src="{{ thumbnail_image_url }}" alt="">
                                    <div class="blog-rounded-icon bg-white border-color-white absolute-middle-center">
                                        <i class="feather icon-feather-arrow-right text-extra-dark-gray icon-extra-small"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="post-details padding-30px-all xl-padding-25px-lr">
                                <a href="{{ url }}" class="post-author text-medium text-uppercase">23 February
                                    2020</a>
                                <a href="{{ url }}" class="text-extra-dark-gray font-weight-500 alt-font d-block">{{ title }}</a>
                            </div>
                        </div>
                    </li>
                    <!-- end blog item -->
                    {{ /collection:blogs }}
                </ul>
            </div>
        </div>
    </div>
</section>
