<?php
require_once "Database.php";

class Product extends Database
{
    public function store($request)
    {
        $product_name = $request['product_name'];
        $price = $request['price'];
        $quantity = $request['quantity'];

        $sql = "INSERT INTO products (`product_name`,`price`,`quantity`) VALUES ('$product_name', '$price', '$quantity')";

        if ($this->conn->query($sql)) {
            header('location: ../views');
            exit;
        } else {
            die('Error creating the product: ' . $this->conn->error);
        }
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products";

        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error retrieving all products: " . $this->conn->error);
        }
    }

    public function displayProducts()
    {
        $sql = "SELECT * FROM products";
        $items = [];
        if ($result = $this->conn->query($sql)) {
            while ($item = $result->fetch_assoc()) {
                $items[] = $item;
            }
            return $items;
        } else {
            die("Error in retrieving: " . $this->conn->error);
        }
    }

    public function addProduct($product_name, $price, $quantity)
    {
        $sql = "INSERT INTO products (product_name, price, quantity) VALUES ('$product_name', '$price', '$quantity')";

        if ($this->conn->query($sql)) {
            header("location: ../views/dashboard.php");
            exit();
        } else {
            die("Error in Adding: " . $this->conn->error);
        }
    }

    public function editProduct($product_id, $product_name, $price, $quantity)
    {
        $sql = "UPDATE products SET product_name = '$product_name', price = $price, quantity = $quantity Where id = $product_id";

        if ($this->conn->query($sql)) {
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error in Editing: " . $this->conn->error);
        }
    }

    public function displaySpecificProduct($product_id)
    {
        $sql = "SELECT * FROM products WHERE id = $product_id";

        if ($return = $this->conn->query($sql)) {
            return $return->fetch_assoc();
        } else {
            die("Error in retrieving the product: " . $this->conn->error);
        }
    }

    public function deleteProduct($id)
    {

        $sql = "DELETE FROM products WHERE id = $id";

        if ($this->conn->query($sql)) {
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die('Error deleting the product: ' . $this->conn->error);
        }
    }

    public function adjustStock($product_id, $buy_quantity){
        $sql = "UPDATE products SET quantity = quantity - '$buy_quantity' WHERE id = '$product_id'";

        if($this->conn->query($sql)){
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die('Error in adjusting stock: ' . $this->conn->error);
        }
    }
}
