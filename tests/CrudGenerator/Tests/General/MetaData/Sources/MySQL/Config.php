<?php
namespace CrudGenerator\Tests\General\MetaData\Sources\MySQL;

use CrudGenerator\MetaData\Driver\DriverConfig;

$config = new DriverConfig('Web', 'WebConnector');
$config->addQuestion('Database Name', 'configDatabaseName');
$config->addQuestion('Host', 'configHost');
$config->addQuestion('User', 'configUser');
$config->addQuestion('Password', 'configPassword');
$config->addQuestion('Port', 'configPort');

$config->response('configDatabaseName', 'code_generator');
$config->response('configHost', 'localhost');
$config->response('configUser', 'travis');
$config->response('configPort', '3302');

return $config;
