<?php

class User
{
    private StorageStrategy $storage;
    public function __construct()
    {
        // set storage strategy from enviroment
        $settings = parse_ini_file(ROOT_PATH .'/config/settings.ini', true);
        $storageType = $settings['persistance']['type'];
        $storage = StorageEnum::fromName($storageType);
        $this->storage = new $storage->value;
        $this->storage->_setTable('user');
    }

    public function fetchOne()
    {

    }
    public function save() {

    }
}