<?php

abstract class Product {
        
    protected $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /* common method to get all products */
    public static function getProducts()
    {
        static $db;
        $db = new Database;
        $db->query("SELECT * FROM products ORDER BY ID ASC");
        return $db->__get('resultSet');
    }

    /* common method to delete a product */
    public static function deleteProduct($id)
    {
        static $db;
        $db = new Database;
        $db->query('DELETE FROM products WHERE id = :id');
        // Bind values
        $db->bind(':id', $id);
        // Execute
        if ($db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /* common method to find a product */
    public static function findProductsBysku($data)
    {

        static $db;
        $db = new Database;
        $db->query('SELECT * FROM products WHERE sku = :sku');
        //Bind values
        $db->bind(':sku', $data['sku']);

        //get products
        return $db->__get('resultSet');

    }

   /* abstract method to implement polymorphism */
   abstract public function insertProducts($data);

}


class DVD extends Product
{

    public function insertProducts($data)
    {

        $this->db->query('INSERT INTO products (sku, name, price, size) VALUES (:sku, :name, :price, :size)');
        // Bind values
        $this->db->__set(':sku', $data['sku']);
        $this->db->__set(':name', $data['name']);
        $this->db->__set(':price', $data['price']);
        $this->db->__set(':size', $data['size']);

        
        // execute
        if ($this->db->execute()) {
            $response = array("message" => "The product added", "ResultStatus" => 200);
            return json_encode($response);
        }
    }

}

class Furniture extends Product
{

    public function insertProducts($data)
    {

        $this->db->query('INSERT INTO products (sku, name, price, height, width, length) VALUES (:sku, :name, :price, :height, :width, :length)');
        // Bind values
        $this->db->__set(':sku', $data['sku']);
        $this->db->__set(':name', $data['name']);
        $this->db->__set(':price', $data['price']);
        $this->db->__set(':height', $data['height']);
        $this->db->__set(':width', $data['width']);
        $this->db->__set(':length', $data['length']);

        // execute
        if ($this->db->execute()) {
            $response = array("message" => "The product added", "ResultStatus" => 200);
            return json_encode($response);
        }
    }

}


class Book extends Product
{
   
    public function insertProducts($data)
    {

        $this->db->query('INSERT INTO products (sku, name, price, weight) VALUES (:sku, :name, :price, :weight)');
        // Bind values
        $this->db->__set(':sku', $data['sku']);
        $this->db->__set(':name', $data['name']);
        $this->db->__set(':price', $data['price']);
        $this->db->__set(':weight', $data['weight']);

        // execute
        if ($this->db->execute()) {
            $response = array("message" => "The product added", "ResultStatus" => 200);
            return json_encode($response);
        }
    }

}

