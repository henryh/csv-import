# CSV Import
PHP script to load data from CSV files into a database. In pure php, without any framework and third-party libraries.
It works only through the console. Tested on PHP 7.4 in Linux.

## Intallation
1. Clone project and go to the app directory:
```
$ git clone git@github.com:henryh/csvimport.git
$ cd csvimport
```
2. Edit MySQL database connection in app/config.php
3. Run db migration:
```
$ php dbmigrate.php
```
4. Run script:
```
$ php csvimport.php
```

## More
[Project author](https://github.com/henryh)

[MIT license](https://opensource.org/licenses/MIT)