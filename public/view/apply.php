<section id="apply" class="contact section mt-1">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Apply Now</h2>
        <p>Interested in joining us? Submit your application below.</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Address</h3>
                            <p>2011 Palomar Airport Road, Suite 101, Carlsbad CA 92011 United States</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone"></i>
                            <h3>Call Us</h3>
                            <p>+1 909-723-2671 | +63 917 168 148</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope"></i>
                            <h3>Email Us</h3>
                            <p>agency@sakariwellness.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apply Now Form -->
            <div class="col-lg-6">
                <form action="forms/apply.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="position" class="form-control" placeholder="Position You're Applying For" required>
                        </div>
                        <div class="col-md-12">
                            <textarea name="coverletter" class="form-control" rows="4" placeholder="Brief Introduction / Cover Letter" required></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your application has been submitted. Thank you!</div>
                            <button type="submit">Submit Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
