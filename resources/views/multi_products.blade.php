<?php 
use App\Product;

//import my miscellaneous functions
require_once(storage_path('misc/my_functions.php'));
use Storage\Misc\Functions as MiscFunctions;

// If $query_string is not set, default to empty string
if(!isset($query_string)){
    $query_string= "";
}

?>

@extends('layouts.master')

@section('content')

<main class="page catalog-page">
    <section class="clean-block clean-catalog dark">
        <div class="container">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?= route("home") ?>"><span>Home</span></a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="<?= route($page_route) ?>"><span><?= $page_route ?></span></a></li>
            </ol>
            <div class="mt-3">
                <h2 class="text-center text-secondary section-heading"><?= $page_name ?></h2>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-none d-md-block">
                            <div class="filters">
                                <div class="filter-item category-filter category-filter-md">
                                    
                                </div>
                                {{-- <div class="filter-item size-filter">
                                    
                                </div> --}}
                            </div>
                        </div>
                        <div class="d-md-none"><a class="btn btn-link d-md-none filter-collapse" data-toggle="collapse" aria-expanded="false" aria-controls="filters" href="#filters" role="button">Filters<i class="icon-arrow-down filter-caret"></i></a>
                            <div class="collapse"
                                id="filters">
                                <div class="filters">
                                    <div class="filter-item category-filter category-filter-sm">
                                        
                                    </div>
                                    {{-- <div class="filter-item size-filter">
                                        
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="products products-holder">

                            <script>
                                // Transfer selected categories from query string to javascript as a json object.
                                // Categories are encoded as an array under object property "category"
                                ProdFilter.selectedCatFromRoute= <?= \json_encode( $query_string ) ?>;
                            </script>

                            <div class="row no-gutters">
                            
                            @foreach($products as $product)

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="clean-product-item">
                                        <div class="image"><a href="<?= url("/products/" . $product->id) ?>"><img class="img-fluid d-block mx-auto" src="<?php echo url("/storage/".\json_decode($product->images)[0]) ?>"></a></div>
                                        <div class="product-name small"><a href="<?= url("/products/" . $product->id) ?>"><?= $product->name ?></a></div>
                                        <div class="d-lg-flex justify-content-lg-end about">
                                            <div class="price">
                                                <h6>&#x20A6;<?= $product->price ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            @endforeach

                            </div>
                            <nav>
                                {{$products->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection

@section("below-footer")

<!-- LOAD CATEGORIES -->
<script>  

    //Load list of categories
    ProdFilter.loadCatList();

    ProdFilter.refresh= ()=>{        
        // Display category list on page
        // Echo $page_route from PHP
        ProdFilter.updateCatList(ProdFilter.<?= $page_route ?>_cats);
    };

    // Set Gender to be used in updating products
    // Echo $page_route from PHP
    ProdFilter.gender= "<?= $page_route  ?>";

</script>

@endsection