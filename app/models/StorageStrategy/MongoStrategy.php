<?php
class MongoStrategy implements StorageStrategy
{
    private $manager;
    private $table;
    public function __construct()
    {
        $settings = parse_ini_file(ROOT_PATH . '/config/settings.ini', true);
        //$client = new MongoDB\Client('mongodb://mongodb-deployment:27017');
        $this->manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
    }
    public function fetchOne(int $id) {
        $query   = new MongoDB\Driver\Query(['id' => $id ], []);
        // set from settings
        $cursor  = $this->manager->executeQuery('task.'.$this->table, $query);
        $res = [];
        foreach($cursor as $document) {
            $res[] = (array) $document;
        }
        return  $res;
    }
    public function save($data) {
        // create new or update
        $writeConcern = new MongoDB\Driver\WriteConcern(
            MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $insertData = [];
        foreach ($data as $key => $dataItem) {
            $insertData[$key] = $dataItem;
        }
        if (isset($data['id'])) {
            $id = $data['id'];
            $updateRec = new MongoDB\Driver\BulkWrite;
            $updateRec->update(
                ['id'=> $id],
                ['$set' => $insertData],
                ['multi' => false, 'upsert' => false]
            );
            $result = $this->manager->executeBulkWrite(
                'task.'.$this->table, $updateRec, $writeConcern
            );
        } else {
            // get next id
            $insertData['id'] = $this->getNextId();
            $updateRec = new MongoDB\Driver\BulkWrite;
            $updateRec->insert($insertData);
            $this->manager->executeBulkWrite('task.'.$this->table, $updateRec, $writeConcern);
        }
    }
    public function delete(int $id) {
        $delRec = new MongoDB\Driver\BulkWrite;
        $delRec->delete([
            'id' =>$id], ['limit' => 1]);
        $writeConcern = new MongoDB\Driver\WriteConcern(
            MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $this->manager->executeBulkWrite('task.'.$this->table, $delRec, $writeConcern);
    }

    public function _setTable($table) {
        $this->table = $table;
    }

    public function getNextId(): int
    {
        return 0;
    }
    public function fetchAll() {
        $query   = new MongoDB\Driver\Query([], []);
        // set from settings db name
        $cursor  = $this->manager->executeQuery('task.'.$this->table, $query);
        $res = [];
        foreach($cursor as $document) {
            $res[] = (array) $document;
        }
        return  $res;
    }
}