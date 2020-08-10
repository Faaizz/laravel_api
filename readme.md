# REST API  
Fully functional _REST API_ for online shopping platform built with using the _Laravel_ framework.
The API is configured to return JSON response, and has an in-built documentation that is accessible via **HTTP OPTIONS** requests.

-------------------------------------------------------------------------------------------------------------------------------------------
## Connect to API  
A fully-functional development version can be accessed at *http://laravel_api.faaizz.com/api*. 
You should configure your HTTP client to expect **application/json** response and be sure to use an HTTP client that supports cookies.  

-------------------------------------------------------------------------------------------------------------------------------------------
## Resources

### Top Level Endpoint
Make an **HTTP OPTIONS** request to the root URL at *http://laravel_api.faaizz.com/api* to get a list of all top level endpoints.

### Products Endpoint
Make an **HTTP OPTIONS** request to *http://laravel_api.faaizz.com/api/products* to get a list of all endpoints related to this resource.

### Orders Endpoint
Make an **HTTP OPTIONS** request to *http://laravel_api.faaizz.com/api/orders* to get a list of all endpoints related to this resource.

### Customers Endpoint
Make an **HTTP OPTIONS** request to *http://laravel_api.faaizz.com/api/customers* to get a list of all endpoints related to this resource.

### Staff Endpoint
Make an **HTTP OPTIONS** request to *http://laravel_api.faaizz.com/api/staff* to get a list of all endpoints related to this resource.


-------------------------------------------------------------------------------------------------------------------------------------------
## Authorization and Authentication

### Authorization
In addition to user authentication, bearer authorization is used to provide an extra layer of security for the service.  
To access, add an Authorization header to your request as follows:
```H
Authorization: Bearer ZqbCtWgnP4RWA7kHnNh2cq3ZpbfJgDv6FylMilh0U3WjysyTb92FqHPcWUUr
```

### Authentication
For endpoints that require staff/admin authentication, follow the guidelines specified in the in-built documentation which can be obtained by making an **OPTIONS** request to *http://laravel_api.faaizz.com/api/staff*.  

Basically to login, you just need to embed the following into an HTTP POST request as a multi-part form and send to *http://laravel_api.faaizz.com/api/staff/login*:

```
email: favian50@yahoo.com  
password: rszqWIxb1QjKTPPRL9vw
remember: yes   
```
