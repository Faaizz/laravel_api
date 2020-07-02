<?php 
use App\Product;
use Illuminate\Support\Facades\Auth;

$page_name= "My Details" 

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
                                <a href="<?= route("details") ?>" class="btn btn-secondary border rounded-0" type="button" style="font-size: 14px;">
                                    My Details<br>
                                </a>
                                <a href="<?= route("password_change") ?>" class="btn btn-light border rounded-0" type="button" style="font-size: 14px;">
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
                        <form class="account-options" method="POST" action="<?= route('edit_details') ?>" >
                            {{-- CSRF PROTECTION --}}
                            @csrf
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input class="border rounded-0 form-control item" type="text" id="first_name" name="first_name" 
                                    value="<?= Auth::guard("web")->user()->first_name ?>"
                                >
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input class="border rounded-0 form-control item" type="text" id="last_name" name="last_name" 
                                value="<?= Auth::guard("web")->user()->last_name ?>"
                                >
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="border rounded-0 form-control" id="address" for="address" name="address"><?= \trim(Auth::guard("web")->user()->address) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input class="border rounded-0 form-control" type="tel" id="phone_number" name="phone_number"
                                value="<?= \intval(\json_decode(Auth::guard("web")->user()->phone_numbers)[0]) ?>"
                                >
                            </div>
                            <button class="btn btn-info btn-block border rounded-0" type="submit">Update</button>
                        </form>
                    
                    </div>
                </div>
            </div>
                                
        </div>
    </section>
</main>

@endsection