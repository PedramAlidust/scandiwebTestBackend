<?php

/*App Core Class
 *Creates url and loads core controller
 *URl format - /controller/method/params 
 */

class Core
{
    protected $currentController = 'Products';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {

        $url = $this->getUrl();

        //Look in controllers for first value
        if (file_exists('app/controllers/' . ucwords($url[1]) . '.php')) {
            //If exists, set as controller
            $this->currentController = ucwords($url[1]);
            //Unset 1 Index
            unset($url[1]);
        }

        //Require the controller
        require_once 'app/controllers/' . $this->currentController . '.php';

        //Instantiate controller class
        $this->currentController = new $this->currentController;

        //Check for second part of url
        if (isset($url[2])) {
            if (method_exists($this->currentController, $url[2])) {
                $this->currentMethod = $url[2];
                //Unset index 2
                unset($url[2]);
            }
        }

        //Get params
        $this->params = $url ? array_values($url) : [];

        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            $url = explode('/', $url);
            unset($url[0]);
            return $url;
        }
    }
}