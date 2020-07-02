/**
 * THIS SCRIPT INITIALIZES OBJECTS TO BE USED IN OTHER PARTS OF THE PAGE
 */

/* =============================================================================================== */
// CLEAN OFF QUERY STRING FROM URL
const URLMan = new Object();

URLMan.cleanQuery = () => {

    // Get current URL
    curr_loc = window.location.href;
    // Remove query string
    new_loc = curr_loc.split("?")[0];
    // Update address bar
    window.history.replaceState(null, document.title, new_loc);

};



/* =============================================================================================== */
// PRODUCT LIST MANIPULATION FUNCTIONS
const ProdListMan = new Object();

/* C    A   R   T */

/**
 * Adds the specified product to cart 
 * @param product 
 * @param from_liked_items
 */
ProdListMan.addProductToCart = (product, from_liked_items) => {

    // Sanity Check
    if (product.parentElement.hasAttribute('data-product-id')) {

        // Get product ID
        const prod_id = product.parentElement.getAttribute("data-product-id");

        // Get product size
        const prod_size = document.getElementById(prod_id + "-size").innerHTML;

        // Get quantity
        const prod_qty = parseInt(
            document.getElementById(prod_id + "-quantity").value ? 
                document.getElementById(prod_id + "-quantity").value : 
                document.getElementById(prod_id + "-quantity").innerHTML
            );

        // Make new page request
        let url_string = "/shopping_cart" + "?id=" + prod_id
            + "&size=" + prod_size + "&quantity=" + prod_qty
            //If request is from liked items
            + ( from_liked_items ? "&liked_items=true": "");

        // Update current page using AJAX
        // In the case of Liked Items, the item to be added to cart is removed, incase the user clicks on the browser back button
        if(from_liked_items){
            $("main").load(window.location.href + " main");
        }

        // Make request to shopping cart page
        window.location.assign(url_string);


    }

};

/**
 * Removes specified product from Cart
 * @param product 
 */
ProdListMan.removeProductFromCart = (product) => {

    // Sanity Check
    if (product.parentElement.hasAttribute('data-product-id')) {

        // Get product ID
        const prod_id = product.parentElement.getAttribute("data-product-id");

        // Make new page request
        let url_string = window.location.href + "?id=" + prod_id + "&remove=true";
        // window.location.assign(url_string);

        // AJAX Load new content
        $("main").load(url_string + " main");

    }

};


/**
 * Edits product quantity in cart
 */
ProdListMan.editCartQty = (qty_input) => {

    // Validation
    if ((qty_input.value < 1) || (qty_input.value > 5)) {
        // Add red border
        qty_input.setAttribute("class", qty_input.getAttribute("class") + "border border-danger");

        // Get product ID
        const prod_id = qty_input.parentElement.getAttribute("data-product-id");

        // Set price to "-"
        const prod_price = document.getElementById(prod_id + "-price");
        prod_price.innerHTML = "&#x20A6;-";

        // Set all total prices to "-"
        $(".total-price").html("&#x20A6;-");

        // Display valid quantity message
        $(".text-invalid-qty").html("Please select a valid quantity for each item (at least 1).");
    }
    else {
        // Remove red border if present
        if (qty_input.getAttribute("class").indexOf("border border-danger") > 0) {
            qty_input.setAttribute("class", qty_input.getAttribute("class").replace("border border-danger", ""));
        }

        // Perform quantity change
        // Get product ID
        const prod_id = qty_input.parentElement.getAttribute("data-product-id");
        // Make new page request
        let url_string = window.location.href + "?id=" + prod_id + "&quantity=" + qty_input.value;
        
        // AJAX Load new content
        $("main").load(url_string + " main");
    }
};


/* L    I   K   E   D       I   T   E   M   S */

/**
 * Adds the specified product to liked items 
 * @param product 
 */
ProdListMan.addProductToLikedItems = (product) => {

    // Sanity Check
    if (product.parentElement.hasAttribute('data-product-id')) {

        // Get product ID
        const prod_id = product.parentElement.getAttribute("data-product-id");

        // Get product size
        const prod_size = document.getElementById(prod_id + "-size").innerHTML.trim();

        // Make new page request
        let url_string = "/liked_items" + "?id=" + prod_id
            + "&size=" + prod_size;

        // Make request to shopping cart page
        window.location.assign(url_string);


    }

};

/**
 * Removes specified product from Liked Items
 * @param product 
 */
ProdListMan.removeProductFromLikedItems = (product) => {

    // Sanity Check
    if (product.parentElement.hasAttribute('data-product-id')) {

        // Get product ID
        const prod_id = product.parentElement.getAttribute("data-product-id");

        // Make new page request
        let url_string = window.location.href + "?id=" + prod_id + "&remove=true";
        // window.location.assign(url_string);

        // AJAX Load new content
        $("main").load(url_string + " main");

    }

};


/* =============================================================================================== */
/* P    R   O   D   U   C   T       F   I   L   T   E   R */

ProdFilter= Object();


/**
 * Load category list by performing an AJAX call to the server
 * and constructing the obtained categories as formatted HTML
 */
ProdFilter.loadCatList= ()=>{

    // MALE CATEGORIES
    $.getJSON("\\male_categories", function(data){

        data= Object.values(data);
        data.sort();
    
        let male_cats= [];
    
        $.each(data, function(key, value){
            male_cats.push( 
                `<div class="form-check">
                <input class="form-check-input" type="checkbox" data-id="${value}" id="${value}-category" onchange="ProdFilter.updateProducts()"></input> 
                <label class="form-check-label" for="${value}-category">${value}</label>
                </div>`
             );
        });
    
        ProdFilter.male_cats= male_cats.join("");
        

        // LOAD FEMALE CATEGORIES AFTER LOADING MALE
        // This is done so that ProdFilter.refresh() can be called only once after both categories must have been loaded
        $.getJSON("\\female_categories", function(data){

            data= Object.values(data);
            data.sort();
        
            let female_cats= [];
        
            $.each(data, function(key, value){
                female_cats.push( 
                    `<div class="form-check">
                    <input class="form-check-input" type="checkbox" data-id="${value}" id="${value}-category" onchange="ProdFilter.updateProducts()"></input> 
                    <label class="form-check-label" for="${value}-category">${value}</label>
                    </div>`
                );
            });
        
            ProdFilter.female_cats= female_cats.join("");

            // Refresh Lists
            if(ProdFilter.refresh != null){
                ProdFilter.refresh();
            }
        
        });   

    });

};


/**
 * Update category list
 * @param data 
 */
ProdFilter.updateCatList= (data)=> { 
    $(".category-filter").html( "<h3>Category</h3>" + data); 
    // MARK SELECTED CATEGORIES
    ProdFilter.selectCatFromQuery(ProdFilter.selectedCatFromRoute.category);
};

/**
 * Update products displayed according to selected categories.
 * If no category is selected, display all products.
 * 
 * @return HTML into <div class="products-holder">
 */
ProdFilter.updateProducts= ()=>{

    // Reset Selected Categories
    ProdFilter.selectedCat= [];

    /**
     * Finding selected categories has to be implemented differently for small 
     * devices and large devices because of the way the ".category-filter" <div>
     * is implemented
     */

    // Find selected categories for devices with screen width < 768px
    if(screen.width < 768){
        $(".category-filter-sm").find("input").each((index, element)=>{
            // console.log(element.getAttribute("data-id"));
            // ProdFilter.gender is set from PHP
            if( element.checked === true ){
                // Push selected categories to array
                ProdFilter.selectedCat.push(element.getAttribute("data-id"));
            }
        });
    }

    // Find selected categories for devices with screen width >= 768px
    else{
        $(".category-filter-md").find("input").each((index, element)=>{
            // console.log(element.getAttribute("data-id"));
            // ProdFilter.gender is set from PHP
            if( element.checked === true ){
                // Push selected categories to array
                ProdFilter.selectedCat.push(element.getAttribute("data-id"));
            }
        });
    }

    // Remove duplicates
    // ProdFilter.selectedCat= new Set(ProdFilter.selectedCat);
    
    // If at least 1 category is selected, update products list
    // Otherwise, do nothing
    if(ProdFilter.selectedCat.length > 0){
        // Build URL by appending selected categories as an array in the query string
        url_string="\\"+ProdFilter.gender+"?";
        // Loop through selected categories
        ProdFilter.selectedCat.forEach( (item, index)=>{
            if(index != 0){
                url_string= url_string + "&";
            }
            url_string= url_string + "category[]=" + encodeURIComponent(item);
        });

        // Add page to history
        window.history.pushState(null, null, url_string);
        // AJAX Load new content
        $(".products-holder").load(url_string + " .products-holder");

    }
    // If no category is selected, load all products
    else{

        url_string= "\\" + ProdFilter.gender;

        // Add page to history
        window.history.pushState(null, null, url_string);
        // AJAX Load new content
        $(".products-holder").load(url_string + " .products-holder");

    }

}


/**
 * Listens for orientationchange event and updates displayed products appropriately
 * 
 * This is a FIX such that products displayed can always matched the selected categories.
 * 
 * Note that this may cause the categories of products displayed in landscape to be different from 
 * those diaplayed in portrait on some devices if different cetegories are selected in ".category-filter-sm" 
 * and ".category-filter-md"
 */
window.addEventListener("orientationchange", function(event) {
    ProdFilter.updateProducts();
  });


/**
 * Selects active category from data passed from PHP
 * 
 */
ProdFilter.selectCatFromQuery= (selected_cats)=>{

    // Iterate through checked categories
    if(selected_cats){

        selected_cats.forEach( (selected_cat)=>{

            /**
            * Finding selected categories has to be implemented differently for small 
            * devices and large devices because of the way the ".category-filter" <div>
            * is implemented
            */

            // Find selected categories for devices with screen width < 768px
            if(screen.width < 768){

                // Check for corresponding category checkbox and check it
                $(".category-filter-sm").find("input").each((index, cat_checkbox)=>{

                    if( cat_checkbox.getAttribute("data-id") == selected_cat){
                        // Check checkbox
                        cat_checkbox.checked= true;
                    }
                });
            }

            // For devices with screen width >= 768px
            else{
                // Check for corresponding category checkbox and check it
                $(".category-filter-md").find("input").each((index, cat_checkbox)=>{

                    if( cat_checkbox.getAttribute("data-id") == selected_cat){
                        // Check checkbox
                        cat_checkbox.checked= true;
                    }
                });
            }

        } );
    }

};


/* =============================================================================================== */
/* P    R   O   D   U   C   T       O   P   T   I   O   N   S */
ProdOptions= new Object();


/**
 * This function loads the size and quantity corresponding to the selected size
 * @param {array} options
 * @return HTML into "#product-id-quantity-div" and "#product-id-size"
 */
ProdOptions.setSizeLoadQty= (option)=>{
    
    size= option[0];
    qty= parseInt(option[1]);

    // Load Quantity
    const prod_qty_div= document.getElementById(ProdOptions.prod_id + "-quantity-div");

    // Clean Up
    prod_qty_div.innerHTML= "";

    // Loop through sizes
    for(idx=1; idx <= qty; idx++){
        prod_qty_div.innerHTML= prod_qty_div.innerHTML + 
        `<a class="dropdown-item" role="presentation" onclick="ProdOptions.setQty(${idx})">${idx}</a>`
        ;

    }

    // Reset selected quantity
    document.getElementById(ProdOptions.prod_id + "-quantity").innerHTML= "Quantity";

    // Set Size
    const prod_size= document.getElementById(ProdOptions.prod_id + "-size");
    prod_size.innerHTML= size;

};


/**
 * This function loads selected quantity
 * @param {int} quantity
 * @return HTML into "#product-id-quantity"
 */
ProdOptions.setQty= (qty)=>{

    qty= parseInt(qty);

    // Set Quantity
    const prod_qty= document.getElementById(ProdOptions.prod_id + "-quantity");
    prod_qty.innerHTML= qty;

};

/**
 * Verifies that a size and a valid quantity have been selected then performs requested action
 * @param {button} selected_button
 * @param {string} action
 */
ProdOptions.validate= (selected_button, action)=>{
    
    is_valid= true;

    // Validate Size
    const prod_size= document.getElementById(ProdOptions.prod_id + "-size");
    let size_string= prod_size.innerHTML.trim();
    if(size_string == "Size"){
        $(prod_size).addClass("border-danger");
        is_valid= false;
    }
    else{
        $(prod_size).removeClass("border-danger");
    }


    // Perform specified action
    if(is_valid){

        if(action == 'liked_items'){
            ProdListMan.addProductToLikedItems(selected_button);
        }

        if(action == 'shopping_cart'){

            // Validate Quantity
            const prod_qty= document.getElementById(ProdOptions.prod_id + "-quantity");
            let qty_string= prod_qty.innerHTML.trim();
            if(qty_string == "Quantity"){
                $(prod_qty).addClass("border-danger");
                is_valid= false;
            }
            else{
                $(prod_qty).removeClass("border-danger");
            }

            if(is_valid){
                ProdListMan.addProductToCart(selected_button, false);
            }
            else{
                alert("Please select a valid quantity");
            }
        }

    }else{
        alert("Please select a valid size");
    }
    
}