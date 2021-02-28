<?php
// src/Controller/SendController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SentTo;
use App\Entity\Users;
use App\Entity\Message;
use App\Entity\Groups;

class SendController extends AbstractController{
    /**
     * @Route("/sendMessage",  options={"expose"=true} , name="sendMessage" ,methods={"POST", "GET"})
     * 
     */
    public function sendMessage(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $params = json_decode($request->getContent());
            $destUser = $entityManager->getRepository(Users::class)->findOneBy(['username' => $params[0]]);
            $params[2] = new \DateTime(str_replace(' ', 'T', $params[2]));
            $msg = new Message();
            $msg->setBody($params[1]);
            $msg->setTime($params[2]);
            $msg->setOriginUser($this->getUser());
            $entityManager->persist($msg);
            $sent_to = new SentTo();
            $sent_to->setIdMsg($msg);
            $sent_to->setIdDestUser($destUser);
            $sent_to->setRead(false);
            $entityManager->persist($sent_to);
            $entityManager->flush();
            return new Response(json_encode('mensaje enviado'));
        }
    }

    /**
     * @Route("/sendMessageGroup",  options={"expose"=true} , name="sendMessageGroup" ,methods={"POST", "GET"})
     * 
     */
    public function sendMessageGroup(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $params = json_decode($request->getContent());
            $group_name = $entityManager->getRepository(Groups::class)->findOneBy(['name' => $params[0]]);
            $params[2] = new \DateTime(str_replace(' ', 'T', $params[2]));
            $msg = new Message();
            $msg->setBody($params[1]);
            $msg->setTime($params[2]);
            $msg->setOriginUser($this->getUser());
            $entityManager->persist($msg);
            $group = new Groups();
            $group->setIdMsg($msg);
            $group->setIdUser($this->getUser()->getCode());
            $group->setName($params[0]);
            $entityManager->persist($group);
            $entityManager->flush();
            return new Response(json_encode('mensaje enviado'));
        }
    }

    /** @Route("/sendDiffMessage",  options={"expose"=true} , name="sendDiffMessage" ,methods={"POST", "GET"})
     * 
     */
    public function sendDiffMessage(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $originUser = $this->getUser();
            $params = json_decode($request->getContent());
            $body = $params[0];
            $date = new \DateTime(str_replace(' ', 'T', $params[1]));
            $arrayDest = $params[2];
            foreach ($arrayDest as $d) {
                $destUser = $entityManager->getRepository(Users::class)->findOneBy(['username' => $d]);
                $msg = new Message();
                $msg->setBody($body);
                $msg->setTime($date);
                $msg->setOriginUser($originUser);
                $entityManager->persist($msg);
                $sent_to = new SentTo();
                $sent_to->setIdMsg($msg);
                $sent_to->setIdDestUser($destUser);
                $sent_to->setRead(false);
                $entityManager->persist($sent_to);
                $entityManager->flush();
            }
            return new Response(json_encode('mensajes de difusion enviado'));
        }
    }
}