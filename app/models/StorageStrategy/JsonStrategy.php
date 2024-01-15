<?php

class JsonStrategy implements StorageStrategy
{
    private $table;
    private $db;
    public function fetchAll()
    {
        $array = json_decode(file_get_contents(ROOT_PATH .'/web/data/'.$this->table.'.json'), true);
        return $array;
    }

    public function fetchOne(int $id)
    {
        $modelItems = $this->fetchAll();
        foreach ($modelItems as $item) {
            if ($item['id'] == $id) {
                return  $item;
            }
        }
        return null;
    }
    public function save($data) {
        $updateItem = [];
        $items = $this->fetchAll();
        if (isset($data['id'])) {
            foreach ($items as $i => $item) {
                if ($item['id'] == $data['id']) {
                    $items[$i] = $updateItem = $data;
                }
            }
        } else {
            // generate new id
            $data['id'] = $this->getNextId();
            $items[] = $updateItem = $data;
        }
        $this->writeJson($items);
        return $updateItem;
    }
    public function delete(int $id) {
        $todos = $this->fetchAll();
        foreach ($todos as $i => $todo) {
            if ($todo['id'] == $id) {
                array_splice($todos, $i, 1);
            }
        }
        $this->writeJson($todos);
    }

    public function _setTable($table) {
        $this->table = $table;
    }

    private function getNextId(): int
    {
        $items = $this->fetchAll();
        $item = end($items);
        $id = $item['id'] + 1;;
        return $id;
    }

    private function writeJson($tasks)
    {
       $result = file_put_contents(ROOT_PATH .'/web/data/'.$this->table.'.json', json_encode($tasks, JSON_PRETTY_PRINT));
    }
}