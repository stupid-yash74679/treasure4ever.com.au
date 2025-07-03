<!-- start page title -->
<section class="bg-gradient-light-orange-light-pink">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-end extra-small-screen align-items-end">
            <div class="w-100 w-md-50 page-title-extra-small">
                <h1
                    class="alt-font text-extra-dark-gray position-relative padding-90px-left padding-15px-right sm-padding-55px-left mb-md-0 sm-margin-20px-bottom">
                    <span class="page-title-separator-line bg-black w-70px sm-w-40px"></span>Contact Us
                </h1>
            </div>
            <div class="w-100 w-md-50">
                <h4 class="alt-font font-weight-500 text-extra-dark-gray mb-0">We create brand new corporate identities
                </h4>
            </div>
        </div>
    </div>
</section>
<!-- end page title -->

<!-- start section -->
<section class="big-section wow animate__fadeIn">
    <div class="container">
        <div class="row align-items-end justify-content-center">
            <div class="col-lg-12 col-md-12">
                <h4 class="alt-font text-black font-weight-600">Let's get in touch with us</h4>
                <form action="email-templates/contact-form.php" method="post" class="alt-font text-extra-dark-gray">
                    <input
                        class="input-border-bottom border-color-extra-dark-gray bg-transparent placeholder-dark large-input px-0 margin-25px-bottom border-radius-0px required"
                        type="text" name="name" placeholder="Your name" />
                    <input
                        class="input-border-bottom border-color-extra-dark-gray bg-transparent placeholder-dark large-input px-0 margin-25px-bottom border-radius-0px required"
                        type="email" name="email" placeholder="Your email address" />
                    <input
                        class="input-border-bottom border-color-extra-dark-gray bg-transparent placeholder-dark large-input px-0 margin-25px-bottom border-radius-0px"
                        type="tel" name="phone" placeholder="Mobile no" />
                    <textarea
                        class="input-border-bottom border-color-extra-dark-gray bg-transparent placeholder-dark large-input px-0 margin-35px-bottom border-radius-0px"
                        name="comment" rows="5" placeholder="How can we help you?"></textarea>
                    <div class="g-recaptcha margin-35px-bottom" data-sitekey="6LfJf98bAAAAAGC26hfKyd2Ptddbs9xYm4mCNeLx">
                    </div>
                    <input type="hidden" name="redirect" value="">
                    <button class="btn btn-medium btn-dark-gray mb-0 submit" type="submit">send message</button>
                    <div class="form-results d-none"></div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start map section -->
<section class="no-padding-tb wow animate__fadeIn">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0">
                <div class="map-style-3 h-500px xs-h-300px">
                    <iframe class="w-100 h-100 filter-grayscale-100"
                        src="{{ brand:gmap_url }}"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end map section -->

<!-- start section -->
<section class="half-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-auto sm-margin-15px-bottom wow animate__fadeIn" data-wow-delay="0.2s">
                <div class="d-flex justify-content-center align-items-center padding-15px-lr h-100">
                    <i
                        class="feather icon-feather-headphones align-middle icon-extra-small text-gradient-magenta-orange margin-10px-right"></i>
                    <a href="tel:{{ brand:phone_number }}"
                        class="text-extra-dark-gray alt-font text-medium">{{ brand:phone_number }}</a>
                </div>
            </div>
            <div class="col-12 col-sm-auto sm-margin-15px-bottom wow animate__fadeIn" data-wow-delay="0.4s">
                <div class="d-flex justify-content-center align-items-center padding-15px-lr h-100">
                    <i
                        class="feather icon-feather-mail align-middle icon-extra-small text-gradient-magenta-orange margin-10px-right"></i>
                    <a href="mailto:{{ brand:email }}"
                        class="text-extra-dark-gray alt-font text-medium">{{ brand:email }}</a>
                </div>
            </div>
            <div class="col-12 col-sm-auto wow animate__fadeIn" data-wow-delay="0.6s">
                <div class="d-flex justify-content-center align-items-center padding-15px-lr h-100">
                    <i
                        class="feather icon-feather-globe align-middle icon-extra-small text-gradient-magenta-orange margin-10px-right"></i>
                    <a href="#" class="text-extra-dark-gray alt-font text-medium">{{ brand:address }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->
