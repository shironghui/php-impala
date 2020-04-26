PHP Connection Impala
=======================

Installation
------------

Use [Composer] to install the package:
````
composer require tris/php-odbc-impala
````

Example [For Laravel]
-------
#### Laravel根目录下，config/app.php文件中providers添加Odbc\Impala\ImpalaServiceProvider::class，然后配置项aliases添加'Impala' => Odbc\Impala\Facades\Impala::class,

#### 执行composer dump-autoload

#### 执行php artisan vendor:publish --provider="Odbc\Impala\ImpalaServiceProvider"


Demo
-------

````php
use Odbc\Impala\Facades\Impala;

$sql = "show databases";
$res = Impala::execute($sql);
````

Please contact me if you have any questions
---------

Email:tris_10@sina.com


License
-------

All contents of this package are licensed under the [MIT license].



