<?php

namespace Stiction\Dragon;

class Inspiring
{
    /**
     * 一条格言
     *
     * @return string
     */
    public function one(): string
    {
        $list = $this->all();
        $index = mt_rand(0, count($list) - 1);
        return $list[$index];
    }

    /**
     * 所有格言
     *
     * @return string[]
     */
    public function all(): array
    {
        return [
            '夫唯不争，故天下莫能与之争。 —— 老子',
            '己所不欲，勿施于人。 —— 孔子',
            '老吾老，以及人之老；幼吾幼，以及人之幼。 —— 孟子',
            '天生我材必有用，千金散尽还复来。 —— 李白',
            '读书破万卷，下笔如有神。 —— 杜甫',
            '大江东去，浪淘尽，千古风流人物。 —— 苏轼',
            '青山遮不住，毕竟东流去。 —— 辛弃疾',
        ];
    }
}
