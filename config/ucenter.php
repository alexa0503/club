<?php

return [
    'url'            => env('UC_URL', 'http://club.himyweb.com/bbs'),
    'connect'        => env('UC_CONNECT', 'mysql'),
    'dbhost'         => env('UC_DBHOST', env('DB_HOST')),
    'dbuser'         => env('UC_DBUSER', env('DB_USERNAME')),
    'dbpw'           => env('UC_DBPW', env('DB_PASSWORD')),
    'dbname'         => env('UC_DBNAME', env('DB_DATABASE')),
    'dbcharset'      => env('UC_DBCHARSET', 'utf8'),
    'dbtablepre'     => env('UC_DBTABLEPRE', 'discuz_'),
    'dbconnect'      => env('UC_DBCONNECT', '0'),
    'key'            => env('UC_KEY', 'S6X872P1jdB0Y832YaC8Hct8q7keUeVeZfg6p1l2H8E1Ue19v9z564S0h712W0E0'),
    'api'            => env('UC_API', 'http://club.himyweb.com/bbs'),//http://club.himyweb.com/bbs/api/uc.php
    'ip'             => env('UC_IP', '127.0.0.1'),
    'charset'        => env('UC_CHARSET', 'utf-8'),
    'appid'          => env('UC_APPID', '2'),
    'ppp'            => env('UC_PPP', '2'),
    'apifilename'    => env('UC_APIFILENAME', 'uc.php'),
    'service'        => env('UC_SERVICE', 'Binaryoung\Ucenter\Services\Api'),
];
