# CSV Import
The PHP script for load data from CSV files to database. On the clear php, without any framework.
Works only via a console. Tested on PHP 7.4 in Linux.


## Intallation
1. Clone project
2. Edit MySQL database connection in app/config.php
3. Run db migration:
```
$ php dbmigrate.php
```
4. Run script:
```
$ php csvimport.php
```