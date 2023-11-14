<?php 

namespace App\Controller ;

use Symfony\Component\HttpFoundation\Response;

class Home{

    public function index() :Response{
        return new Response("un peu de texte"); 
    }
}