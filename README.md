

 ## Vending Machine Application

The Vending Machine API is Designed to allow users with a “seller” role to add, update or remove products, while users with a “buyer” role can deposit coins into the machine and make purchases. The vending machine only accept 5, 10, 20, 50 and 100 cent coins.


## Users API

Find below users API's, what they do, type and parameters.

- POST: /api/register (Creates a new user with roles Buyer or Seller) <br>
    Parameters: (username,password,password_confirmation,role_id) <br>
    
- GET: /api/users (Get all Users) <br>
- GET: /api/user/{id} (Get a single User) <br>
- PUT: /api/user/{id} (Update a user Record) <br>
- DELETE: /api/user/{id} (Delete a user Record) <br>
- POST: /api/deposit (Delete a user Record) <br>
    Parameter (cost)
- POST: /api/buy (Delete a user Record) <br>
    Parameter (product_id,amount)
- POST: /api/reset (Delete a user Record) <br>


## Products API

Find below products API's, what they do, type and parameters.
    
- GET: /api/products (Get all Products) <br>
- POST: /api/product (Create new product) <br>
    Parameter: (name,slug,cost,amount_available)
- GET: /api/product/{id} (Get a single Product) <br>
- PUT: /api/product/{id} (Update a user Product) <br>
- DELETE: /api/product/{id} (Delete a product Record) <br>
- POST: /api/seller-products/{id} (Get all the products of a single Seller) <br>
    


