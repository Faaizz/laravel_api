<?php  
    $page_name= "Reset Password" 
?>

@extends('layouts.master')

@section('content')

        <main class="page login-page">
            <section class="clean-block clean-form dark">
                <div class="container">
                    <div class="mt-4">
                        <h2 class="text-center text-info section-heading">Reset Password<?= $page_name ?></h2>
                    </div>

                    <form method="POST" action="<?= route('password.update') ?>">
                        {{-- CSRF PROTECTION --}}
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="border rounded-0 form-control item @error('email') border-danger @enderror" 
                                type="email" id="email" name="email" required autocomplete="email" value="{{ $email ?? old('email') }}" autofocus>
                            @error('email')
                                <span class="text-danger small" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="border rounded-0 form-control item @error('password') border-danger @enderror" 
                                type="password" id="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="text-danger small" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input class="border rounded-0 form-control item" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="text-danger small" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        
                        <button class="btn btn-info btn-block border rounded-0" type="submit">Reset Password</button>
                            
                    </form>
                </div>
            </section>
        </main>

@endsection