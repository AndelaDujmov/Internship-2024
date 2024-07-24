# Week 1

### Setup

PHP 8.2, MySQL, Apache server <br>
Code Editor: VSCode <br>
OS: Linux <br>

### Php Framework And Router Class

**Generating the composer.json file:**
```bash
    composer init
```
**Autoloader:** vendor/autoload.php

### Router classes

**Route** : src/Route <br>
**Router** : src/Router <br>
**Response** : src/Response <br>
**Json Response** : src/Response/JsonResponse <br>
**Request** : src/Request <br>
**Controller** : src/Controller <br>

*Router classes are defined in* **routes.php** <br>
*Request classes are defined in* **index.php** <br>

### Twig

Installation <br>

```bash
    composer require "twig/twig:^3.0"
```

Usage  <br>

Set up configuration class that will initialise Twig with a specified template directory.<br>

**Twig Loader** : /src/config <br>

### PDO

Configuration <br>

**Installing PDO MYSQL extension:** 

```bash
    sudo apt install php-mysql
```

<br>

After installation it is needed to restart web server to load new extension.

<br>

**Runtime Configuration :** <br>

After the installation update the php.ini file with extension: *extension=pdo.*




