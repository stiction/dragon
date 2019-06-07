<?php

namespace Stiction\Dragon;

class Misc
{
    /**
     * 检查手机号码
     *
     * @param string $mobile
     * @return bool
     */
    public function checkMobile(string $mobile): bool
    {
        if (strlen($mobile) !== 11) {
            return false;
        }
        if (!ctype_digit($mobile)) {
            return false;
        }
        if ($mobile[0] !== '1') {
            return false;
        }
        if (!in_array($mobile[1], ['3', '4', '5', '6', '7', '8', '9'], true)) {
            return false;
        }
        return true;
    }
}
