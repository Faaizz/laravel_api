<?php 
use App\Product;

//import my miscellaneous functions
require_once(storage_path('misc/my_functions.php'));
use Storage\Misc\Functions as MiscFunctions;

// Make options into a collection
$options_collection= collect($product->options);
$options_array= \json_decode($product->options, true);

?>

@extends('layouts.master')

@section('content')

<main class="page product-page">
    <section class="clean-block clean-product dark">
        <div class="container">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?= route("home") ?>"><span>Home</span></a></li>                   
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?= url("/". $product->sub_section . "?category[]=" . \urlencode($product->category)) ?>"><span><?= $product->category ?></span></a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?= route($product->sub_section) ?>"><span><?= $product->sub_section ?></span></a></li>
            </ol>
            <div class="mt-4">
                <h4 class="text-center text-secondary section-heading"><?= $product->name ?></h4>
            </div>
            <div class="block-content">
                <div class="product-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="gallery">
                                <div class="sp-wrap">
                                    <a href="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>">
                                        <img class="img-fluid d-block mx-auto" src="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>">
                                    </a>
                                    <a href="<?php echo url("/storage/".\json_decode($product->images)[1]) ?>">
                                        <img class="img-fluid d-block mx-auto" src="<?php echo url("/storage/".\json_decode($product->images)[1]) ?>">
                                    </a>
                                    <a href="<?php echo url("/storage/".\json_decode($product->images)[2]) ?>">
                                        <img class="img-fluid d-block mx-auto" src="<?php echo url("/storage/".\json_decode($product->images)[2]) ?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <h6 class="pt-2"><?= $product->brand ?></h6>
                                <div class="price">
                                    <h4>&#x20A6;<?= $product->price ?></h4>
                                </div>                                
                                <div class="container">
                                    <div class="row">
                                        <div class="col d-xl-flex justify-content-xl-start p-0">
                                            <div class="dropdown">
                                                <button id="<?= $product->id ?>-size" class="btn btn-secondary btn-sm dropdown-toggle text-secondary border rounded-0 border-secondary bg-transparent" data-toggle="dropdown" aria-expanded="false" type="button">
                                                    Size
                                                </button>
                                                <div class="dropdown-menu small-dropdown" role="menu">

                                                    <?php
                                                    foreach($options_array as $option){
                                                        $size= $option["size"];
                                                        $qty= $option["quantity"];
                                                        echo "<a class=\"dropdown-item\" role=\"presentation\" style=\"cursor: pointer\" onclick=\"ProdOptions.setSizeLoadQty(['$size', $qty])\">$size</a>";                                              
                                                    }
                                                    ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-xl-flex justify-content-xl-start p-0">
                                            <div class="dropdown">
                                                <button id="<?= $product->id ?>-quantity" class="btn btn-secondary btn-sm dropdown-toggle text-secondary border rounded-0 border-secondary bg-transparent" data-toggle="dropdown" aria-expanded="false">
                                                    Quantity
                                                </button>
                                                <div id="<?= $product->id ?>-quantity-div" class="dropdown-menu small-dropdown quantity-dropdown" role="menu">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" data-product-id="<?= $product->id ?>">
                                        <button class="btn btn-light border rounded-0" type="button" onclick="ProdOptions.validate(this, 'liked_items')">
                                            <i class="icon-heart"></i>
                                            Like
                                        </button>
                                        <button class="btn btn-warning border rounded-0" type="button" onclick="ProdOptions.validate(this, 'shopping_cart')">
                                            <i class="icon-handbag"></i>
                                            Add to Cart
                                        </button>
                                    </div>
                                    <div class="summary">
                                        <p><?= $product->description ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@section('below-footer')
{{-- Send sizes and corresponding quantities to Javascript --}}
<script>
    ProdOptions.options= <?= $product->options ?>;
    ProdOptions.prod_id= <?= $product->id ?>;
</script>

@endsection