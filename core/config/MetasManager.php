<?php

class MetasManager
{
    private $metas = [];

    public function get()
    {
        return $this->metas;
    }

    public function add($metas)
    {
        $this->metas[] = $metas;
    }

    public function registerMetas()
    {
        if (is_admin()) {
            add_filter('rwmb_meta_boxes', [$this, 'get']);
        }
    }
}
