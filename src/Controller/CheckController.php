<?php
// src/Controller/CheckController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class CheckController extends AbstractController{
/**
     * @Route("/CheckReadChats",  options={"expose"=true} , name="CheckReadChats" ,methods={"POST", "GET"})
     * 
     */
    public function CheckReadChats(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser()->getCode();
            $dest = json_decode($request->getContent());
            $repository = $this->getDoctrine()->getRepository(Users::class);
            $destino = $repository->findBy(array('username' => $dest));
            $arrayTmp = [];
            $arrayTmp2 = [];
            foreach ($destino as $a) {
                array_push($arrayTmp, $a->getMessages());
            }
            foreach ($arrayTmp as $a) {
                foreach ($a as $b) {
                    array_push($arrayTmp2, $b->getSentTo());
                }
            }
            $arrayTmp = [];
            foreach ($arrayTmp2 as $a) {
                foreach ($a as $b) {
                    if ($b->getIdDestUser()->getCode() == $user)
                        array_push($arrayTmp, $b->getRead());
                }
            }
            foreach ($arrayTmp as $a) {
                if (!$a)
                    return new Response(json_encode('false'));
            }

            return new Response(json_encode('true'));
        }
    }

    /**
     * @Route("/UpdateRead",  options={"expose"=true} , name="UpdateRead" ,methods={"POST", "GET"})
     * 
     */
    public function UpdateRead(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $tmp2 = [];
            $param = json_decode($request->getContent());
            $entityManager = $this->getDoctrine()->getManager();
            $destUser = $entityManager->getRepository(Users::class)->findBy(['username' => $param]);
            $messages_dest_user = $destUser[0]->getMessages();
            foreach ($messages_dest_user as $m) {
                $tmp = $m->getSentTo();
                foreach ($tmp as $t) {
                    if (
                        $t->getIdDestUser()->getCode() === $user->getCode() &&
                        $t->getRead() == 0
                    ) {
                        $t->setRead(true);
                        $entityManager->flush();
                        array_push($tmp2, $t->getRead());
                    }
                }
            }
            return new Response(json_encode($tmp2));
        }
    }


}