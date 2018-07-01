<?php

class Config {

    public static function get($section) {
        $config = parse_ini_file('config/application.ini', true);

        if ($config[$section]) {
            return $config[$section];
        } else {
            throw new Exception(sprintf('Section not found: %s', $section));
        }
    }
}