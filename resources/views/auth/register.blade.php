<?php $page_name= "Registration"  ?>

@extends('layouts.master')

@section('content')

    <main class="page registration-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="mt-4">
                    <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    {{-- CSRF PROTECTION --}}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input class="border rounded-0 form-control item @error('first_name') border-danger @enderror" 
                            type="text" id="first_name" name="first_name"  autocomplete="given-name" value="{{old('first_name')}}">
                        @error('first_name')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input class="border rounded-0 form-control item @error('last_name') border-danger @enderror" 
                            type="text" id="last_name" name="last_name" required autocomplete="family-name" value="{{old('last_name')}}">
                        @error('last_name')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="border rounded-0 form-control" id="gender" name="gender">
                            <option value="" selected="">-</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
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
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="border rounded-0 form-control @error('address') border-danger @enderror" 
                            id="address" name="address" required autocomplete="street-address">{{old('address')}}</textarea>
                        @error('address')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone_numbers">Phone Number</label>
                        <input class="border rounded-0 form-control @error('phone_numbers') border-danger @enderror" type="tel" 
                            id="phone_numbers" name="phone_numbers" placeholder="e.g. 08011100011" required autocomplete="mobile" value="{{old('phone_numbers')}}">
                        @error('phone_numbers')
                            <span class="text-danger small" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-info btn-block border rounded-0" type="submit">Sign Up</button>
                </form>
            </div>
        </section>
    </main>

@endsection