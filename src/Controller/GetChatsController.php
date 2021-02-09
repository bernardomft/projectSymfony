<?php
// src/Controller/GetChatsController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SentTo;
use App\Entity\Users;
use App\Entity\Message;

class GetChatsController extends AbstractController
{
    
    /**
     * @Route("/GetChats",  options={"expose"=true} , name="GetChats" ,methods={"POST", "GET"})
     * 
     */
    public function GetChats(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $tmp = $this->getUser();
            $message=$tmp->getMessages();
            $arrayTmp = [];
            $arrayTmp2 = [];
            $arrayTmp3 = [];
            foreach ($message as $a) {
                array_push($arrayTmp, $a->getSentTo());
            }
            foreach ($arrayTmp as $a) {
                foreach($a as $b){
                    array_push($arrayTmp2, $b->getIdDestUser());
                }
            }
            $arrayTmp = [];
            foreach ($arrayTmp2 as $a) {
                if(!(in_array($a->getUsername(),$arrayTmp)))
                    array_push($arrayTmp, $a->getUsername());
            }
            $arrayTmp2 = [];
            $repository = $this->getDoctrine()->getRepository(SentTo::class);
            $destino = $repository->findBy(array('idDestUser' =>$tmp->getCode() ));
            foreach($destino as $a){
                array_push($arrayTmp3, $a->getIdMsg());
            }
            foreach($arrayTmp3 as $a){
                array_push($arrayTmp2, $a->getOriginUser());
            }
            $arrayTmp3 = [];
            foreach($arrayTmp2 as $a){
                if(!(in_array($a->getUsername(),$arrayTmp)))
                    array_push($arrayTmp, $a->getUsername());
            }
            return new Response(json_encode($arrayTmp));
        }
    }

     /**
     * @Route("/CheckReadChats",  options={"expose"=true} , name="CheckReadChats" ,methods={"POST", "GET"})
     * 
     */
    public function CheckReadChats(Request $request){
        if ($request->isXmlHttpRequest()){
            $user = $this->getUser()->getCode();
            $dest=json_decode($request->getContent());
            $repository = $this->getDoctrine()->getRepository(Users::class);
            $destino = $repository->findBy(array('username' => $dest));
            $arrayTmp = [];
            $arrayTmp2 = [];
            foreach($destino as $a){
               array_push($arrayTmp, $a->getMessages());
            }
            foreach($arrayTmp as $a){
                foreach($a as $b){
                    array_push($arrayTmp2, $b->getSentTo());
                }
             }
             $arrayTmp = [];  
             foreach($arrayTmp2 as $a){
                foreach($a as $b){
                    if($b->getIdDestUser()->getCode() == $user)
                        array_push($arrayTmp, $b->getRead());
                }
             }
             foreach($arrayTmp2 as $a){
                 if($a === 'false')
                    return new Response(json_encode('false'));
             }
            
            return new Response(json_encode('true'));
        }
    }
}
