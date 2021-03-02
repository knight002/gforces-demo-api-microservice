<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'mysqli_adapter' => [],
            'pdo_mysql_adapter' => [
                'database' => 'dbname',
                'driver' => 'PDO_Mysql',
                'hostname' => '172.23.0.1',
                'username' => 'dbuser',
                'password' => 'dbpassword',
                'port' => '3307',
            ],
        ],
    ],
];
