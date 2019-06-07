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
        return (bool)preg_match('/^1[3456789]\d{9}$/', $mobile);
    }
}
