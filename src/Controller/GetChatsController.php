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
use Symfony\Component\Validator\Constraints\IsFalse;

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
             foreach($arrayTmp as $a){
                 if(!$a)
                    return new Response(json_encode('false'));
             }
            
            return new Response(json_encode('true'));
        }
    }

    /**
     * @Route("/GetConversation",  options={"expose"=true} , name="GetConversation" ,methods={"POST", "GET"})
     * 
     */
    public function GetConversation(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            
            $param=json_decode($request->getContent());
            $entityManager = $this->getDoctrine()->getManager();
            $destCode = $entityManager->getRepository(Users::class)->findBy(['username' => $param]);
            $user = $this->getUser()->getMessages();
            $arrayTmp = [];
            $arrayTmp2 = [];
            foreach($user as $a){
                $tmp = $a->getSentTo();
                foreach($tmp as $b){
                    foreach($b as $c){
                        if($c->getIdDestUser()->getCode() === $destCode[0]->getCode()){

                        }
                    }
                }
                //if($a->getSentTo()->getIdDestUser()->getCode() ==$destCode[0]->getCode())
                    array_push($arrayTmp, $a->getSentTo());
            }
            foreach($arrayTmp as $a){
                foreach($a as $b){
                    array_push($arrayTmp2, $b->getIdDestUser()->getCode());
                }
            }

            return new Response(json_encode($arrayTmp2));
        }
    }

    /**
     * @Route("/GetGroups",  options={"expose"=true} , name="GetGroups" ,methods={"POST", "GET"})
     * 
     */
    public function GetGroups(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $groups = $user->getGroupUser();
            $arrayTmp = [];
            foreach($groups as $a){
                if(!(in_array($a->getIdGroup()->getName(),$arrayTmp)))
                    array_push($arrayTmp, $a->getIdGroup()->getName());
            }

            return new Response(json_encode($arrayTmp));
        }
    }

}
