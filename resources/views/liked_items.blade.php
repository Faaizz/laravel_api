<?php 
use App\Product;

//import my miscellaneous functions
require_once(storage_path('misc/my_functions.php'));
use Storage\Misc\Functions as MiscFunctions;

$page_name= "Liked Items" 

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
                        <div class="items liked-items">

                            <?php
                                if(count($liked_items) == 0){
                                    echo "You have not liked any item.";
                                }
                            ?>

                            @foreach ($liked_items as $item)
                            <?php 
                                // Get Product
                                $product= Product::find($item->id);
                            ?>

                            <div class="product mb-5">
                                @if ($product == null)
                                    <span class="text-danger small" role="alert">
                                        Sorry, this product is no longer available. It will now be removed from your Liked Items.
                                        <?php
                                            // REMOVE PRODUCT FROM LIST
                                            $new_liked_items= MiscFunctions\removeProductFromList(Auth::guard('web')->user()->liked_items, $$item->id);
                                            // Check for success
                                            if($new_liked_items != null){

                                                // Update liked items in database
                                                Auth::guard('web')->user()->liked_items= $new_liked_items;
                                                Auth::guard('web')->user()->save();

                                                // Set session to indicate update
                                                $request->session()->put('update', "Item removed.");

                                            }
                                            else {
                                                throw new Exception("Error Updating Liked Items", 1);
                                            }
                                        ?>
                                    </span>
                                @else
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="text-secondary product-name" href=""><?= $product->name ?></a>
                                            <div class="product-specs">
                                                <div class="mb-1"><span>Brand:&nbsp;</span><span class="value"><?= $product->brand ?></span></div>
                                                <div class="mb-1"><span>Size:&nbsp;</span><span class="value" id="<?= $product->id ?>-size"><?= $item->size ?></span></div>
                                            </div>
                                        </div>
                                        <div class="col-auto col-md-2 quantity">
                                            <label class="d-none d-md-block" for="<?= $product->id ?>-quantity">Quantity</label>
                                            <input type="number" id="<?= $product->id ?>-quantity" class="form-control quantity-input" value="1">
                                        </div>
                                    </div>
                                    <div class="text-center pt-2" data-product-id="<?= $product->id ?>">
                                        <button class="btn btn-warning text-center border rounded-0" type="button" onclick="ProdListMan.addProductToCart(this, true)">Move To Cart</button>
                                        <button class="btn btn-danger text-center border rounded-0" type="button" onclick="ProdListMan.removeProductFromLikedItems(this)">Delete</button>
                                    </div>
                                @endif
                            </div>
                            @endforeach
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
    