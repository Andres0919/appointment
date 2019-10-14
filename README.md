# appointment
### appointment scheduling system
## first step:
>clone project
## second step:
copy `.env.example` and paste it as `.env` and complete the configuration of the database.
>run the command: 
`php artisan key:generate`
## third step:
>run the commands: 
```
composer install
npm install
```
## fourth step:
>run migration: 
`php artisan migrate`<br />
>install passport: 
`php artisan passport:install --force`<br />
>run seeders: 
`php artisan db:seed`<br />
## fifth step: 
run command: 
>`php artisan storage:link`
## finally: 
run commands 
```
php artisan serve
npm run dev 
```
- username: admin@random.com
- password: secret 
