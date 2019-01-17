<?php
class Product{

  // database connection and table name
  private $conn;
  private $table_name = "product_item";

  // object properties
  public $id;
  public $name;
  public $description;
  public $price;
  public $category_id;
  public $category_name;
  public $color_id;
  public $color_name;
  public $size;
  public $images;
  public $created;
  public $updated;

  // constructor with $db as database connection
  public function __construct($db){
    $this->conn = $db;
  }

  // read products
  function read(){
    // select all query
    $query = "SELECT pi.id, p.name, p.description, p.price, p.category_id, c.name as category_name, pi.color as color_id, cl.name as color_name, pi.size, pi.images, pi.created, pi.updated
    FROM " . $this->table_name . " pi
    JOIN products p ON pi.product_id = p.id
    JOIN categories c ON  p.category_id = c.id
    JOIN colors cl ON pi.color = cl.id
    ORDER BY pi.created DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }
  // used when filling up the update product form
  function readOne(){
    
    // query to read single record
    $query = "SELECT pi.id, p.name, p.description, p.price, p.category_id, c.name as category_name, pi.color as color_id, cl.name as color_name, pi.size, pi.images, pi.created, pi.updated
            FROM
                " . $this->table_name . " pi
            JOIN products p ON pi.product_id = p.id
            JOIN categories c ON  p.category_id = c.id
            JOIN colors cl ON pi.color = cl.id
            WHERE
              pi.id = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    return $stmt;
  }
}