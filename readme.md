# REST API  
Fully functional _REST API_ with dummy data for online shopping platform built with using the _Laravel_ PHP framework.
The API is configured to return and receive JSON payload, and has an in-built documentation that is accessible via **HTTP OPTIONS** requests.

-------------------------------------------------------------------------------------------------------------------------------------------
## Connect to API  
API can be accessed at *https://api.faaizz.com/api*. 
You should configure your HTTP client to accept **application/json** response and be sure to use an HTTP client that supports cookies.  


### Authorization and Authentication

#### Authorization
All routes (except documentation routes accessed via __HTTP OPTIONS__ requests) are secured using bearer authorization. To gain access, add an Authorization header to your request as follows:
```
Authorization: Bearer ZqbCtWgnP4RWA7kHnNh2cq3ZpbfJgDv6FylMilh0U3WjysyTb92FqHPcWUUr
```

#### Authentication
For endpoints that require staff/admin authentication, follow the guidelines specified in the in-built documentation which can be obtained by making an **OPTIONS** request to *https://api.faaizz.com/api/staff*.  

Basically to login, you just need to embed the following into an HTTP POST request as a multi-part form and send to *https://api.faaizz.com/api/staff/login/manual*:

```
email: user@demomail.com
password: TwrmoJufhyTu78
remember: yes   
```

-------------------------------------------------------------------------------------------------------------------------------------------
## Resources

### Root Endpoint
Make an **HTTP OPTIONS** request to the root URL at *https://api.faaizz.com/api* to get a list of all top level endpoints.

### Products Endpoint
Make an **HTTP OPTIONS** request to *https://api.faaizz.com/api/products* to get a list of all endpoints related to this resource. Available routes include:
- All Products: https://api.faaizz.com/api/products/
- Add Product (POST): https://api.faaizz.com/api/products
- All Male Items: https://api.faaizz.com/api/products/male
- All Female Items: https://api.faaizz.com/api/products/female
- Male Oxford Shoes: https://api.faaizz.com/api/products/shoes/male/Oxford
- Male Trousers: https://api.faaizz.com/api/products/clothing/male/Trousers
- Female Accessories: https://api.faaizz.com/api/products/accessories/female
- Female Tops: https://api.faaizz.com/api/products/clothing/female/Tops


### Customers Endpoint
Make an **HTTP OPTIONS** request to *https://api.faaizz.com/api/customers* to get a list of all endpoints related to this resource.
- All Customers: https://api.faaizz.com/api/customers

### Orders Endpoint
Make an **HTTP OPTIONS** request to *https://api.faaizz.com/api/orders* to get a list of all endpoints related to this resource. Available routes include:
- All Orders: https://api.faaizz.com/api/orders
- Unassigned Orders: https://api.faaizz.com/api/orders/unassigned

### Staff Endpoint
Make an **HTTP OPTIONS** request to *https://api.faaizz.com/api/staff* to get a list of all endpoints related to this resource. Some avalilable routes are:
- All Staff: https://api.faaizz.com/api/staff
- Login: https://api.faaizz.com/api/staff/login/manual
- Logout: https://api.faaizz.com/api/staff/logout


