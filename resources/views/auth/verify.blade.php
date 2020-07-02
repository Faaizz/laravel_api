<?php $page_name= "Verify Account"  ?>

@extends('layouts.master')

@section('content')

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="mt-4">
                    <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
                </div>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                Before proceeding, please check your email for a verification link.
                If you did not receive the email, <a class="text-info" href="{{ route('verification.resend') }}">click here to request another</a>.
       
            </div>
        </section>
    </main>

@endsection