<?php

require_once __DIR__.'/../models/Room.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

class RoomService {

    private static $instance;

    private function __construct() { }

    public static function getInstance(): RoomService {
        if(!isset(self::$instance)) {
        self::$instance = new RoomService();
        }
        return self::$instance;
    }

    public function create(Room $room): ?Room {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        room (name, is_unavailable, is_stockroom, local_lo_id)
        VALUES (?, ?, ?, ?)', [
        $room->getName(),
        $room->getIsUnavailable(),
        $room->getIsStockroom(),
        $room->getLoId()
        ]);
        if($affectedRows > 0) {
        $room->setRId($manager->lastInsertId());
        return $room;
        }
        return NULL;
    }

    public function getOne($id):?Room {
        $manager = DatabaseManager::getManager();
        $room = $manager->getOne('
        SELECT * FROM
        room
        WHERE r_id = ?',
        [$id]
        );
        if ($room) {
            $roomObj = new Room($this->adaptRoomQueryToConstruct($room));
            return $roomObj;
        }
        return NULL;
    }

    private function adaptRoomQueryToConstruct($rowRoom){
        $room = array("rid"=>$rowRoom["r_id"],
                      "name"=>$rowRoom["name"],
                      "isUnavailable"=>$rowRoom["is_unavailable"],
                      "isStockroom"=>$rowRoom["is_stockroom"],
                      "loid"=>$rowRoom["local_lo_id"]);
        return $room;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        room'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }



    public function getAllByLocal($lo_id) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT room.name, local_lo_id, r_id, is_stockroom from room 
        JOIN local ON room.local_lo_id = local.lo_id AND local.lo_id = ?',
        [$lo_id]
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }

    public function update(Room $room): ?Room {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        UPDATE room
        set name = ?, 
        is_unavailable = ?, 
        is_stockroom = ?, 
        local_lo_id = ?)', [
        $room->getName(),
        $room->getIsUnavailable(),
        $room->getIsStockroom(),
        $room->getLoId()
        ]);
        if($affectedRows > 0) {
        $room->setRId($manager->lastInsertId());
        return $room;
        }
        return NULL;
    }

}




?>