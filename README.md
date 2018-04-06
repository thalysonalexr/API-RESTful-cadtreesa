# API-RESTful-Cadtreesa

☁ Web service for the cadreesa project. Serving the website and android application ☕

[![GitHub version](https://badge.fury.io/gh/thalysonrodrigues%2FAPI-RESTful-cadtreesa.svg)](https://badge.fury.io/gh/thalysonrodrigues%2FAPI-RESTful-cadtreesa)
[![Software License](https://img.shields.io/apm/l/vim-mode.svg)](https://github.com/thalysonrodrigues/API-RESTful-cadtreesa/blob/master/LICENSE)

## Introduction to API-RESTful-Cadtreesa

This project was developed for the purpose of studying API's [REST](https://en.wikipedia.org/wiki/Representational_state_transfer)ful with Json Web Token authentication ([JWT](https://jwt.io)). For the development model, a project was used during the course of Information Systems.

## API Documentation

We used the documentation standard of the [API Blueprint](https://apiblueprint.org/). See the documentation for this API with Github Pages rendered with [Aglio](https://github.com/danielgtaylor/aglio):

### [Documentation in Github Pages](https://thalysonrodrigues.github.io/API-RESTful-cadtreesa/)

### [Documentation in Markdown apiblueprint.org](https://github.com/thalysonrodrigues/API-RESTful-Cadtreesa/blob/master/docs/api.apib)

## About Cadtreesa Project

The Cadtreesa project was proposed during the discipline of Programming Language Concepts of the Information Systems course at UFMT-MT, Brazil.

### Scope of the problem

Register and validate trees by means of an Android application being the target public the students of the course of Agricultural and Environmental Engineering.

### Solution proposed by project members ([Me](https://github.com/thalysonrodrigues), Rodrigo Oliveira e Nicolas Tiago).

Registration of trees by students, teachers and coordinator. Once the tree has been registered by a user, it must be validated by a teacher or coordinator. Once validated the tree can have its information available on a web page that will be accessed from QR Codes generated at the time of registering the tree. These codes contain the address of the page with the tree information. Get to know the [project page](https://github.com/thalysonrodrigues/cadtreesa). 

### Entities and operations

* Operations [CRUD](https://pt.wikipedia.org/wiki/CRUD) in the Trees entity
* Operations [CRUD](https://pt.wikipedia.org/wiki/CRUD) in the Users entity with authentication

## Relational schema

The relational schema of the project (updated for this study) can be seen here: [Cadtreesa_db](https://github.com/thalysonrodrigues/API-RESTful-Cadtreesa/blob/master/database/db_cadtreesa.png)

## Installation

```bash
$ git clone https://github.com/thalysonrodrigues/API-RESTful-cadtreesa.git
```

## Dependencies

Tested in php >= 7.2.3

* [firebase/php-jwt](https://github.com/firebase/php-jwt) - Authentication with Json Web Tokens.
* [respect/validation](https://github.com/Respect/Validation) - Validation of data entry.
* [phpmailer/phpmailer](https://github.com/PHPMailer/PHPMailer) - Sending e-mails by SMTP.
* [respect/rest](https://github.com/Respect/Rest) - Routes to the application drivers.

This project uses composer to manage your dependencies. Before testing run the following command with the [composer](https://getcomposer.org/) already installed on your machine.

```bash
$ composer update
```

## Test

This project was tested only on local server using the php embedded server. To run the project, run the following command for the public directory:

```bash
$ php -S localhost:4000 -t public
```

## References

* https://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api
* https://www.youtube.com/watch?v=5I56m9o4TvI&list=PLz_YTBuxtxt4mPj7VncW1iRJyYUKKGsDt
* https://en.wikipedia.org/wiki/List_of_HTTP_status_codes

## Credits

- [Thalyson Alexandre Rodrigues de Sousa](https://github.com/thalysonrodrigues)

## License

The MIT License (MIT). Please see [License File](https://github.com/thalysonrodrigues/API-RESTful-cadtreesa/blob/master/LICENSE) for more information.
