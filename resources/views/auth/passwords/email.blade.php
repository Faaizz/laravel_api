<?php $page_name= "Reset Password" ?>

@extends('layouts.master')

@section('content')

        <!-- C  O   N   T   E   N   T   -->
        <main class="page login-page">
            <section class="clean-block clean-form dark">
                <div class="container">
                    <div class="mt-4">
                        <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="<?= route('password.email') ?>">
                        {{-- CSRF PROTECTION --}}
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="border rounded-0 form-control item @error('email') border-danger @enderror" 
                                type="email" id="email" name="email" required autocomplete="email" value="{{old('email')}}">
                            
                                @error('email')
                                <span class="text-danger small" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        
                        <button class="btn btn-info btn-block border rounded-0" type="submit">Send Password Reset Link</button>
                            
                    </form>
                </div>
            </section>
        </main>

@endsection