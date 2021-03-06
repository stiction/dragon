<?php

namespace Stiction\Dragon;

class Name
{
    /**
     * 随机姓氏
     *
     * @return string
     */
    public function randomSurname(): string
    {
        if (rand(1, 10) === 1) {
            $surnames = self::$doubleSurnames;
        } else {
            $surnames = self::$singleSurnames;
        }
        $key = array_rand($surnames);
        return $surnames[$key];
    }

    /**
     * 随机名字（不含姓氏）
     *
     * @return string
     */
    public function randomFirstName(): string
    {
        if (rand(1, 10) === 1) {
            $len = 3;
        } else {
            $len = rand(1, 2);
        }
        $name = '';
        for ($i = 0; $i < $len; ++$i) {
            $key = array_rand(self::$nameChars);
            $name .= self::$nameChars[$key];
        }
        return $name;
    }

    /**
     * 随机名字
     *
     * @return string
     */
    public function randomFullName(): string
    {
        return $this->randomSurname() . $this->randomFirstName();
    }

    protected static $nameChars = [
        '伟', '刚', '勇', '毅', '俊', '峰', '强', '军', '平', '保', '东', '文', '辉', '力',
        '明', '永', '健', '世', '广', '志', '义', '兴', '良', '海', '山', '仁', '波', '宁',
        '贵', '福', '生', '龙', '元', '全', '国', '胜', '学', '祥', '才', '发', '武', '新',
        '利', '清', '飞', '彬', '富', '顺', '信', '子', '杰', '涛', '昌', '成', '康', '星',
        '光', '天', '达', '安', '岩', '中', '茂', '进', '林', '有', '坚', '和', '彪', '博',
        '诚', '先', '敬', '震', '振', '壮', '会', '思', '群', '豪', '心', '邦', '承', '乐',
        '绍', '功', '松', '善', '厚', '庆', '磊', '民', '友', '裕', '河', '哲', '江', '超',
        '浩', '亮', '政', '谦', '亨', '奇', '固', '之', '轮', '翰', '朗', '伯', '宏', '言',
        '若', '鸣', '朋', '斌', '梁', '栋', '维', '启', '克', '伦', '翔', '旭', '鹏', '泽',
        '晨', '辰', '士', '以', '建', '家', '致', '树', '炎', '德', '行', '时', '泰', '盛',
        '雄', '琛', '钧', '冠', '策', '腾', '楠', '榕', '风', '航', '弘', '秀', '娟', '英',
        '华', '慧', '巧', '美', '娜', '静', '淑', '惠', '珠', '翠', '雅', '芝', '玉', '萍',
        '红', '娥', '玲', '芬', '芳', '燕', '彩', '春', '菊', '兰', '凤', '洁', '梅', '琳',
        '素', '云', '莲', '真', '环', '雪', '荣', '爱', '妹', '霞', '香', '月', '莺', '媛',
        '艳', '瑞', '凡', '佳', '嘉', '琼', '勤', '珍', '贞', '莉', '桂', '娣', '叶', '璧',
        '璐', '娅', '琦', '晶', '妍', '茜', '秋', '珊', '莎', '锦', '黛', '青', '倩', '婷',
        '姣', '婉', '娴', '瑾', '颖', '露', '瑶', '怡', '婵', '雁', '蓓', '纨', '仪', '荷',
        '丹', '蓉', '眉', '君', '琴', '蕊', '薇', '菁', '梦', '岚', '苑', '婕', '馨', '瑗',
        '琰', '韵', '融', '园', '艺', '咏', '卿', '聪', '澜', '纯', '毓', '悦', '昭', '冰',
        '爽', '琬', '茗', '羽', '希', '欣', '飘', '育', '滢', '馥', '筠', '柔', '竹', '霭',
        '凝', '晓', '欢', '霄', '枫', '芸', '菲', '寒', '伊', '亚', '宜', '可', '姬', '舒',
        '影', '荔', '枝', '丽', '阳', '妮', '宝', '贝', '初', '程', '梵', '罡', '恒', '鸿',
        '桦', '骅', '剑', '娇', '纪', '宽', '苛', '灵', '玛', '媚', '琪', '晴', '容', '睿',
        '烁', '堂', '唯', '威', '韦', '雯', '苇', '萱', '阅', '彦', '宇', '雨', '洋', '忠',
        '宗', '曼', '紫', '逸', '贤', '蝶', '菡', '绿', '蓝', '儿', '翠', '烟',
    ];

    protected static $singleSurnames = [
        '李', '王', '张', '刘', '陈', '杨', '赵', '黄', '周', '吴', '徐', '孙', '胡', '朱',
        '高', '林', '何', '郭', '马', '罗', '梁', '宋', '郑', '谢', '韩', '唐', '冯', '于',
        '董', '萧', '程', '曹', '袁', '邓', '许', '傅', '沈', '曾', '彭', '吕', '苏', '卢',
        '蒋', '蔡', '贾', '丁', '魏', '薛', '叶', '阎', '余', '潘', '杜', '戴', '夏', '钟',
        '汪', '田', '任', '姜', '范', '方', '石', '姚', '谭', '廖', '邹', '熊', '金', '陆',
        '郝', '孔', '白', '崔', '康', '毛', '邱', '秦', '江', '史', '顾', '侯', '邵', '孟',
        '龙', '万', '段', '漕', '钱', '汤', '尹', '黎', '易', '常', '武', '乔', '贺', '赖',
        '龚', '文', '庞', '樊', '兰', '殷', '施', '陶', '洪', '翟', '安', '颜', '倪', '严',
        '牛', '温', '芦', '季', '俞', '章', '鲁', '葛', '伍', '韦', '申', '尤', '毕', '聂',
        '丛', '焦', '向', '柳', '邢', '路', '岳', '齐', '沿', '梅', '莫', '庄', '辛', '管',
        '祝', '左', '涂', '谷', '祁', '时', '舒', '耿', '牟', '卜', '路', '詹', '关', '苗',
        '凌', '费', '纪', '靳', '盛', '童', '欧', '甄', '项', '曲', '成', '游', '阳', '裴',
        '席', '卫', '查', '屈', '鲍', '位', '覃', '霍', '翁', '隋', '植', '甘', '景', '薄',
        '单', '包', '司', '柏', '宁', '柯', '阮', '桂', '闵', '解', '强', '柴', '华', '车',
        '冉', '房', '边', '辜', '吉', '饶', '刁', '瞿', '戚', '丘', '古', '米', '池', '滕',
        '晋', '苑', '邬', '臧', '畅', '宫', '来', '嵺', '苟', '全', '褚', '廉', '简', '娄',
        '盖', '符', '奚', '木', '穆', '党', '燕', '郎', '邸', '冀', '谈', '姬', '屠', '连',
        '郜', '晏', '栾', '郁', '商', '蒙', '计', '喻', '揭', '窦', '迟', '宇', '敖', '糜',
        '鄢', '冷', '卓', '花', '仇', '艾', '蓝', '都', '巩', '稽', '井', '练', '仲', '乐',
        '虞', '卞', '封', '竺', '冼', '原', '官', '衣', '楚', '佟', '栗', '匡', '宗', '应',
        '台', '巫', '鞠', '僧', '桑', '荆', '谌', '银', '扬', '明', '沙', '薄', '伏', '岑',
        '习', '胥', '保', '和', '蔺',
    ];

    protected static $doubleSurnames = [
        '欧阳', '诸葛', '司马', '上官', '西门', '宇文', '夏侯', '太史', '慕容', '皇甫', '呼延',
        '公孙', '独孤', '东方', '端木', '长孙', '拓跋', '尉迟',
    ];
}
