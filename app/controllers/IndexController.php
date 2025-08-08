<?php 
    namespace app\controllers;

    class IndexController {
        public function __construct(){
            $this->index();
        }
        public function index() {
          include_once __DIR__.DIRECTORY_SEPARATOR.'../views/index/index.php';
        }
    }
     
 ?>
