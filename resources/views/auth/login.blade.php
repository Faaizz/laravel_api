<?php $page_name= "Login"  ?>

@extends('layouts.master')

@section('content')

    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="mt-4">
                    <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
                </div>
                <form method="POST" action="<?= route('login') ?>">
                    {{-- CSRF PROTECTION --}}
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="border rounded-0 form-control item" type="email" id="email" name="email" required autocomplete="email" >
                        @error('email')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="border rounded-0 form-control" type="password" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="remember-me" name="remember-me"><label class="form-check-label" for="remember-me">Remember me</label></div>
                    </div>
                    
                    <button class="btn btn-info btn-block border rounded-0" type="submit">Log In</button>
                    
                    <a href="<?= route('register') ?>" class="btn btn-light btn-block border rounded-0 border-info" type="button">
                        Register<br>
                    </a>

                    @if (Route::has('password.request'))
                        <a href="<?= route('password.request') ?>" class="btn btn-light btn-block border rounded-0 border-info" type="button">
                            Forgot Your Password<br>
                        </a>
                    @endif

                </form>
            </div>
        </section>
    </main>

@endsection