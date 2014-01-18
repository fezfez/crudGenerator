[![Build Status](https://travis-ci.org/fezfez/crudGenerator.png?branch=master)](https://travis-ci.org/fezfez/crudGenerator)
[![Coverage Status](https://coveralls.io/repos/fezfez/crudGenerator/badge.png?branch=master)](https://coveralls.io/r/fezfez/crudGenerator?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/fezfez/crudGenerator/badges/quality-score.png?s=6f4fe2a1be56796f0a4ea62c237c254bf9455ef0)](https://scrutinizer-ci.com/g/fezfez/crudGenerator/)

This is alpha, certainly contains bugs, please dont use it on production

Running tests
-------------
    composer install --dev
    ./vendor/bin/phpunit

Roadmap
=======

Template
--------
* Fk management in DAO, DTO, Hydrator, From
* Choise form type (select, input etc... )
* Symfony 2
* Phalcon PHP

Generator
---------
* Dependencies between entities, table
* Environment manager (more flexible for unit tests)
* Clear unit test