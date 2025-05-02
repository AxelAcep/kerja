<?= $this->extend('layout/template-home'); ?>
<?= $this->section('content'); ?>

<!-- font Poppins tittle about -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">


<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center" style="background: url('/assets/frontend/img/<?= $home['home_bg_heading']; ?>') top left;">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
        <h1><?= $home['home_caption_1']; ?> <span><?= $about['about_name']; ?></span></h1>
        <h2><?= $home['home_caption_2']; ?></h2>
        <div class="d-flex">
            <a href="#featured-services" class="btn-get-started scrollto">Get Started</a>
            <a href="<?= $home['home_video']; ?>" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class="bx bx-book"></i></div> 
                        <h4 class="title">Belajar</h4> 
                        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="bx bx-run"></i></div>
                        <h4 class="title">Berjuang</h4>
                        <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="bx bx-building"></i></div>
                        <h4 class="title">Bertaqwa</h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                    </div>
                </div>s

            </div>

        </div>
    </section>
    <!-- End Featured Services Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg">
        <div class="container" data-aos="fade-up">

        <div class="section-title text-center">
            <h2>About</h2>
            <h3><span><?= $about['about_name']; ?></span></h3>
            <div class="about-description mx-auto">
                <p> <?= $about['about_description']; ?></p>
            </div>
    </section>

    
    <!-- End About Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials" style="background: url('/assets/frontend/img/<?= $home['home_bg_testimonial']; ?>') no-repeat;">
        <div class="container" data-aos="zoom-in">

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="<?= 'assets/backend/images/testi/' . $testimonial['testimonial_image']; ?>" class="testimonial-img" alt="">
                                <h3><?= $testimonial['testimonial_name']; ?></h3>
                                <h4><?= $testimonial['testimonial_angkatan']; ?></h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    <?= $testimonial['testimonial_content']; ?>
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- End testimonial item -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- End Testimonials Section -->

</main><!-- End #main -->

<?= $this->endSection(); ?>