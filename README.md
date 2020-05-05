# LARAVUESPA2019

## Getting Started


### Install from repository

Download & unpack the files, navigate to the directory and run:

    composer install

After it has completed, run:

    npm install

Copy the example .env file:

    cp .env.example .env

Generate an application key:

    php artisan key:generate

Run Mix tasks:

    npm run dev
    npm run watch //build every time you have changes
    npm run prod

Seed:

    php artisan db:seed
    php artisan db:seed --class=RolePermissionsSeeder


### References

- https://github.com/coreui/coreui-free-vue-admin-template
- https://github.com/derekphilipau/laravel-5.5-coreui-vue-separated
- https://github.com/websanova/vue-auth
- https://codeburst.io/api-authentication-in-laravel-vue-spa-using-jwt-auth-d8251b3632e0
- http://felicianoprochera.com/introduction-to-repository-pattern-with-laravel-5/
- https://github.com/ratiw/vuetable-2
