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

### 行政区划

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\Region;

$region = new Region;

// 所有区划
var_dump($region->all());
// 省级区划
var_dump($region->provinces());
// 查找指定区划
var_dump($region->find('440300'));
// 查找子区划
var_dump($region->subregions('440300'));
```
