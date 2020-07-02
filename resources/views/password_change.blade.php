<?php 
use App\Product;
use Illuminate\Support\Facades\Auth;

$page_name= "Change Password" 

?>

@extends('layouts.master')

@section('content')

<main class="page catalog-page">
    <section class="clean-block clean-catalog dark">
        <div class="container">
            <div class="mt-4">
                <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col col-12 col-lg-3">
                        <div class="d-md-block">
                            <div class="btn-group-vertical w-100 account-options" role="group">
                                <a href="<?= route("account") ?>" class="btn btn-light border rounded-0" type="link" style="font-size: 14px;">
                                    My Orders<br>
                                </a>
                                <a href="<?= route("details") ?>" class="btn btn-light border rounded-0" type="button" style="font-size: 14px;">
                                    My Details<br>
                                </a>
                                <a href="<?= route("password_change") ?>" class="btn btn-secondary border rounded-0" type="button" style="font-size: 14px;">
                                    Change Password<br>
                                </a>
                                <a href="<?= route("logout") ?>" class="btn btn-dark text-light border rounded-0" type="button" style="font-size: 14px;">
                                    Logout<br>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-lg-9 p-3">
                        @if (session('update'))
                            <div class="alert alert-info" role="alert">
                                {{ session('update') }}
                                <?php
                                // FORGET SESSION "update" after displaying it
                                session()->forget('update');
                                ?>
                            </div>
                        @endif
                        <form class="account-options" method="POST" action="<?= route('effect_password_change') ?>" >
                            {{-- CSRF PROTECTION --}}
                            @csrf
                            <div class="form-group">
                                <label for="password">Old Password</label>
                                <input class="border rounded-0 form-control item" type="text" id="password" name="password" autocomplete="current-password" required>
                                @error('password')
                                    <span class="text-danger small" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                @if(session('password'))
                                    <span class="text-danger small" role="alert">
                                        {{session('password')}}
                                        <?php
                                        // FORGET SESSION "password" after displaying it
                                        session()->forget('password');
                                        ?>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input class="border rounded-0 form-control item" type="text" id="new_password" name="new_password" autocomplete="new-password" required>
                                @error('new_password')
                                    <span class="text-danger small" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input class="border rounded-0 form-control item" type="text" id="new_password_confirmation" name="new_password_confirmation" autocomplete="new-password" required>
                                @error('new_password_confirmation')
                                    <span class="text-danger small" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-info btn-block border rounded-0" type="submit">Change Password</button>
                        </form>
                    
                    </div>
                </div>
            </div>
                                
        </div>
    </section>
</main>

@endsection