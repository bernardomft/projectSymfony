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
        //return new Response('hola');
        
        if ($request->isXmlHttpRequest()) {
            $tmp = $this->getUser();
            $message=$tmp->getMessages();
            $arrayTmp = [];
            foreach ($message as $a) {
            array_push($arrayTmp, $a->getIdMsg());
            }
            //$username = $request->get('username');
            return new Response(json_encode($arrayTmp));
        }
       
    }
}
