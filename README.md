# shopify-integration

This project is designed to demonstrate a connection between a Laravel backend and a React frontend for Shopify integration.

## Installation

### Frontend Setup
1. Navigate to the `front` folder and run `npm install` in the terminal to install the required dependencies.

### Backend Setup
1. Navigate to the `back` folder and run `composer install` in the terminal.
2. Run `php artisan migrate --seed` to set up the database with sample data.

## Local Development
1. Ensure your local server (e.g., XAMPP) is running.

## User Account
1. An existing user account has been created for testing purposes:
   - Email: khaledalhoussein@gmail.com
   - Password: 123456

## Usage
1. Start the frontend by running `npm start`. The login page will be the first page you encounter.
2. Use the provided credentials to log in.
3. This will lead you to the dashboard page to connect with Shopify. You can use the pre-created shop `dexter-clothes.myshopify.com` or your own shop.
4. Push your preferred products to the Shopify store.
5. You can view the products you pushed at: [Shopify Products Page](https://dexter-clothes.myshopify.com/collections/all?sort_by=created-descending).
6. For development purposes, use the password 'chemay' when prompted.

## Note
- Due to restrictions, the use of ngrok for tunneling is not possible in this setup. You may need to explore alternative methods for exposing your local development server to the internet.
- Please add the following URLs to your whitelist to enable pushing products:
   - http://127.0.0.1:8000/api/callback
   - http://127.0.0.1:8000/api/shopify/redirect

## Acknowledgement
Thank you for using this application. Happy coding!
