<?php
// src/Controller/GetChatsController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GetChatsController extends AbstractController
{
    
    /**
     * @Route("/GetChats",  options={"expose"=true} , name="GetChats" ,methods={"POST", "GET"})
     * 
     */
    public function GetChats(Request $request)
    {
        //return new Response( 'hola');
        
        if ($request->isXmlHttpRequest()) {
            $username = $request->get('username');
            return new Response($username);
        }
        
    }
}
