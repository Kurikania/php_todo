<?php

class Task
{
    public StorageStrategy $storage;

    public int $id;
    public string $title;
    public int $user_id = 1;
    public string $description;
    public string $created_at;
    public string $completed_at;
    public StatusEnum $status;
    public function __construct()
    {
        // set storage strategy from enviroment
        $settings = parse_ini_file(ROOT_PATH .'/config/settings.ini', true);
        $storageType = $settings['persistance']['type'];
        $storage = StorageEnum::fromName($storageType);
        $this->storage = new $storage->value;
        $this->storage->_setTable('task');
    }

    public function fetchOne(int $id)
    {
        $task = $this->storage->fetchOne($id);
        return $task;
    }

    public function fetchAll(): array
    {
        $tasks = $this->storage->fetchAll();
        return  $tasks;
    }

    public function save() {
        if(empty($this->id)) {
            $this->created_at =  date('Y-m-d h:i:s');
        }
        if ( $this->status === StatusEnum::DONE) {
            $this->completed_at =  date('Y-m-d h:i:s');
        }
        $data = (array) $this;
        unset($data['storage']);
        $task = $this->storage->save($data);
    }

    public function delete($id)
    {
        $this->storage->delete((int)$id);
    }

    private function convertToObject($array)
    {
        $object = new self();
        foreach ($array as $key => $value)
        {
            /* atajo */
            if ($key == 'status') {
                $object->$key = StatusEnum::fromValue($value);
            } else {
                $object->$key = $value;
            }
        }
        return $object;
    }

}