<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <?php 
        // Brand name set in App/Providers/AppServiceProvider.php
        // Page name set as route parameter
        ?>
        <title>
            @isset ($page_name)
                {{$page_name}} - 
            @endisset
            {{ $brand_name }}
        </title>
        <!-- STYLESHETS -->
        <link rel="stylesheet" href="<?= asset('assets/bootstrap/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
        <link rel="stylesheet" href="<?= asset('assets/fonts/fontawesome-all.min.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/fonts/font-awesome.min.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/fonts/simple-line-icons.min.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/fonts/fontawesome5-overrides.min.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/home.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/male-female.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/my-account.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/navbar.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/smoothproducts.css')?>">
        <link rel="stylesheet" href="<?= asset('assets/css/baguetteBox.min.css')?>">

        <!-- SCRIPTS -->
        <script src="<?= asset('assets/js/jquery.min.js')?>"></script>
        <script src="<?= asset('assets/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?= asset('assets/js/init.js')?>"></script>
        

    </head>

    <body>

        <!-- N  A   V   I   G   A   T   I   O   N   -->
        <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
            <div class="container"><a class="navbar-brand logo" href="<?= route('home') ?>">{{$brand_name}}</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('male')?>">male</a></li>
                        <li class="nav-item nav-category-seperator-margin" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('female')?>">female</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('liked_items')?>"><i class="fas fa-heart nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">likes</p></a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('shopping_cart')?>"><i class="fas fa-shopping-bag nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">cart</p></a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('account')?>"><i class="fa fa-user nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">login</p></a></li>
                    </ul>
                </div>
                <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
                    <div class="container"><a class="navbar-brand logo" href="<?= route('home') ?>">{{$brand_name}}</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navcol-1">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('male')?>">male</a></li>
                                <li class="nav-item nav-category-seperator-margin" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('female')?>">female</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('liked_items')?>"><i class="fas fa-heart nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">likes</p></a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('shopping_cart')?>"><i class="fas fa-shopping-bag nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">cart</p></a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-icon-big" href="<?= route('account')?>"><i class="fa fa-user nav-icon-hide nav-icon-lg-show"></i><p class="nav-text-lg-hide m-0 p-0">login</p></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </nav>

        <!-- C  O   N   T   E   N   T   -->
        @yield('content')

        <!-- F  O   O   T   E   R   -->
        <footer class="page-footer dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <h5>Get started</h5>
                        <ul>
                            <li><a href="<?= route('home') ?>">Home</a></li>
                            <li><a href="<?= route('register') ?>">Register</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h5>About us</h5>
                        <ul>
                            <li><a href="<?= route('about_us') ?>">Company Information</a></li>
                            <li><a href="<?= route('about_us') ?>">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h5>Support</h5>
                        <ul>
                            <li><a href="<?= route('help') ?>">FAQ</a></li>
                            <li><a href="<?= route('help') ?>">Help desk</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h5>Legal</h5>
                        <ul>
                            <li><a href="<?= route('terms_and_policy') ?>">Terms of Service</a></li>
                            <li><a href="<?= route('terms_and_policy') ?>">Terms of Use</a></li>
                            <li><a href="<?= route('terms_and_policy') ?>">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <p>&copy; {{$copyright_year}} {{$brand_name}}</p>
                <p>Powered by {{$powered_by}}</p>
            </div>
        </footer>
        
        
        <script src="<?= asset('assets/js/smoothproducts.min.js')?>"></script>
        <script src="<?= asset('assets/js/theme.js')?>"></script>
        <script src="<?= asset('assets/js/baguetteBox.min.js')?>"></script>

        <!-- MY JS SCRIPT -->
        <script src="<?= asset('assets/js/misc.js')?>"></script>

        @yield('below-footer')

    </body>

</html>