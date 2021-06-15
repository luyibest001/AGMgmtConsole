# Workflows
## Preparation

1. Sign up Heroku

2. Create a Heroku App

3. Create Laravel App
   - on local machine (mine is MacOS) terminal, go to project folder, create a Laravel project with composer <br>
   cmd: <br>
   <b>composer create-project --prefer-dist Laravel/Laravel AGMgmtConsole</b>
  
   - in terminal, type in <br>
     <b>php artisan serve</b> <br>
     check in the browser localhost:8000 to see if laravel works fine.
 
4. Initialize Git <br>
   - create a new repository on GitHub, and copy the URL
   - in terminal under project folder, do the following: <br>
     $ git init -b main <br>
     $ git add . <br>
     $ git commit -m "Initial commit" <br>
     $ git remote add origin <URL> <br>
     $ git push -u origin main <br>

5. Connect Heroku to Git repository <br>
   In Heroku, set GitHub repository the App connected to

6. Deploy App with Heroku
   - in terminal under project directory, type in: <br>
   <b>php artisan key:generate --show</b> <br>
   this command will show the APP_KEY value, this key value pair can also be found in .env file in Laravel project. <br>
   
   - in Heroku Settings, editing "Config Vars", set APP_KEY to be the key value shown in the previous step. <br>
   - under laravel project create a file call "Procfile", this will help Heroku to identify the document root path <br>
     in terminal type in <br>
     <b>echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile</b> <br>
   - click "Open App" to see if Laravel project works in https://accentgrouptest.herokuapp.com/ <br>
   - in Config Vars, set APP_NAME to be "AGMgmtConsole", APP_ENV to be "production", APP_URL to be "https://accentgrouptest.herokuapp.com/" <br>

7. Setup Heroku PostgreSQL database
   - go to "Resources" tab in Heroku dashboard. 
   - search in add-ons "postgres", select "Heroku Postgres"
   - go to "Heroku Postgres", under "Settings" tab, there is database credentials.
   - edit file "AGMgmtConsole/config/database.php" and .env, set env constant and create a new database connection "AGMgmt"
   - in Laravel, set default database connection to AGMgmt
  
7. Install Vue in Laravel
   in terminal: <br>
   $ composer require laravel/ui <br>
   $ php artisan ui vue <br>
   $ npm install && npm run dev <br>

8. Enable node.js in heroku
   $ heroku login <br>
   $ heroku buildpacks:add heroku/nodejs -a accentgrouptest <br>
   $ heroku config:set NPM_CONFIG_PRODUCTION=false -a accentgrouptest <br>
   add "postinstall": "npm run production", in package.json "scripts"
   $ heroku buildpacks -a accentgrouptest (to ensure that heroku/php and heroku/nodejs are listed)
   
## Tasks

1. Create models, create migrate files to create tables, import data  
   - $php artisan make:model Customer -m
   - $php artisan make:model Sale -m
   - $php artisan make:model Product -m
   - $php artisan make:model Employee -m
   - define columns in each migration file
   - $php artisan migration
   - php artisan make:seeder [CustomerSeeder|EmployeeSeeder|SaleSeeder|ProductSeeder]
   - parse xls file and create a record for each row
   - call four seeders from DatabaseSeeder class by "php artisan db:seed"

2. Create Controllers and API routes
   - UserController.php, ProductController.php, CustomerController.php, EmployeeController.php
   - in web.php and api.php create routes
   - use Jwt to authenticate API 
   - test API with Postman
    
3. Create Views
   - create views for login and dashboard page login.blade.php, index.blade.php
   - create Vue Components and register in app.js (LoginComponenent.vue, DashboardComponent.vue)
   - create UI with vuetify and bootstrap
   - css files /public/css/login.css, /public/css/dashboard.css

## App Info

1. Heroku url
   https://accentgrouptest.herokuapp.com/

2. test user
   - email: admin@gmail.com
   - password: admin

