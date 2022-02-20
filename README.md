After pull from github, to initialize project it is needed to do next steps:

1. composer install
2. create new database
3. to create environment file you can run command cp .env.example .env 
4. adjust database data in .env file
5. run \\\php artisan migrate\\\
6. run \\\php artisan db:seed\\\ to fill database with data
7. project is ready, it can be run by hosts or runing command \\\php artisan serve\\\

There are 2 users admin (admin123) and user (user123). Each of them have their own role
(admin or user)
Admin has permission to list users, create, edit, delete or assign role.
User has no permissions.
