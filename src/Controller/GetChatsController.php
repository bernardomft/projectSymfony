<?php
// src/Controller/GetChatsController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SentTo;

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
            //$sent_to = $tmp->getSentTo();
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

            $arrayTmp = [];
            $entityManager = $this->getDoctrine()->getManager();
            $eq = $entityManager->find(SentTo::class, 1);
            $repository = $this->getDoctrine()->getRepository(SentTo::class);
            $destino = $repository->findBy(array('idDestUser' =>$tmp->getCode() ));
            //$username = $request->get('username');
            foreach($destino as $a){
                array_push($arrayTmp3, $a->getIdMsg());
            }
            foreach($arrayTmp3 as $a){
                array_push($arrayTmp, $a->getOriginUser());
            }
            $arrayTmp3 = [];
            foreach($arrayTmp as $a){
                array_push($arrayTmp3, $a->getUsername());
            }
            return new Response(json_encode($arrayTmp3));
        }
       
    }
}
