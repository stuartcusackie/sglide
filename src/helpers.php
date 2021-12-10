<?php

use stuartcusackie\sglide\sglide;

if(!function_exists('sglide')) {

    /**
     * Generate a glide image object from
     * a Statamic Field or path string.
     * 
     * @param $src mixed
     * @param $params array
     * @param $disk string
     * @return object
     */
    function sglide($src, array $params = [], string $disk = null)
    {
        $sglide = new sglide();
        return $sglide->fromMixed($src, $params, $disk);
    }

}
