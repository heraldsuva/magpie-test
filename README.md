# Magpie Fullstack Coding Challenge

#### Summary
Create a simple store that utilizes the Magpie Checkout API


## Installation

```bash
  git clone git@github.com:heraldsuva/magpie-test.git
  cd magpie-test
  cp .env.example .env
  composer install
```

Setup your database and Magpie secret key from `.env`
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAGPIE_API_SK=
```

```bash
  php artisan migrate
  php artisan db:seed
  php artisan serve
  npm run dev
```
## Admin Login

* _User : admin@laravel.test_
* _Pass :  password_

## Running Tests

```bash
  php artisan test
```


## Authors

- [@heraldsuva](https://www.github.com/heraldsuva)

