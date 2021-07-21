<?php

class InventoryService {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $statement = "SELECT * FROM 
                        master.dbo.Inventory";

        return $this->db->execute($statement, null, true);
    }

    public function get($id) {
        $statement = "SELECT * FROM 
                        master.dbo.Inventory
                        WHERE id = ?";

        return $this->db->execute($statement, array($id), false);

    }

    public function update($id, $stock, $price) {
        $statement = "UPDATE master.dbo.Inventory 
                        SET quantity = ?, price = ? 
                        WHERE id = ?";

        return $this->db->execute($statement, array($stock, $price, $id));
    }

    public function create($id, $quantity, $price) {
        $statement = "INSERT INTO master.dbo.Inventory (id, quantity, price) VALUES (?, ?, ?)";
        $this->db->execute($statement, array($id, $quantity, $price));
        return $this->get($id);
    }
}