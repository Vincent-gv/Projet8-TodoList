# Todo & Co

### Project #8 - Application Developer Student - PHP / Symfony OpenClassrooms

Improve an existing ToDo & Co Symfony application

## Application installation

### Minimum required

* Apache server 2.4
* PHP 7

### Installation

* Clone the project in your local server environment with the command:
`` 
git clone https://github.com/Vincent-gv/Projet8-TodoList.git
`` 
* Run 
`` composer install 
``  at the root of the folder to install the dependencies.
* Create a local database: 
`` 
php bin/console doctrine:database:create
`` 
* Update environment variables in .env file of the project and run Doctrine to load SQL tables: 
`` 
php bin/console doctrine:schema:create
`` 
 * Load fixtures into the database: 
`` 
 php bin/console doctrine:fixtures:load
``  
 * Start Symfony server: 
`` 
 symfony server:start
`` 
* You can test the application with Admin account:
 > login: admin
 > password: admin

## Developed with

* ** Symfony 5.2 **
* ** PHP 7.4.7 **
* ** Mysql **
* ** Composer **
* ** Xdebug 3.0.1 **
* ** PHPUnit 7.5.20 **

## Author

** Vincent Gauchevertu ** - Openclassrooms student
The project is hosted [online](https://todo.vincent-dev.com/).

## Project badges

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/b9fcb8208a03424797c3d2b4a49562fb)](https://app.codacy.com/gh/Vincent-gv/Projet8-TodoList/dashboard)
[![Maintainability](https://api.codeclimate.com/v1/badges/2b78659c63a712b969bc/maintainability)](https://codeclimate.com/github/Vincent-gv/projet8-TodoList/maintainability)
