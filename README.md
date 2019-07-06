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
/*
array(3) {
  ["id"]=>
  string(6) "440300"
  ["name"]=>
  string(9) "深圳市"
  ["parent_id"]=>
  string(6) "440000"
}
*/
var_dump($region->find('440300'));
// 查找子区划
var_dump($region->subregions('440300'));
```

### 身份证

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\IdentityParser;

$parser = new IdentityParser;

// 计算校验位，大写表示
// string(1) "X"
var_dump($parser->calcCheckChar('36112319820726197'));

// 解析身份证信息，分别为身份证完整号码、行政区划码、生日、序号、校验位、性别（F|M)
/*
array(6) {
  ["whole"]=>
  string(18) "36112319820726197X"
  ["region"]=>
  string(6) "361123"
  ["birthday"]=>
  string(10) "1982-07-26"
  ["ordinal"]=>
  string(3) "197"
  ["check"]=>
  string(1) "X"
  ["gender"]=>
  string(1) "M"
}
*/
var_dump($parser->parse('36112319820726197x'));
// bool(false)
var_dump($parser->parse('361123198207261976'));
```

### 银行卡

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\Bank;

$bank = new Bank;

// 计算银行卡校验位数字
// int(7)
var_dump($bank->calcCheckNumber('622841407026350141'));
```

### 农历

支持公历范围：1900-01-31（含） - 2101-01-28（含）  
支持农历范围：1900年正月初一（含） - 2100年腊月廿九（含）  

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\LunarDate;

$timestamp = 0;
$date = new LunarDate($timestamp);

/*
array(4) {
  ["year"]=>
  int(1969) 1969年
  ["month"]=>
  int(11) 冬月
  ["day"]=>
  int(24) 廿四
  ["leap"]=>
  bool(false) 不是闰月
}
*/
var_dump($date->info());
```

### 其他

```php
<?php
require 'vendor/autoload.php';

use Stiction\Dragon\Misc;

$misc = new Misc;

// 检查手机号码
// bool(true)
var_dump($misc->checkMobile('13800138000'));
```
