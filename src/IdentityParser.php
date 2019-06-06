<?php

namespace Stiction\Dragon;

/**
 * 18位身份证号码分析
 *
 * 注意：没有对行政区划码是否有效进行校验
 * 注意：没有对出生时间进行限制
 * 如有以上需要，可以另行处理
 */
class IdentityParser
{
    const LENGTH = 18;

    const GENDER_MALE   = 'M';
    const GENDER_FEMALE = 'F';

    /**
     * 计算身份证校验位，大写
     *
     * @param string $number 身份证号码，只需前17位
     * @return bool|string 校验位，大写字母；如果前17位不是数字则返回false
     */
    public function calcCheckChar(string $number)
    {
        $numCount = self::LENGTH - 1;
        $nums = substr($number, 0, $numCount);
        if (strlen($nums) !== $numCount || !ctype_digit($nums)) {
            return false;
        }

        $weights = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $modChars = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

        $sum = 0;
        for ($i = 0; $i < $numCount; $i += 1) {
            $sum += (int)$nums[$i] * $weights[$i];
        }

        return $modChars[$sum % count($modChars)];
    }

    /**
     * 校验并解析身份证
     *
     * @param string $number 身份证号码
     * @return bool|array whole, region, birthday, ordinal, check, gender
     */
    public function parse(string $number)
    {
        $parts = $this->parseParts($number);
        if ($parts === false) {
            return false;
        }
        $checkChar = $this->calcCheckChar($number);
        if ($checkChar === false || $checkChar !== $parts['check']) {
            return false;
        }

        $info = $parts;
        $info['region'] = $this->parseRegion($parts['region']);
        if ($info['region'] === false) {
            return false;
        }
        $info['birthday'] = $this->parseBirthday($parts['birthday']);
        if ($info['birthday'] === false) {
            return false;
        }
        if ((int)$parts['ordinal'] % 2 === 0) {
            $info['gender'] = self::GENDER_FEMALE;
        } else {
            $info['gender'] = self::GENDER_MALE;
        }
        return $info;
    }

    protected function parseParts(string $number)
    {
        $number = strtoupper($number);
        if (! preg_match('/^(\d{6})(\d{8})(\d{3})(\d|X)$/', $number, $match)) {
            return false;
        }
        return [
            'whole'    => $match[0],
            'region'   => $match[1],
            'birthday' => $match[2],
            'ordinal'  => $match[3],
            'check'    => $match[4],
        ];
    }

    /**
     * 解析行政区划码，根据需求进行重写
     *
     * @param string $str 6位行政区划码
     * @return bool|string
     */
    protected function parseRegion(string $str)
    {
        return $str;
    }

    /**
     * 解析生日，根据需求进行重写
     *
     * @param string $str YYYYMMDD
     * @return bool|string YYYY-MM-DD
     */
    protected function parseBirthday(string $str)
    {
        $date = \DateTime::createFromFormat('Ymd', $str);
        if ($date->format('Ymd') !== $str) {
            return false;
        }
        return $date->format('Y-m-d');
    }
}
