# Jumia Market Recruitment TEST

Exercise:
Create a single page application that uses the database provided (SQLite 3) to list and
categorize country phone numbers.
Phone numbers should be categorized by country, state (valid or not valid), country code and
number.
The page should render a list of all phone numbers available in the DB. It should be possible to
filter by country and state. Pagination is an extra.

![Capture](https://user-images.githubusercontent.com/13910335/165547622-f8151f29-7665-450e-aa00-7cac65bb7140.PNG)


# Topics to take in account:
- Try to show your OOP skills
- Code standards/clean code
- Do not use external libs like libphonenumber to validate the numbers.


## Regular expressions to validate the numbers:

1. Cameroon | Country code = +237 | regex = \(237\)\ ?[2368]\d{7,8}$
2. Ethiopia | Country code = +251 | regex = \(251\)\ ?[1-59]\d{8}$
3. Morocco | Country code = +212 | regex = \(212\)\ ?[5-9]\d{8}$
4. Mozambique | Country code = +258 | regex = \(258\)\ ?[28]\d{7,8}$
5. Uganda | Country code = +256 | regex = \(256\)\ ?\d{9}$

## Installation & Requirements

You will need to make sure your server meets the following requirements:

- PHP >= 7.4
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension 
- SQLite 3
- Composer

After cloning the app will follow these steps:

1. run `composer install` to install dependencies
2. copy from .env.example to a new file named .env `cp .env.example .env`
3. Create Database scheme `php bin/console  doctrine:mig:mig`
4. Load Country Data `php bin/console  doctrine:fixtures:load --group=countryFixture --append`

## Run App on Docker
- On the folder 'JumiaTask-symfony/' run the following code:
```sh
$ docker-compose up --build
```
> After running those comands you now can open the browser and go to : - http://localhost:81/

