<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SYCC</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/all.min.css') }}">
    <style>
        .jb-hero{
            width: 100%;
            height: 720px;
            background-image: url('{{ asset("assets/bgsycc.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            margin-top: -67px;
            margin-bottom: 70px;
            color: #fff;
        }
        #particles-js{
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 999;
        }
    </style>
</head>
<body>
    @include('layouts.partials.navbar')
    <div id="particles-js">
    </div>
    <div class="jumbotron jumbotron-fluid jb-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="hero-title">
                        Save Your Account
                    </h1>
                    <p class="hero-text">
                        A Tool for Remembering Your Account
                    </p>
                </div>
            </div>
        </div>
    </div>

    <section id="intro">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="section-title">
                        Introduction
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/intro.jpg') }}" alt="" class="img-intro">
                </div>

                <div class="col-md-6 intro-text">
                    <h2 class="intro-title">
                        Don't Worry If You Forgot Your Account, We Will Remember It
                    </h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque mollitia praesentium impedit, excepturi dolore eaque qui quae ipsum animi alias delectus laborum fugiat architecto tempore laudantium aperiam Nulla, praesentium quibusdam.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="section-title">
                        About Developer
                    </h1>
                </div>
            </div>

            <div class="row quotes justify-content-center">
                <div class="col-6">
                        <i class="fas fa-quote-right fa-2x"></i>
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias expedita velit corrupti facere id impedit cumque vero autem ea modi qui enim blanditiis dolores magnam ipsum, commodi facilis quibusdam fugiat. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Magnam nesciunt quae, perferendis, omnis, provident placeat qui iusto illum voluptas nemo nobis eos ducimus maiores perspiciatis nihil ea atque exercitationem illo?
                        </p>
                </div>
            </div>

            <div class="row my-self">
                <div class="col-12">
                    <img src="{{ asset('assets/bgsycc.jpg') }}" alt="" class="rounded-circle" width="130px" height="130px">
                    <p class="name">Rafi Septian Hadi</p>
                    <p class="job">Developer</p>
                </div>
            </div>

        </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="section-title">
                        Contact Us
                    </h1>
                </div>
            </div>

            <div class="row contact-card">
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fab fa-instagram fa-4x mb-2"></i>
                            <p>
                                @rafi_s7075
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-4x mb-2"></i>
                            <p>
                                +62 878-3123-7678
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="far fa-envelope fa-4x mb-2"></i>
                            <p>
                                rafiseptian177@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partials.footer')

<script src="{{ asset('vendor/particel-js/particles.js') }}"></script>
<script>
    particlesJS.load('particles-js', '{{ asset("vendor/particel-js/particlesjs-config.json") }}');
</script>
</body>
</html>