<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sakari Management Group</title>

    <meta name="description" content="Empowering healthcare through exceptional virtual support. Sakari Management Group provides skilled virtual assistants for utilization management, care coordination, billing, transcription, and more.">
    <meta name="keywords" content="Sakari Management Group, virtual healthcare assistants, healthcare outsourcing, utilization management, care coordination, medical transcription, healthcare VAs, virtual nurse, medical VA, virtual assistant healthcare, medical billing, healthcare support">
    <meta name="author" content="Sakari Management Group">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="Sakari Management Group | Virtual Healthcare Support">
    <meta property="og:description" content="Streamline your operations with skilled virtual assistants. Led by U.S.-trained clinicians, Sakari offers scalable, compliant, and cost-effective healthcare staffing solutions.">
    <meta property="og:image" content="https://sakariwellness.com/images/og-image.jpg"> <!-- Replace with your actual OG image URL -->
    <meta property="og:url" content="https://sakariwellness.com">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sakari Management Group | Virtual Healthcare Support">
    <meta name="twitter:description" content="Empowering healthcare through exceptional virtual support. Discover tailored solutions for billing, care coordination, and more.">
    <meta name="twitter:image" content="https://sakariwellness.com/images/twitter-card.jpg"> <!-- Replace with your actual Twitter card image URL -->


    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">


    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Sakari Management Group</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="https://igostaffing.com/" target="_blank">Visit iGO Staffing</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="cta-btn" href="index.html#about">Apply Now</a>

        </div>
    </header>

    <section id="hero" class="hero section dark-background">

        <img src="assets/img/medical-procedures-3579029.jpg" alt="" data-aos="fade-in">

        <div class="container d-flex flex-column align-items-center">
            <h3 data-aos="fade-up" data-aos-delay="100">Empowering Healthcare Through Exceptional Virtual Support</h3>
            <p id="typewriter-text" data-aos="fade-up" data-aos-delay="200" style="font-size: 16px;"></p>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const sentences = [
                        "Professional, reliable, and skilled virtual assistants to streamline your healthcare operations and reduce costs.",
                        "Sakari Management Group is a business process outsourcing firm led by U.S.-trained clinicians, providing premium virtual healthcare talent to organizations across the globe.",
                        "From utilization management and care coordination to transcription and billing, we match your needs with highly skilled professionals who understand the demands of modern healthcare.",
                        "Whether you're a growing practice or an enterprise-level organization, we deliver solutions that scale with you.",
                        "Professional, reliable, and skilled virtual assistants to streamline your healthcare operations and reduce costs."
                    ];
                    const el = document.getElementById("typewriter-text");
                    let sentenceIdx = 0;

                    function typeSentence(sentence, cb) {
                        el.textContent = "";
                        let i = 0;

                        function typeWriter() {
                            if (i < sentence.length) {
                                el.textContent += sentence.charAt(i);
                                i++;
                                setTimeout(typeWriter, 35);
                            } else if (cb) {
                                setTimeout(cb, 1800);
                            }
                        }
                        typeWriter();
                    }

                    function showNextSentence() {
                        typeSentence(sentences[sentenceIdx], function() {
                            el.textContent = "";
                            sentenceIdx = (sentenceIdx + 1) % sentences.length;
                            setTimeout(showNextSentence, 400);
                        });
                    }

                    showNextSentence();
                });
            </script>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="#about" class="btn-get-started">Hire a Nurse Now </a>
                <a class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-telephone"></i><span>Schedule a Consultation</span></a>
            </div>
        </div>

    </section>


    <!-- Clients Section -->
    <section id="clients" class="clients section light-background">

        <div class="container d-flex justify-content-center" data-aos="fade-up">
            <div class="row gy-4 justify-content-center">


                <div class="col-xl-3 col-md-3 col-6 client-logo d-flex justify-content-center">
                    <img src="assets/img/igot.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->
                <div class="col-xl-3 col-md-3 col-6 client-logo d-flex justify-content-center">
                    <a href="https://igostaffing.com/" target="_blank">

                        <img src="assets/img/logo.png" class="img-fluid" alt="">
                    </a>

                </div><!-- End Client Item -->
                <div class="col-xl-3 col-md-3 col-6 client-logo d-flex justify-content-center">

                    <img src="assets/img/sakari.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->
            </div>
        </div>

    </section><!-- /Clients Section -->

    <section id="about" class="about section">

        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3>Our Mission</h3>
                    <img src="assets/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="">
                    <p>To empower businesses and individuals by delivering exceptional virtual support tailored to their unique needs. We are dedicated to fostering efficiency, innovation, and growth through reliable, skilled, and professional virtual assistance. Our goal is to create lasting partnerships that drive success and simplify the complexities of modern business.</p>

                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="content ps-0 ps-lg-5">
                        <h3>Our Vision</h3>
                        <p class="fst-italic">
                            To become the leading global provider of virtual assistant services, recognized for our commitment to excellence, adaptability, and the empowerment of businesses worldwide. We envision a future where every organization, regardless of size, has access to affordable, high-quality support that allows them to focus on their goals and achieve sustainable growth.
                        </p>
                        <ul>

                            <li><i class="bi bi-check-circle-fill"></i> <span>Redefine the standards of virtual assistance with innovative, client-focused solutions.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Inspire confidence and trust through professionalism and integrity.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Build a thriving community of skilled virtual assistants and successful clients.</span></li>
                        </ul>


                        <div class="position-relative mt-4">
                            <img src="assets/img/about-2.jpg" class="img-fluid rounded-4" alt="">
                            <a href="assets/video/video.mp4" class="glightbox pulsating-play-btn"></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <section id="team" class="team section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Leadership Team</h2>
            <p>Experienced leaders from diverse backgrounds</p>
        </div>


        <div class="container">

            <div class="row gy-5">

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="member">
                        <div class="pic"><img src="assets/img/team/van.jpg" class="img-fluid" alt=""></div>
                        <div class="member-description ">
                            Van Cacho – CEO & Co-Founder<br>
                            A U.S.-trained Family Nurse Practitioner with clinical roots in Psychiatry, LDRP, and Wound Care, Van leads with a mission to bridge frontline healthcare experience with scalable operational solutions. As CEO, she champions excellence, compliance, and innovation across every aspect of our business.
                        </div>
                        <div class="member-info">
                            <h4>Van Cacho</h4>
                            <span>CEO & Co-Founder</span>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href="https://www.linkedin.com/in/junette-cacho-8a7309138/"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="member">
                        <div class="pic"><img src="assets/img/team/josh.jpg" class="img-fluid" alt=""></div>
                        <div class="member-description ">
                            Dr. Joshua Cacho - Co-Founder<br>
                            With over 15 years of clinical experience as a Doctor of Physical Therapy, Dr. Josh specializes in orthopedic rehabilitation and performance optimization. He now leads our efforts to bring high-impact care models to healthcare systems through virtual staffing solutions.
                        </div>
                        <div class="member-info">
                            <h4>Dr. Joshua Cacho</h4>
                            <span>Co-Founder</span>
                            <div class="social">

                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href="https://www.linkedin.com/in/joshua-cacho-pt-dpt-b2b34734/"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->


                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="member">
                        <div class="pic"><img src="assets/img/team/glenda-v2.png" class="img-fluid" alt=""></div>
                        <div class="member-description ">
                            Glenda Lu-Belarmino – Chief of Human Resources<br>
                            A seasoned RN and operations leader, Glenda brings a decade of experience in building and managing high-performing VA teams. She drives talent acquisition, performance optimization, and strategic growth.
                        </div>
                        <div class="member-info">
                            <h4>Glenda Lu-Belarmino</h4>
                            <span>Chief of Human Resources</span>
                            <div class="social">

                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href="https://www.linkedin.com/in/glenda-belarmino-67a04421/"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="member">
                        <div class="pic"><img src="assets/img/team/mike.jpeg" class="img-fluid" alt=""></div>
                        <div class="member-description ">
                            Mike Austria – Chief Financial Officer<br>
                            An RN by training and serial entrepreneur, Mike blends clinical understanding with financial acumen. As CFO, he helps nurses transition into high-impact roles while ensuring clients receive cost-effective, quality service. </div>
                        <div class="member-info">
                            <h4>Mike Austria</h4>
                            <span>Chief Financial Officer</span>
                            <div class="social">

                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href="https://www.linkedin.com/in/mike-austria-bsn-rn-b786856b/"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section>

    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Services</h2>
            <p>Featured Services<br></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-5">

                <!-- Referral Management -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-1.jpg" class="img-fluid" alt="Referral Management">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Referral Management</h3>
                            </a>
                            <p>We manage incoming and outgoing referrals for your practice, ensuring timely follow-ups and patient continuity.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Transcription -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-2.jpg" class="img-fluid" alt="Transcription">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-mic-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Transcription</h3>
                            </a>
                            <p>Our transcription team reviews and processes clinician progress notes with precision and confidentiality.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Medical Records Management -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-3.jpg" class="img-fluid" alt="Medical Records Management">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-folder2-open"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Medical Records Management</h3>
                            </a>
                            <p>We help organize, audit, and maintain patient care documentation to support compliance and improve accessibility.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Scheduling Support -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/Scheduling.jpg" class="img-fluid" alt="Scheduling Support">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Scheduling Support</h3>
                            </a>
                            <p>We ensure clinicians are scheduled efficiently and equitably to maximize coverage and reduce care gaps.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Utilization Management -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/Utilization.jpg" class="img-fluid" alt="Utilization Management">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Utilization Management </h3>
                            </a>
                            <p>Using MCG or InterQual criteria, we support prior authorizations, concurrent reviews, and retrospective case analysis.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Care Coordination -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="700">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/CareCoordination.jpg" class="img-fluid" alt="Care Coordination">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-diagram-3-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Care Coordination</h3>
                            </a>
                            <p>We manage transitions of care, ensuring patients move smoothly between hospital, SNF, and home health settings.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Patient Navigation -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="800">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/PatientNavigation.jpg" class="img-fluid" alt="Patient Navigation">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-map-fill"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Patient Navigation</h3>
                            </a>
                            <p>Our team ensures patients are informed, updated, and supported throughout their care journey.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Billing & Coding -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="900">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/billing-v2.jpg" class="img-fluid" alt="Billing & Coding">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Billing & Coding</h3>
                            </a>
                            <p>ICD-10 certified professionals handle accurate, compliant billing and coding to improve reimbursement cycles.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <!-- Sales & Marketing Support -->
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="1000">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/sales.jpg" class="img-fluid" alt="Sales & Marketing Support">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Sales & Marketing Support</h3>
                            </a>
                            <p>We provide client relations and business development support to help you retain and expand your customer base.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>


    </section><!-- /Services Section -->

    <section id="features" class="features section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Key Features</h2>
            <p>Why Outsource with Sakari<br></p>
        </div><!-- End Section Title -->
        <div class="container">

            <ul class="nav nav-tabs row d-flex" data-aos="fade-up" data-aos-delay="100">
                <li class="nav-item col-3">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                        <i class="bi bi-person-badge"></i>
                        <h4 class="d-none d-lg-block">U.S.-Trained Leadership</h4>
                    </a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                        <i class="bi bi-check-circle"></i>
                        <h4 class="d-none d-lg-block">Quality Recruitment</h4>
                    </a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                        <i class="bi bi-cash-coin"></i>
                        <h4 class="d-none d-lg-block">Cost Efficiency</h4>
                    </a>
                </li>
                <li class="nav-item col-3">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4">
                        <i class="bi bi-sliders"></i>
                        <h4 class="d-none d-lg-block">Scalable & Compliant</h4>
                    </a>
                </li>
            </ul>


            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                <div class="tab-pane fade active show" id="features-tab-1">
                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                            <h3>U.S.-Trained Leadership</h3>
                            <p>Led by a Family Nurse Practitioner and Doctor of Physical Therapy currently based in the Philippines.</p>
                            <ul>
                                <li><i class="bi bi-check2-all"></i> <span>Clinically experienced team members.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>In-depth understanding of U.S. healthcare protocols.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Bridging U.S. standards with Filipino excellence.</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 text-center">
                            <img src="assets/img/working-1.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="features-tab-2">
                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                            <h3>Quality Recruitment</h3>
                            <p>We personally vet every nurse for skill, professionalism, and alignment with your clinical standards.</p>
                            <ul>
                                <li><i class="bi bi-check2-all"></i> <span>Rigorous skill assessments and interviews.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Behavioral and cultural fit evaluations.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Client-specific clinical criteria upheld.</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 text-center">
                            <img src="assets/img/working-2.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="features-tab-3">
                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                            <h3>Cost Efficiency</h3>
                            <p>Reduce overhead while accessing top-tier talent.</p>
                            <ul>
                                <li><i class="bi bi-check2-all"></i> <span>Significant savings vs local staffing.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>No compromise on quality.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Transparent and flexible pricing models.</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 text-center">
                            <img src="assets/img/working-3.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="features-tab-4">
                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                            <h3>Scalable & Compliant</h3>
                            <p>We scale with your needs—from a single VA to an entire department. Our team understands healthcare regulations and works to uphold your standards.</p>
                            <ul>
                                <li><i class="bi bi-check2-all"></i> <span>HIPAA-aware workforce.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Custom support teams built to grow with you.</span></li>
                                <li><i class="bi bi-check2-all"></i> <span>Long-term and short-term contracts available.</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 text-center">
                            <img src="assets/img/working-4.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Features Section -->

    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Need one or many? We're ready to help.</p>
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
                                <p>2011 Palomar Airport Road, Suite 101, Carlsbad CA 92011 United States
                                </p>
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

                <!-- Contact Form -->
                <div class="col-lg-6">
                    <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="col-md-12">
                                <textarea name="message" class="form-control" rows="4" placeholder="Message" required></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer" class="footer dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Sakari Management Group</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>2011 Palomar Airport Road, Suite 101,</p>
                        <p>Carlsbad CA 92011 United States</p>

                        <p class="mt-3"><strong>Phone:</strong><br>
                            <span>+1 909-723-2671</span><br>
                            <span>+63 917 168 148</span>
                        </p>
                        <p><strong>Email:</strong><br>
                            <span>agency@sakariwellness.com</span>
                        </p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=61573640922847" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Privacy Policy</h4>
                    <p>
                        Sakari Management Group is committed to safeguarding your information. We collect only necessary data to deliver services and never share or sell your information. By using this website, you consent to our data practices.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Terms of Service</h4>
                    <p>
                        Use of this website and our services is subject to the terms outlined herein. Sakari Management Group reserves the right to update services, pricing, and policies. Clients are expected to comply with data protection and contractual terms.
                    </p>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <strong class="px-1 sitename">Sakari Management Group</strong> All Rights Reserved</p>
            <div class="credits">
                Designed by <a href="https://www.facebook.com/NasaPh8210">Nasa PH</a>
            </div>
        </div>

    </footer>



    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>