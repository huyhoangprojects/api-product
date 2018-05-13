<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $images;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read products
    function read(){
     
        // select all query
        $query = "SELECT
                    p.id, p.name, p.description, p.price, pi.images, p.created
                FROM
                    " . $this->table_name . " p
                    JOIN
                        product_item pi
                            ON p.id = pi.product_id
                Group By p.id
                ORDER BY
                    p.created DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}