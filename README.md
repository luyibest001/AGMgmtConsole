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

1. create models
   - php artisan make:model Customer -m
   - php artisan make:model Sale -m
   - php artisan make:model Product -m
   - php artisan make:model Employee -m
   
## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
