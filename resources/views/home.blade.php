<?php
// NUMBER OF TRENDS TO DISPLAY
$max_trends= 9;
?>

@extends('layouts.master')

@section('content')

<main class="page landing-page">
    <section class="clean-block clean-hero" style="background-image:url(&quot;assets/img/trends/xl-1258x600.jpeg&quot;);background-position:center;color:rgba(255, 255, 255, 0.1);">
        <div class="text p-2 text-dark main-featured-div-background">
            <h2>Lorem ipsum dolor sit amet.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis vitae leo.</p>
            <div class="btn-group" role="group">
                <button class="btn btn-light btn-lg border rounded-0 border-dark bg-transparent" type="button"><a href="<?= route('male')?>">Male</a><br></button>
                <button class="btn btn-light btn-lg border rounded-0 border-dark bg-transparent" type="button"><a href="<?= route('female')?>">Female</a></button>
            </div>
        </div>
    </section>

    <!-- T  R   E   N   D   I   N   G   -->
    <section class="clean-block trending">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info section-heading">Trending</h2>
            </div>
            <div class="row  justify-content-center">

                @foreach ($trending as $trend)
                    {{-- LIMIT NUMBER OF TRENDS TO A PRE-SPECIFIED MAXIMUM --}}
                    @if($loop->index < $max_trends)
                        <div class="col-sm-6 col-lg-4 mb-2">
                            <div class="card clean-card text-center h-100"><img class="card-img-top w-100 d-block" src="<?php echo url("/storage/".\json_decode($trend->images)[0]) ?>">
                                <div class="card-body info">
                                    <h4 class="card-title"><?= $trend->name ?></h4>
                                    <p class="card-text"><?= $trend->description ?></p>
                                    <div class="icons"><button class="btn btn-light btn-lg border rounded-0 border-dark bg-transparent" type="button">Shop Now</button></div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
</main>

@endsection