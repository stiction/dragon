<?php

namespace Stiction\Dragon;

class Bank
{
    /**
     * 计算银行卡校验位数字
     *
     * @param string $number 银行卡号（不含校验位）
     * @return bool|int 校验位数字
     */
    public function calcCheckNumber(string $number)
    {
        if ($number === '' || !ctype_digit($number)) {
            return false;
        }
        $nums = [];
        for ($i = 0, $len = strlen($number); $i < $len; ++$i) {
            $nums[] = (int)$number[$i];
        }
        return $this->luhn($nums);
    }

    protected function luhn(array $nums): int
    {
        $sum = 0;

        $shouldDouble = true;
        for ($i = count($nums) - 1; $i >= 0; --$i) {
            if ($shouldDouble) {
                $n = $nums[$i] * 2;
                $sum += ($n > 9) ? ($n - 9) : $n;
            } else {
                $sum += $nums[$i];
            }
            $shouldDouble = !$shouldDouble;
        }

        $mod = $sum % 10;
        return (10 - $mod) % 10;
    }
}
