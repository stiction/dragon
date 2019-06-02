<?php

namespace Stiction\Dragon;

class Region
{
    const DATA_FILE = __DIR__ . '/region_data.php';
    const PROVINCE_PARENT_ID = '';

    protected $regions = null;

    /**
     * 区划列表
     *
     * @return array
     */
    public function all(): array
    {
        if (is_null($this->regions)) {
            $this->regions = require self::DATA_FILE;
        }
        return $this->regions;
    }

    /**
     * 省级区划
     *
     * @return array
     */
    public function provinces(): array
    {
        return $this->subregions(self::PROVINCE_PARENT_ID);
    }

    /**
     * 查找区划
     *
     * @param string $id
     * @return array|false
     */
    public function find($id)
    {
        foreach ($this->all() as $region) {
            if ($region['id'] === $id) {
                return $region;
            }
        }
        return false;
    }

    /**
     * 子区划
     *
     * @param string $id
     * @return array
     */
    public function subregions(string $id): array
    {
        return array_filter($this->all(), function ($region) use ($id) {
            return $region['parent_id'] === $id;
        });
    }
}
