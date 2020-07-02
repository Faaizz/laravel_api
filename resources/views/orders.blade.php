<?php 
use App\Product;

$page_name= "My Orders" 

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
                            <div>
                                <div class="btn-group-vertical w-100 account-options" role="group">
                                    <a href="<?= route("account") ?>" class="btn btn-secondary border rounded-0" type="link" style="font-size: 14px;">
                                        My Orders<br>
                                    </a>
                                    <a href="<?= route("details") ?>" class="btn btn-light border rounded-0" type="button" style="font-size: 14px;">
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
                    </div>
                    <div class="col col-12 col-lg-9">
                        <div class="products">
                            <div class="row no-gutters">

                                @if(count($orders) == 0)

                                <div class="block-heading w-100 text-body">
                                    <p>You do not have any orders yet...</p>
                                </div>

                                @endif

                                @foreach ($orders as $order)

                                <?php
                                // Get product
                                $product= Product::find($order->product_id);
                                ?>

                                @if ($product == null)
                                <span class="text-danger small" role="alert">
                                    Sorry, this product is no longer available. Your order cannot be completed. Please contact us.
                                </span>

                                @else
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="clean-product-item">
                                        <div class="image"><img class="img-fluid d-block mx-auto" src="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>"></div>
                                        <div class="product-name small">
                                            <p class="m-0">Product Name: <strong><?= $product->name ?></strong></p>
                                            <p class="m-0">Quantity: <strong><?= $order->product_quantity ?></strong></p>
                                            <p class="m-0">Size: <strong><?= $order->product_size ?></strong></p>
                                            <p class="m-0">Order Date: <strong><?= $order->created_at ?></strong></p>
                                            <p class="m-0">Delivery Status: <strong><?= $order->status ?></strong></p>
                                            <?php

                                                if(\strcmp($order->status, "failed") == 0){
                                                    echo "<p class='m-0'>Failure Cause: <strong>" . $order->failure_cause ."</strong> </p>";
                                                    echo "<p class='m-0'>Failure Date: <strong>" . $order->failure_date ."</strong> </p>";
                                                }

                                            ?>
                                            <p class="m-0">Est Del Date: <strong><?= $order->est_del_date ?></strong></p>
                                        </div>
                                        <div class="d-lg-flex justify-content-lg-end about">
                                            <div class="price">
                                                <h3><strong>&#x20A6;<?= $order->product_quantity*$product->price ?></strong></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                
        </div>
    </section>
</main>

@endsection