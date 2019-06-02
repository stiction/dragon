# dragon
中文相关的一些工具类

## Installation

```bash
composer require stiction/dragon
```

## Examples

### 姓名

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\Name;

$name = new Name;

// 随机姓氏
var_dump($name->randomSurname());
// 随机名字（不含姓氏）
var_dump($name->randomFirstName());
// 随机全名
var_dump($name->randomFullName());
```

### 格言

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\Inspiring;

$inspiring = new Inspiring;

// string 一条格言
var_dump($inspiring->one());
// string[] 所有格言
var_dump($inspiring->all());
```
