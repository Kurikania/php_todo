<?php
interface StorageStrategy {
    public function fetchOne(int $id);
    public function save($data);
    public function delete(int $id);
    public function fetchAll();
    public function _setTable($table);
}