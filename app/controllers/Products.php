<?php
class Products extends Controller
{
    public function __construct()
    {
         $this->model('Product');
    }

    public function index($id)
    {
        /* Allow cors */
        header('Access-Control-Allow-Origin: *');

        //load products
        $products = Product::getProducts();
        $this->view('pages/index', ['Products' => $products]);

    }

    public function MassDelete() {
        /* Allow cors */
        header('Access-Control-Allow-Origin: *');

        //handle mass delete request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $_POST['id'];
            foreach ($ids as $id) {
                Product::deleteProduct($id);
            }
        }

        //load products
        $products = Product::getProducts();
        $this->view('pages/index', ['Products' => $products]);
        
    }

}