<?php
class Addproduct extends Controller
{
    public $ProductType;

    public function __construct()
    {
        $this->model('Product');
    }

    public function index()
    {
        /* Allow cors */
        header('Access-Control-Allow-Origin: *');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'sku' => $_POST['sku'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'size' => $_POST['size'],
                'height' => $_POST['height'],
                'width' => $_POST['width'],
                'length' => $_POST['length'],
                'weight' => $_POST['weight'], 
            ];

            $this->ProductType = $_POST['type'];

            /* Check if the product already exist */
            if (count(Product::findProductsBysku($data)) > 0) {
                $response = array("message" => "The product already exist", "ResultStatus" => 500);
                echo json_encode($response);
            } else {
                /* insert product */
                $this->ProductType = new $this->ProductType;
                $res = $this->ProductType->insertProducts($data);
                echo $res;
            }

        }

    }


}