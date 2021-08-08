# User authentaction and authorization

- Build using php laravel framework version 8. 
- MySql Database
-  [JSON Web Token (JWT)](https://github.com/tymondesigns/jwt-auth) to handle authentication : The token is passed with each request using the authorization header with token scheme. The JWT authentication middleware handles the validation and authentication of the token.

## Installation Instructions

1. Run git clone https://github.com/mohamedenein/task.git
2. Create a MySQL database for the project
3. From the projects root run `cp .env.example .env`
4. Make connection with database in `.env` file

       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=auth_task
       DB_USERNAME=root
       DB_PASSWORD=
       
5. from the project root folder run `composer update`
6. From the projects root folder run `php artisan migrate`

# Documentation 
Laravel based on MVC [ Model - View - Controller] architecture.

Laravel come with pre-defined User model and user migration.

### User Register Service
Step 1 : create the controller responsible for authentication named AuthController and create register function, in register function i validate the incoming request to make sure all required data are present and valid, then store the validated data into the database. Finally, return a JSON response.

Step 2 : create the route responsible for registering a user in `routes/api.php` file.

Now test on postman, validation test

<img src="https://user-images.githubusercontent.com/44629919/128615382-8b9efc06-0c5a-4e40-aeb3-d0043f60bc9e.PNG" width="936" height="600">

registration test

<img src="https://user-images.githubusercontent.com/44629919/128614996-55ad621c-64b2-4594-8409-911b009b66b5.PNG" width="1000" height="500">


### User Login Service
Step 1 : create login function in AuthController, in login function will checking if the email and password supplied actually match any from the users table and then creating a new personal access token for the user.

Step 2 : create the route responsible for login in `routes/api.php` file.

validation test
<img src="https://user-images.githubusercontent.com/44629919/128615960-0aa4c1e2-f025-4886-ba30-80495c1bbf89.PNG">


login test
 <img src="https://user-images.githubusercontent.com/44629919/128615923-13744217-a3f3-4da7-b499-26feb82d77de.PNG" width="1013" height="424">


### Service for validating whether logged user is permitted to delete another user or not.
To assign specific user a specific role, I created new migration to add new column in user table for role,
role column take enum datatype, I take only "user" and "admin" value on that and will keep "user" as default value.

To assign permission, I use laravel policy.

In laravel, policies are classes that organize authorization logic around a particular model.

First, create UserPolicy, and add function `delete` return true if authenticated user has "admin" role and false if has "user" role.

Second, create PermissionController then add function `can_delete_user` and use `can()` method to validate the logged user can delete user or not.

Third, create the route responsible for validate if logged user can delete another user in `routes/api.php` file, this route accessible to only authenticated users, can do that using `auth:api` middleware.

test if invalid user token request

 <img src="https://user-images.githubusercontent.com/44629919/128615670-e4ed7ca9-58bf-47c2-986d-69ed4eeb11c8.PNG" width="1042" height="396">

if valid user token request and have a permission to delete user

 <img src="https://user-images.githubusercontent.com/44629919/128615624-6af224fc-2aa2-4b4e-82ef-dccbd1d401aa.PNG" width="1042" height="396">

if valid user token request and don't have a permission to delete user

 <img src="https://user-images.githubusercontent.com/44629919/128615666-3ace17a9-9f67-4e3b-857c-199ced3cafcc.PNG" width="1042" height="396">


### User Logout Service
Step 1 : create logout function in AuthController, in logout function, we clears the passed JWT access token.

Step 2 : create the route responsible for Logout in `routes/api.php` file, this route accessible to only authenticated users, can do that using `auth:api` middleware.

Test valid token request

 <img src="https://user-images.githubusercontent.com/44629919/128615862-2c5cd937-4e65-43df-bbc7-6fc5e1b8a25c.PNG" width="1034" height="387">

Test invalid token request
  <img src="https://user-images.githubusercontent.com/44629919/128615864-b9b991b5-bf08-4280-833b-628464f14a37.PNG" width="1036" height="407">
