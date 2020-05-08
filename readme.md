# REST API
Fully functional _REST API_ for online shopping platform built with using the _Laravel_ framework.
The API is configured to return JSON response, and has an in-built documentation that is accessible via **HTTP OPTIONS** requests.

Find a deployed version at the backend of a Java Frontend application _https://github.com/Faaizz/java_admin_frontend_

## Connect to API
A fully-functional deployed version can be accessed at *http://faaizz.com/api*.

### Authorization
In addition to user authentication, bearer authorization is used to provide an extra layer of security for the service.  
To access, add an Authorization header to your request as follows:
```H
Authorization: Bearer nWqlVBFz0s1xzadFhubyP2Ixd422CwjqeHLIxe7MuOCVG1TFN85y3VxAXLgu
```

### Authentication
For endpoints that require staff/admin authentication, follow the guidelines specified in the in-built documentation which can be obtained by making an **OPTIONS** request to *http://faaizz.com/api/staff*.  

Basically, you just need to embed the following into an HTTP POST request as a multi-part form and send to *http://faaizz.com/api/staff/login*:

* *email:* test@testemail.com  
* *password:* TestPassword
* *remember:* yes   

Be sure to use an HTTP client that supports cookies.  
  

### Top Level Endpoints
Make an **HTTP OPTIONS** request to the root URL at *http://faaizz.com/api* to get a list of all top level endpoints.

### Products Endpoint
Make an **HTTP OPTIONS** request to *http://faaizz.com/api/products* to get a list of all endpoints related to this resource.

### Orders Endpoint
Make an **HTTP OPTIONS** request to *http://faaizz.com/api/orders* to get a list of all endpoints related to this resource.

### Customers Endpoint
Make an **HTTP OPTIONS** request to *http://faaizz.com/api/customers* to get a list of all endpoints related to this resource.

### Staff Endpoint
Make an **HTTP OPTIONS** request to *http://faaizz.com/api/staff* to get a list of all endpoints related to this resource.
