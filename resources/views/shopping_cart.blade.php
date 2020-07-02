<?php 
use App\Product;

//import my miscellaneous functions
require_once(storage_path('misc/my_functions.php'));
use Storage\Misc\Functions as MiscFunctions;

$page_name= "Shopping Cart";

// INITIALIZE COSTS
$subtotal= 0;
$discount= 0;
$shipping= 0;

?>

@extends('layouts.master')

@section('content')

<main class="page shopping-cart-page">
    <section class="clean-block clean-cart dark">
        <div class="container">
            <div class="mt-4">
                <h2 class="text-center text-info section-heading"><?= $page_name ?></h2>
            </div>

            @if (session('update'))
                <div class="alert alert-success" role="alert">
                    {{ session('update') }}
                    <?php
                    // FORGET SESSION "update" after displaying it
                    session()->forget('update');
                    ?>
                </div>
            @endif

            <div class="content">
                <div class="row no-gutters d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="items">

                            <?php
                                if(count($cart_items) == 0){
                                    echo "You do not have any item in your cart.";
                                }
                            ?>

                            @foreach ($cart_items as $item)
                            <?php 
                                // Get Product
                                $product= Product::find($item->id);
                            ?> 

                            <div class="product mb-5">
                                @if ($product == null)
                                    <span class="text-danger small" role="alert">
                                        Sorry, this product is no longer available. It will now be removed from your Shopping Cart.
                                        <?php
                                            $new_shopping_cart= MiscFunctions\removeProductFromList(Auth::guard('web')->user()->shopping_cart, $product_id);
                                            // Check for success
                                            if($new_shopping_cart != null){

                                                // Update liked items in database
                                                Auth::guard('web')->user()->shopping_cart= $new_shopping_cart;

                                                // Set session to indicate update
                                                $request->session()->put('update', "Item removed.");

                                            }
                                            else{
                                                throw new Exception("Error Updating Cart", 1);
                                            }
                                        ?>
                                    </span>
                                @else
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image">
                                                <img class="img-fluid d-block mx-auto image" src="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="text-secondary product-name" href=""><?= $product->name ?></a>
                                            <div class="product-specs" data-product-id="<?= $product->id ?>">
                                                <div class="mb-1"><span>Brand:&nbsp;</span><span class="value"><?= $product->brand ?></span></div>
                                                <div class="mb-1"><span>Size:&nbsp;</span><span class="value" id="<?= $product->id ?>-size"><?= $item->size ?></span></div>
                                                <button class="btn btn-danger btn-sm text-center border rounded-0" type="button" onclick="ProdListMan.removeProductFromCart(this)">&nbsp;<i class="fas fa-trash-alt"></i></button></div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity" data-product-id="<?= $product->id ?>">
                                            <label class="d-none d-md-block" for="quantity">Quantity</label>
                                            <input type="number" id="<?= $product->id ?>-quantity" class="form-control quantity-input cart-quantity-input" value="<?= $item->quantity ?>" onchange="ProdListMan.editCartQty(this)"></div>
                                        <div class="col-6 col-md-2 price" style="font-size: 18px;"><span id="<?= $product->id ?>-price" >&#x20A6;<?= $product->price * $item->quantity ?></span></div>
                                        
                                        <?php
                                            // ACCUMULATE SUB TOTAL
                                            $subtotal= $subtotal + ($product->price * $item->quantity);
                                        ?>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="summary">
                            <h3>Summary</h3>
                            <h4><span class="text text-danger text-invalid-qty"></span></h4>
                            <h4><span class="text">Subtotal</span><span class="price total-price">&#x20A6;<?= $subtotal ?></span></h4>
                            <h4><span class="text">Discount</span><span class="price total-price">&#x20A6;<?= $discount ?></span></h4>
                            <h4><span class="text">Shipping</span><span class="price total-price">&#x20A6;<?= $shipping ?></span></h4>
                            <h4><span class="text">Total</span><span class="price total-price">&#x20A6;<?= $subtotal - $discount + $shipping ?></span></h4>
                            <button class="btn btn-info btn-block btn-lg border rounded-0" type="button">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@section('below-footer')
<script>

    // Clean URL
    URLMan.cleanQuery();
    
</script>
@endsection
    