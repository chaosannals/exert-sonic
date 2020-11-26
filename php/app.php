<?php

use Psonic\Search;
use Psonic\Client;
use Psonic\Ingest;
use Psonic\Control;

require __DIR__.'/vendor/autoload.php';

$host = '127.0.0.1';
$port = 1491;
$timeout = 10;
$password = 'SecretPassword';

// 数据管理。
$ingest  = new Ingest(new Client($host, $port, $timeout));
$ingest->connect($password);
echo $ingest->push('messagesCollection', 'defaultBucket', "1234","hi Shobi how are you?")->getStatus(); // OK
echo $ingest->push('messagesCollection', 'defaultBucket', "1235","hi are you fine ?")->getStatus(); //OK
echo $ingest->push('messagesCollection', 'defaultBucket', "1236","Jomit? How are you?")->getStatus(); //OK
$ingest->disconnect();

// 集合管理。
$control = new Control(new Client($host, $port, $timeout));
$control->connect($password);
echo $control->consolidate(); // 数据落盘
$control->disconnect();

$search = new Search(new Client($host, $port, $timeout));
echo $search->connect($password);
var_dump($search->suggest('messagesCollection', 'defaultBucket', "you"));
$search->disconnect();