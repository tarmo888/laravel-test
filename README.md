# PHP Technical test

## Setup
1. Run `composer install` to install vendor modules.
2. Edit `.env` file with database connections.
3. Run `php artisan migrate:refresh --seed` to seed the database with fresh data.
4. Run `phpunit` or `php vendor/phpunit/phpunit/phpunit` to run tests.
5. Repeat from step 3. to restore the database to initial data.

## 1. task

* [ ] Create a new Laravel project using composer

Attached you will find a DB dump. Create a DB connection in laravel using the .env file. 
In this DB there are 3 tables: `users`, `countries` and `user_details`.

```
* users: id, email, active
* countries: id, name, iso2, iso3 
* user_details: id, user_id, citizenship_country_id, first_name, last_name, phone_number
```

* [ ] Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.
* [ ] Create a call which will allow you to edit user details just if the user details are there already.
* [ ] Create a call which will allow you to delete a user just if no user details exist yet.


### Manual testing the API
1. Run `php artisan migrate:refresh --seed` to seed the database with fresh data.
2. Make a `GET /api/user/search/at` or `GET /api/user/search/aut` call to get the list of active Austrian users.
3. Make a `PUT /api/user/6` call with JSON string `{"first_name": "FIRSTNAME", "last_name": "LASTNAME"}` as body content to change user details.
4. Repeat step 2. to check if the data was changed.
5. Make a `DELETE /api/user/1` call for unsuccessful deleting or `DELETE /api/user/2` call for successful deleting (only once) of the user.
6. Repeat from step 1. to restore the database to initial data.

### Manual testing from CLI
1. Run `php artisan migrate:refresh --seed` to seed the database with fresh data.
2. Run `php artisan user:search at` or `php artisan user:search aut` to get the list of active Austrian users.
3. Run `php artisan user:save 6 1 FIRSTNAME LASTNAME` to change user details.
4. Repeat step 2. to check if the data was changed.
5. Run `php artisan user:delete 1` for unsuccessful deleting or `php artisan user:delete 2` for successful deleting (only once) of the user.
6. Repeat from step 1. to restore the database to initial data.


## 2. task

* [ ] Create a new Laravel project using composer

Attached you will find a DB dump and a .csv file. Here you will find data for one table: `transactions`.
```
* transactions: id, code, amount, user_id, created_at, updated_at
```

* [ ] Implement a functionality which will be able to read the data available either in the DB or .csv

* [ ] Create a call which will return the transactions combined in a json


### Manual testing the API
1. Make a `GET /api/transaction/database` call to get the list of transactions from database.
2. Make a `GET /api/transaction/csv` call to get the list of transactions from `transactions.csv`.
3. Make a `GET /api/transaction` call to get the combined list of transactions from database and `transactions.csv`.

### Manual testing from CLI
1. Run `php artisan transaction:get database` to get the list of transactions from database.
2. Run `php artisan transaction:get csv` call to get the list of transactions from `transactions.csv`.
3. Run `php artisan transaction:get` call to get the combined list of transactions from database and `transactions.csv`.

