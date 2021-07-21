<?php

class CpuService {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $statement = "SELECT * FROM 
                        master.dbo.Cpu;";

        return $this->db->execute($statement);
    }

    public function get($id) {
        $statement = "SELECT * FROM 
                        master.dbo.Cpu
                        WHERE product_id = ?";
        return $this->db->execute($statement, array($id), false);
    }

    public function getOnlyInStock() {
        $statement = "SELECT cpu.* FROM 
                        master.dbo.Inventory AS inv 
                        INNER JOIN 
                        master.dbo.Cpu AS cpu 
                        ON (inv.id = cpu.product_id)
                        WHERE inv.quantity > 0;";

        return $this->db->execute($statement);
    }
    
    // Creates a new CPU and returns its id
    public function create($manufacturer, $model, $speed, $cores, $imgurl) {
        $statement = "INSERT INTO master.dbo.Cpu (manufacturer, model, speed, cores, img) VALUES
                      (?, ?, ?, ? , ?) ";

        $params = array($manufacturer, $model, $speed, $cores, $imgurl);
        $id = $this->db->insert($statement, $params);
        return $id;
    }
}