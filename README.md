Local Shop API
This is a simple Laravel-based API for managing a local shop's product inventory. It includes basic CRUD operations for products, user authentication with Laravel Sanctum, and product management with custom validation rules and business logic.

Features
Product Management:

Create, read, update, and delete products.

Product model with fields: name (required), description (optional), and price (required, must be greater than or equal to 0).

Custom validation logic:

If the price is greater than 1000, the description becomes required.

Authentication:

User registration and login using Laravel Sanctum for API token-based authentication.

Authenticated users can perform CRUD operations on products.

Search Functionality:

Search products by name via the GET /api/products/search?name={name} endpoint.

Authorization:

Users can only update or delete products they have created, enforced through a custom ProductPolicy.

Installation
Clone the repository to your local machine:


`git clone <repository-url>`
`cd local-shop`
Install the required dependencies:


`composer install`
Set up the .env file by copying the .env.example:


`cp .env.example .env`
Set the database connection in the .env file. For SQLite, ensure you set the correct path:

env
`DB_CONNECTION=sqlite`
`DB_DATABASE=database/database.sqlite`
Run the migrations to create the necessary tables:


`php artisan migrate`
`Install Sanctum and publish the configuration:`


`php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
Set up Sanctum middleware in app/Http/Kernel.php as per the documentation, if not already done.

API Endpoints
User Authentication
Register: POST /api/register
Registers a new user. Requires name, email, and password.

Login: POST /api/login
Logs in a user and returns an API token.

Product Management
List Products: GET /api/products
Returns a list of all products.

Create Product: POST /api/products
Creates a new product. Requires name, price, and optionally description.

Show Product: GET /api/products/{id}
Shows details of a product by its ID.

Update Product: PUT /api/products/{id}
Updates an existing product. Only the creator can update it.

Delete Product: DELETE /api/products/{id}
Deletes a product. Only the creator can delete it.

Product Search
Search Products: GET /api/products/search?name={name}
Searches for products by name.

Authorization
Only authenticated users can perform product CRUD operations.

A custom ProductPolicy restricts product update and delete operations to the user who created the product.

Testing
Use Postman or any API client to test the endpoints. Make sure to include the Authorization: Bearer <token> header when testing endpoints that require authentication.