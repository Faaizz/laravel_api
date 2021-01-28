<?php

namespace App\Http\Controllers;

use App\Order;
use App\Customer;
use App\Staff;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

//RESOURCES
use App\Http\Resources\OrderCollection;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
  
    /**
     * Returns available endpoints and their descriptions and required arguments
     * 
     * @return JSON JSON formatteed response
     * 
     */
    public function options(){

        return response()->json([
            
            'methods' =>    [

                'OPTIONS',
                'GET',
                'POST',
                'PUT',
                'DELETE'

            ],

            'endpoints' => [

                /* O  P  T  I  O  N  S */

                [
                    'path' => '/',
                    'method' => 'OPTIONS',
                    'description' => 'returns available methods',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => []
                ],

                /* R  E  A  D */

                //All Unassigned Orders
                [
                    'path' => '/unassigned',
                    'method' => 'GET',
                    'description' => 'returns all unassigned orders',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ]
                            ],
                            'links' => [
                                    'first' => 'string',
                                    'last' => 'string',
                                    'prev' => 'string',
                                    'next' => 'string'
                            ],
                            'meta' => [
                                    'current_page' => 'integer',
                                    'from' => 'integer',
                                    'last_page' => 'integer',
                                    'path' => 'string',
                                    'per_page' => 'integer',
                                    'to' => 'integer',
                                    'total' => 'integer'
                            ]
                        ]
                    ]
                ],

                //All Pending Orders
                [
                    'path' => '/pending',
                    'method' => 'GET',
                    'description' => 'returns all pending orders',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ]
                            ],
                            'links' => [
                                    'first' => 'string',
                                    'last' => 'string',
                                    'prev' => 'string',
                                    'next' => 'string'
                            ],
                            'meta' => [
                                    'current_page' => 'integer',
                                    'from' => 'integer',
                                    'last_page' => 'integer',
                                    'path' => 'string',
                                    'per_page' => 'integer',
                                    'to' => 'integer',
                                    'total' => 'integer'
                            ]
                        ]
                    ]
                ],

                //All Delivered Orders
                [
                    'path' => '/delivered',
                    'method' => 'GET',
                    'description' => 'returns all delivered orders',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ]
                            ],
                            'links' => [
                                    'first' => 'string',
                                    'last' => 'string',
                                    'prev' => 'string',
                                    'next' => 'string'
                            ],
                            'meta' => [
                                    'current_page' => 'integer',
                                    'from' => 'integer',
                                    'last_page' => 'integer',
                                    'path' => 'string',
                                    'per_page' => 'integer',
                                    'to' => 'integer',
                                    'total' => 'integer'
                            ]
                        ]
                    ]
                ],

                //All Failed Orders
                [
                    'path' => '/failed',
                    'method' => 'GET',
                    'description' => 'returns all failed orders',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ]
                            ],
                            'links' => [

                                    'first' => 'string',
                                    'last' => 'string',
                                    'prev' => 'string',
                                    'next' => 'string'

                            ],
                            'meta' => [

                                    'current_page' => 'integer',
                                    'from' => 'integer',
                                    'last_page' => 'integer',
                                    'path' => 'string',
                                    'per_page' => 'integer',
                                    'to' => 'integer',
                                    'total' => 'integer'

                            ]
                        ]
                    ]
                ],

                //By Customer
                [
                    'path' => '/customer/{email}',
                    'method' => 'GET',
                    'description' => 'returns all orders belonging to the specified customer',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin | customer'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",
                            'status' => [
                                'required' => false,
                                'description' => 'Order status',
                                'type' => 'string'
                            ],
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'email' => [
                                'required' => true,
                                'description' => 'customer email',
                                'type' => 'string'
                            ]
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'failed_authorization' => [
                            'error' => 'Please login as admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ],
                            ],
                            'links' => [

                                    'first' => 'string',
                                    'last' => 'string',
                                    'prev' => 'string',
                                    'next' => 'string'

                            ],
                            'meta' => [

                                    'current_page' => 'integer',
                                    'from' => 'integer',
                                    'last_page' => 'integer',
                                    'path' => 'string',
                                    'per_page' => 'integer',
                                    'to' => 'integer',
                                    'total' => 'integer'
                                    
                            ]
                        ]
                    ]
                ],

                //By Staff
                [
                    'path' => '/staff/{email}',
                    'method' => 'GET',
                    'description' => 'returns all pending orders assigned to the specified staff',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",

                            'status' => [
                                'required' => false,
                                'description' => 'order status',
                                'type' => 'string'
                            ],
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ]
                        ],

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'email' => [
                                'required' => true,
                                'description' => 'staff email',
                                'type' => 'string'
                            ]
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ],
                            ],
                            'links' => [

                                'first' => 'string',
                                'last' => 'string',
                                'prev' => 'string',
                                'next' => 'string'

                            ],
                            'meta' => [

                                'current_page' => 'integer',
                                'from' => 'integer',
                                'last_page' => 'integer',
                                'path' => 'string',
                                'per_page' => 'integer',
                                'to' => 'integer',
                                'total' => 'integer'
                                    
                            ]
                        ]
                    ]
                ],

                //By Product
                [
                    'path' => '/product/{id}',
                    'method' => 'GET',
                    'description' => 'returns all orders relating to the specified product',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'description' => "Query parameters",

                            'status' => [
                                'required' => false,
                                'description' => 'order status',
                                'type' => 'string'
                            ],
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of products to display per page',
                                'type' => 'integer'
                            ],
                        ],

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'id' => [
                                'required' => true,
                                'description' => 'product id',
                                'type' => 'integer'
                            ]
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login'
                        ],
                        'failed_authorization' => [
                            'failed_authorization' => 'Please login as admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'product_id' => 'integer',
                                    'product_color' => 'string',
                                    'product_size' => 'string',
                                    'product_quantity' => 'integer',
                                    'customer_email' => 'string',
                                    'staff_email' => 'string',
                                    'status' => 'string',
                                    'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'failure_cause' => 'string',
                                    'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                    'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',

                                ],
                            ],
                            'links' => [

                                'first' => 'string',
                                'last' => 'string',
                                'prev' => 'string',
                                'next' => 'string'

                            ],
                            'meta' => [

                                'current_page' => 'integer',
                                'from' => 'integer',
                                'last_page' => 'integer',
                                'path' => 'string',
                                'per_page' => 'integer',
                                'to' => 'integer',
                                'total' => 'integer'
                                    
                            ]
                        ]
                    ]
                ],

                //Single order
                [
                    'path' => '/{id}',
                    'method' => 'GET',
                    'description' => 'returns the order with the specified id',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff | customer'
                    ],
                    'args' => [

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'id' => [
                                'required' => true,
                                'description' => 'order id',
                                'type' => 'string'
                            ]
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                'id' => 'integer',
                                'product_id' => 'integer',
                                'product_color' => 'string',
                                'product_size' => 'string',
                                'product_quantity' => 'integer',
                                'customer_email' => 'string',
                                'staff_email' => 'string',
                                'status' => 'string',
                                'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'failure_cause' => 'string',
                                'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                            ]
                        ]
                    ]
                ],


                /* C  R  E  A  T  E */

                //Add Order
                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Add new order',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'customer'
                    ],
                    'args' => [

                        'POST' => [
                            'description' => "POST parameters",

                            'product_id' => [
                                'required' => true,
                                'description' => 'Product id',
                                'type' => 'integer'
                            ],
                            'product_size' => [
                                'required' => true,
                                'description' => 'Product size',
                                'type' => 'string'
                            ],
                            'product_quantity' => [
                                'required' => true,
                                'description' => 'Product quantity',
                                'type' => 'integer'
                            ],
                            'customer_email' => [
                                'required' => true,
                                'description' => 'Customer email',
                                'type' => 'string'

                            ]
                        ]
                        
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'failed_verification' => [
                            'field' => 'validation message'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            "data"=> [
                                "id"=> "integer",
                                "product_id"=> "integer",
                                "product_color"=> "string",
                                "product_size"=> "string",
                                "product_quantity"=> "integer",
                                "customer_email"=> "string",
                                "staff_email"=> "string",
                                "status"=> "string",
                                "est_del_date"=> "string date in format(YYYY-MM-DD HH:MM:SS)",
                                "failure_date"=> "string date in format(YYYY-MM-DD HH:MM:SS)",
                                "failure_cause"=> "string",
                                "delivery_date"=> "string date in format(YYYY-MM-DD HH:MM:SS)",
                                "created_at"=> "string date in format(YYYY-MM-DD HH:MM:SS)",
                                "updated_at"=> "string date in format(YYYY-MM-DD HH:MM:SS)"
                            ]
                        ]
                    ]
                ],

                
                /* U  P  D  A  T  E */

                //Update Order Status
                [
                    'path' => '/update_status/{id}',
                    'method' => 'POST',
                    'description' => 'Change the status of an order',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' => [

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'id' => [
                                'required' => true,
                                'description' => 'Order id',
                                'type' => 'string' 
                            ]
                        ],

                        'POST' => [
                            'description' => "POST parameters",
                            'status' => [
                                'required' => true,
                                'description' => 'New status to set',
                                'type' => 'string ("pending", "failed", or "delivered")'
                            ],
                            'est_del_date' => [
                                'required' => false,
                                'description' => 'Estimated Delivery date',
                                'type' => 'string of date (YYYY-MM-DD HH:MM:SS)'
                            ],
                            'failure_cause' => [
                                'required' => false,
                                'description' => 'Cause of Failure',
                                'type' => 'string'
                            ],
                            'failure_date' => [
                                'required' => false,
                                'description' => 'Date of failure',
                                'type' => 'string of date (YYYY-MM-DD HH:MM:SS)'
                            ],
                            'delivery_date' => [
                                'required' => false,
                                'description' => 'Delivery date',
                                'type' => 'string of date (YYYY-MM-DD HH:MM:SS)'
                            ]

                        ]

                    ], 
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'failed_authorization' => [
                            'failed_authorization' => 'You do not have permission ot access this resource'
                        ],
                        'failed_validation' => [
                            'field' => 'Validation message'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'message' => 'Order status updated successfully',
                            'data' => [
                                'id' => 'integer',
                                'product_id' => 'integer',
                                'product_color' => 'string',
                                'product_size' => 'string',
                                'product_quantity' => 'integer',
                                'customer_email' => 'string',
                                'staff_email' => 'string',
                                'status' => 'string',
                                'est_del_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'failure_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'failure_cause' => 'string',
                                'delivery_date' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'created_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                                'updated_at' => 'string date in format(YYYY-MM-DD HH:MM:SS)',
                            ]
                        ]
                    ]
                ],


                /* D  E  L  E  T  E */

                //Delete Order
                [
                    'path' => '/{id}',
                    'method' => 'DELETE',
                    'description' => 'Delete order with specified id',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'ROUTE' => [
                            'description' => "Route parameters",
                            'id' => [
                                'required' => true,
                                'description' => 'Order id',
                                'type' => 'integer'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_type' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'failed_authorization' => [
                            'error' => 'Please login as admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        //success
                        'success' => [
                            'empty response with 204 response code'
                        ]
                    ]
                ],

                //Mass Delete
                [
                    'path' => '/mass_delete',
                    'method' => 'POST',
                    'description' => 'Delete orders with specified orders',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'POST' => [
                            'description' => "POST parameters",
                            'ids' => [
                                'required' => true,
                                'description' => 'ids of orders to delete',
                                'type' => 'JSON arrray: string'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_type' => [
                        'failed_authentication' => [
                            'error' => 'Please login'
                        ],
                        'failed_authorization' => [
                            'error' => 'Please login as admin'
                        ],
                        'failed_verification' => [
                            'field' => 'validation message'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        //success
                        'success' => 'Empty response with 204 response code'
                    ]
                ]

            ]
        ]);

    }


    /**
     * Returns reuseable function to return orders
     * 
     * @param $request->per_page Number of items to return per page
     * @param $where_clause Arguments to filter orders by
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function orders($per_page, $where_clause){

        //Pull orders
        $orders= Order::where($where_clause)->paginate($per_page);

        //Return matched orders through OrderCollection Resource
        return new OrderCollection($orders);

    }


    /**
     * Returns reuseable function to return orders
     * 
     * @param $per_page Number of items to return per page
     * @param $status Order status
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function ordersByStatus($request, $per_page, $status){


        //CHECK IF NUMBER OF ORDERS PER PAGE IS SET, OTHERWISE DEFAULT TO 20
        $per_page= intval($per_page) ?: 20 ;

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS: AUTHENTICATION AND AUTHORIZATION
   
        //Validate $status
        $status_is_valid= $this::validateStatus($status);

        if( !$status_is_valid ){
            return response()->json( [
                'error' => 'an invalid order status was specified'
            ],500);
        }


        //Array for where clause
        $where_clause= [
            ['status', '=', $status]
        ];
        
        //Call orders() utility function and return its result
        return $this->orders($per_page, $where_clause);
        
    }


    /**
     * Returns reuseable function to return orders
     * 
     * @param $per_page Number of items to return per page
     * @param $email of user
     * @param $role of user (Staff or Customer)
     * @param $status Order status
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function ordersByEmail(Request $request, $per_page, $email, $role, $status){

        //CHECK IF NUMBER OF ORDERS PER PAGE IS SET, OTHERWISE DEFAULT TO 20
        $per_page= intval($per_page) ?: 20 ;

        //Initialize $where_clause array
        $where_clause= [];
    
        //ROLE VALIDATION AND USER AUTHENTICATION

        //Validate $role
        $valid_role= ['customer', 'staff'];
        $role_is_valid= false;

        foreach($valid_role as $a_valid_role){

            if($role == $a_valid_role){
                $role_is_valid = true;
                break;
            }

        }

        //If an invalid role is supplied, return an error
        if( !$role_is_valid ){

            return response()->json( [
                'error' => 'An unexpected error occurred. An invalid role was supplied'
            ] ,500);

        }

        //If role is valid, authenticate user
        
        //Check if an admin is logged in
        $staff_is_admin= false;

        //Check if staff is logged in
        $staff_test= new \Utility\AuthenticateStaff($request);
        $staff_logged_in= !$staff_test->fails();

        if( $staff_logged_in ){

            //Check if authenticated staff is admin
            $admin_test= new \Utility\AuthorizeAdmin($request);
            
            if( !$admin_test->fails() ){
                $staff_is_admin = true;
            }
        }

        //STAFF
        if( $role == 'staff' ){

            //Staff Authorization required

            //Check if an Staff is logged in
            if($staff_test->fails()){

                return $staff_test->errors();

            }

            //SUCCESS: AUTHENTICATION
            $where_clause[]= ['staff_email', '=', $email];

        }

        //CUSTOMER
        if( $role== 'customer' ){

            //Customer Authorization required
            $customer_login= new \Utility\AuthenticateCustomer($request);

            $customer_logged_in= !$customer_login->fails();

            // If customer is not logged in
            if( !$customer_logged_in && !$staff_is_admin ){

                //Return a failed_authentication response
                return response()->json( [
                    'failed_authentication' => 'Please log in as customer'
                ], 401);

            }

            //If supplied email and email of authenticated user do not match
            $customer= Auth::guard('web')->user();

            $customer_is_authorized= false;

            if( !$staff_is_admin ){
                $customer_is_authorized= trim($customer->email) == trim($email);
            }

            if( !$customer_is_authorized && !$staff_is_admin ){

                //Return a failed_authentication response
                return response()->json( [
                    'failed_authorization' => 'Please log in as an authorized customer'
                ], 401);

            }

            //SUCCESS: AUTHENTICATION
            $where_clause[]= ['customer_email', '=', $email];

        }        


        //STATUS

        //Validate $status
        $valid_status= ['pending', 'failed', 'delivered'];
        $status_is_valid= false;

        foreach($valid_status as $a_valid_status){

            if($status == $a_valid_status){
                $status_is_valid = true;
                break;
            }

        }

        //If a valid status is supplied, push the status onto the $where_clause array
        if( $status_is_valid ){
            $where_clause[]= ['status', '=', $status];
        }


        
        //Call orders() utility function and return its result
        return $this->orders($per_page, $where_clause);
        
    }


    /* R    E    A    D */

    /**
     * Returns all orders
     * 
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function index(Request $request){

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS Admin Authorization

        //CHECK IF NUMBER OF ORDERS PER PAGE IS SET, OTHERWISE DEFAULT TO 20
        $per_page= intval($request->per_page) ?: 20 ;

        //Return all orders
        return new OrderCollection(Order::paginate($per_page));

    }

    
    /**
     * Returns all pending orders
     * 
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function pending(Request $request){

        //Call orders() utility function with "pending" status
        return $this->ordersByStatus($request, $request->per_page, "pending");

    }


    /**
     * Returns all delivered orders
     * 
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function delivered(Request $request){

        //Call ordersByStatus() utility function with "delivered" status
        return $this->ordersByStatus($request, $request->per_page, "delivered");

    }


    /**
     * Returns all failed orders
     * 
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function failed(Request $request){

        //Call orders() utility function with "failed" status
        return $this->ordersByStatus($request, $request->per_page, "failed");

    }



    //ORDERS BY CUSTOMER

    /**
     * Returns orders associated with the specified customer
     * 
     * @param $email Customer email
     * @param $request->order Order status
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function customer(Request $request, $email){

        //Call ordersByEmail() utility function
        return $this->ordersByEmail($request, $request->per_page, $email, 'customer', $request->status);


    }



    //ORDERS BY STAFF

    /**
     * Returns orders associated with the specified staff
     * 
     * @param $email staff email
     * @param $request->order Order status
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function staff(Request $request, $email){

        //Call ordersByEmail() utility function
        return $this->ordersByEmail($request, $request->per_page, $email, 'staff', "pending");


    }



    //ORDERS BY PRODUCT

    /**
     * Returns orders associated with the specified product
     * 
     * @param $id product id
     * @param $request->status Order status
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function product(Request $request, $id){

        //CHECK IF NUMBER OF ORDERS PER PAGE IS SET, OTHERWISE DEFAULT TO 20
        $per_page= intval($request->per_page) ?: 20;

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS Admin Authorization

        //Validate status if status is set
        if ($request->status){

            $request->status= trim($request->status);
            $valid_status= $this::validateStatus($request->status);

            //If status is not valid
            if( !$valid_status ){

                return response()->json( [
                    'error' => 'Please Specify a valid status in GET request.'
                ] ,404);
            }

        }

        //SUCCESS AUTHENTICATION AND AUTHORIZATION
        
        //Check thet product exists
        $product= Product::find($id);
        
        //If product is not found
        if( !$product ){

            return response()->json( [
                'error' => 'Product with id ' . $id . ' not found.'
            ] ,404);
        }

        //If found
        //Call the orders() function to get the orders related to the product
        return $this->orders($per_page, [ 
                                            ["product_id", "=", $id],
                                            //For some unknown reasons, the line below doesn't work without the '%'
                                            ["status", "like", "%".$request->status]
                                            
                                        ]);


    }


    /**
     * Return order with the specified id
     * 
     * @param $id order id
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function show(Request $request, $id){


        //find order with specified id
        $order= Order::find($id);

        
        //If order is not found
        if ( !$order ){
            return response()->json( [
                'error' => 'Order not found.'
            ] ,404);
        }



        //AUTHENTICATION
        //Check authenticated Customer or Staff

        //Customer AUTHENTICATION
        $customer= null;
        $authorized_customer= false;

        //Customer Authorization required
        $login_test= new \Utility\AuthenticateCustomer($request);

        //Check if a Customer is logged in
        if( !$login_test->fails() ){

            //Pull currently signed in customer
            $customer= Auth::guard('web')->user();

            //Customer AUTHORIZATION
            //Compare 'customer_email' of the order with the email of signd in user
            //If they don't match, return an error
            if( !( trim($customer->email) == trim($order->customer_email) ) ){

                return response()->json( [
                    'failed_authorization' => 'Sorry, This order does not belong to you.'
                ] ,401);
            }
            else{
                //Success Customer AUTHORIZATION
                $authorized_customer= true;
            }

        }

        //Staff AUTHENTICATION ONLY if Customer AUTHENTICATION FAILS
        $staff= null;
        $authorized_staff= false;

        //Staff Authorization required
        $staff_test= new \Utility\AuthenticateStaff($request);

        if( !$authorized_customer   //Customer not authorized
            && 
            !$staff_test->fails()   //Staff is signed in
        ){

            //Pull signed in staff
            $staff= Auth::guard('staffs')->user();

            //Compare order 'staff_email' with the email of authotized staff
            //If they don't match, check if staff is admin
            if( !( trim($staff->email) == trim($order->staff_email) )   ){

                //Check if staff is admin
                if( 
                    !($staff->isAdmin()) //Staff is not admin
                ){

                    return response()->json( [
                        'failed_authorization' => 'Sorry! This order is not assigned to you.'
                    ] ,401);
                }
                else{
                    //Success Admin AUTHORIZATION
                    $authorized_staff= true;
                }

            }
            else{
                //Success Staff AUTHORIZATION
                $authorized_staff= true;
            }
        }


        //Check for valid authorizzation
        if(
            $authorized_customer
            ||
            $authorized_staff
        ){
            //Return the matched order through OrderResource
            return new OrderResource($order);
        }
        else{
            //Return an error
            return response()->json( [
                'failed_authorization' => 'You do not have permission to access this resource'
            ] ,401);
        }

        

    }


    /**
     * Add a new order
     * 
     * @param $request->product_id  Product id
     * @param $request->product_size Product size
     * @param $request->product_quantity Product quantity
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function store(Request $request){

        //Customer Authorization required
        $login_test= new \Utility\AuthenticateCustomer($request);

        //Check if an Customer is logged in
        if($login_test->fails()){

            return $login_test->errors();

        }


        //VALIDATION
        $rules= [
            'product_id' => 'required|numeric',
            'product_size' => 'required|max:5|string',
            'product_quantity' => 'required|numeric'
        ];

        //Perfome Validation
        $validate_request= Validator::make($request->all(), $rules);

        //Failed Validation
        if( $validate_request->fails() ){
            return response()->json( $validate_request->errors() ,401);
        } 


        //SUCCESS VALIDATION AND AUTHENTICATION
        
        //Create new Order instance
        $order= new Order();

        //Verify Product Exists and specified quantity is available
        $product= Product::find($request->product_id);
        if( !$product ){
            return response()->json( [
                'error' => 'Product not found!'
            ] , 404);
        }

        //If Product is found, check available quantity of the specified size
        $options= json_decode($product->options);

        $request->product_size= trim($request->product_size);

        $valid_size= false;
        $valid_quantity= false;

        
        foreach($options as $option){

            //If this is the selected size
            if( !empty($option->size) && trim($option->size) == $request->product_size ){

                $valid_size= true;

                //Check available quantity
                $available_quantity= intval($option->quantity);

                //Compare with Quantity specified in order
                if( intval($request->product_quantity) <= $available_quantity ){
                    $valid_quantity= true;
                } 

            }

        }
        

        //If requested size not available
        if( !$valid_size ){
            return response()->json(  [
                'error' => 'Size ' . $request->product_size . ' not available!'
            ] ,404 );
        } 

        //If requested quantity not available
        if( !$valid_quantity ){
            return response()->json(  [
                'error' => 'Requested quantity (' . $request->product_quantity . ') of size ' . $request->product_size . ' not available!'
            ] ,404 );
        } 


        //Initialize
        $order->product_id= $request->product_id;
        $order->product_size= $request->product_size;
        $order->product_quantity= $request->product_quantity;

        //Obtain authenticated user
        $customer= Auth::guard('web')->user();

        //Set customer_email field
        $order->customer_email= $customer->email;

        //SAVE new order
        $order->save();

        
        //VERIFY Order
        $verify_order= Order::find($order->id);

        //if order could not be retrieved, return an error
        if( !$verify_order ){
            return response()->json(  [
                'error' => 'An unexpected error occurred. Could not save your order.'
            ] ,404 );
        } 

        
        //Return success message
        return new OrderResource($verify_order);


    }



    /**
     * Update order status
     * 
     * @param $id  Int Product id
     * @param $request->status String new status to set
     * @param $request->est_delivery_date Date
     * @param $request->failure_cause String cause of failure
     * @param $request->failure_date Date
     * @param $request->delivery_date Date
     * @param $request->staff_email String
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function updateStatus(Request $request, $id){


        //find order with specified id
        $order= Order::find($id);
        
        //If order is not found
        if ( !$order ){
            return response()->json( [
                'error' => 'Order not found.'
            ] ,404);
        }

        //TRIM String
        $request->status= trim($request->status);

        //VALIDATION
        $rules= [
            'status' => 'required|max:20|string',
            'est_del_date' => 'date',
            'failure_cause' => 'string|required_if:status,failed',
            'failure_date' => 'date|required_with:failure_cause',
            'delivery_date' => 'date|required_if:status,delivered'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //Failed VALIDATION
        if( $request_validator->fails() ){
            return response()->json( $request_validator->errors() ,401);
        }

        // CONVERT TO LOWER CASE
        $request->status= strtolower($request->status);

        //Ensure a valid order status is supplied
        $valid_status= $this::validateStatus($request->status);

        //Failed VALIDATION
        if( !$valid_status ){
            return response()->json( [
                "error" => "You have specified an invalid status. Please specify: 'pending', 'failed', or 'delivered'"
            ] ,401);
        }


        //AUTHENTICATION
        //Check authenticated Staff
        
        
        //Staff AUTHENTICATION 
        $staff= null;
        $authorized_staff= false;

        //Staff Authorization required
        $staff_test= new \Utility\AuthenticateStaff($request);

        if( 
            !$staff_test->fails()  //Staff is signed in
        ){

            //Pull signed in staff
            $staff= Auth::guard('staffs')->user();

            //Compare order 'staff_email' with the email of authotized staff
            //If they don't match, check if staff is admin
            if( !( trim($staff->email) == trim($order->staff_email) )   ){

                //Check if staff is admin
                if( 
                    !($staff->isAdmin()) //Staff is not admin
                ){

                    return response()->json( [
                        'failed_authorization' => 'Sorry! This order is not assigned to you.'
                    ] ,404);
                }
                else{
                    //Success Admin AUTHORIZATION
                    $authorized_staff= true;
                }

            }
            else{
                //Success Staff AUTHORIZATION
                $authorized_staff= true;
            }
        }
        else{
            //FAILED AUTHENTICATION
            return response()->json( [
                'failed_authentication' => 'Please login as a staff.'
            ] ,401);
        }

        
        //Check Staff Authorization
        if( $authorized_staff ){

            //Update Order Status
            $order->status= $request->status;

            //Update staff email if available
            if($request->staff_email){
                $order->staff_email= trim($request->staff_email);
            }
            
            //Update other available fields
            if($request->est_del_date){
                $order->est_del_date= trim($request->est_del_date);
            }

            //If status is set to "failed" and failure cause is set
            if(
                $request->status == 'failed'
                &&
                $request->failure_cause
            ){
                $order->failure_cause= trim($request->failure_cause);
            }

            //If status is set to failed and failure date is specified
            if(
                $request->status == 'failed'
                &&
                $request->failure_date
            ){
                $order->failure_date= trim($request->failure_date);
            }

            //If status is set to "delivered" and delivery date is set
            if(
                $request->status == 'delivered' 
                &&
                $request->delivery_date               
            ){
                $order->delivery_date= trim($request->delivery_date);
            }

            //Save
            $order->save();

            //Verify Save
            $saved_order= Order::find($order->id);
            if( !( trim($order->status) == trim($saved_order->status) ) ){
                return response()->json( [
                    "error" => "Could not update order status in database"
                ] ,500);
            }

            //SUCCESS
            //Return the matched order through OrderResource
            return new OrderResource($order);

        }

    }


    /**
     * Returns unassigned orders
     * =
     * @param $request->status Order status
     * @param $request->per_page Number of orders to display per page (optional)
     * 
     * 
     * @return JSON JSON formatted response
     * 
     */
    public function unassigned(Request $request){

        //Call orders() utility function with "pending" status
        return $this->ordersByStatus($request, $request->per_page, "unassigned");

    }


    /**
     * Delete a single Order.
     * Required admin authentication
     * 
     * @param $id int order id
     * 
     * @return JSON Empty JSON response with code 204 on success
     */
    public function delete(Request $request, $id){

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS AUTHENTICATION AND AUTHORIZATION

        //Pull order
        $order= Order::find($id);

        //If order is not found
        if( !$order ){

            return response()->json( [
                "error" => "Order with id '" . $id . "' not found." 
            ], 404);

        }


        //If found
        //DELETE ORDER
        $order->delete();


        //VERIFY
        $verify_order= Order::find($id);
        
        //If found
        if( $verify_order ){

            return response()->json( [
                "error" => "An unexpected error occurred. Could not delete." 
            ], 500);

        }

        //SUCCESS
        return response()->json( [], 204);

    }


    /**
     * Delete multiple orders
     * 
     * @param int $request->ids
     * 
     * @return JSON JSON response
     */
    public function massDelete(Request $request){

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS AUTHENTICATION AND AUTHORIZATION

        //VALIDATION
        $rules= [
            'ids' => 'required|JSON'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors(), 404);
        }

        //Pull orders to delete
        $ids= json_decode($request->get('ids'));

        $orders= Order::find($ids);

        //if number of matched order does not equal number of passed ids, return an error
        if($orders->count() != \count($ids)){

            //check for missing orders
            $missing= [];
            
            foreach($ids as $id){

                if(!$orders->find($id)){
                    \array_push($missing, $id);
                }
                
            }

            //return response with missing order ids
            return response()->json( [
                'error' => "Order(s) with ids= " . json_encode($missing) . " not found"
            ], 404);
        }

        
        //Delete orders
        $errors= [];
        foreach($orders as $order){

            $order->delete();


            /* ===TEST THIS============================================================= */
            //verify order was sucessfully deleted
            $order_check= Order::find($order->id);

            //if order still exists
            if($order_check){
                $errors[$order->id]= 'Could not delete! an unknown error ocurred.';
                continue;
            }
            /* ======================================================================= */

        }

        //if errors
        if($errors){
            return response()->json( $errors ,401);
        }

        return response()->json([], 204);

    }



    /* ============================================================ */
    /*  S  T  A  T  I  C       F   U   N   C   T   I   O   N   S */

    /**
     * Checks if the status provided is a valid status ('pending', 'failed', 'delivered')
     * 
     * @param $status Stirng
     * 
     * @return boolean
     */
    public static function validateStatus($status){

        //Validate $status
        $valid_status= ['unassigned', 'pending', 'failed', 'delivered'];

        foreach($valid_status as $a_valid_status){

            if(strcasecmp($status, $a_valid_status)){
               return true;
            }

        }

        return false;

    }


}
