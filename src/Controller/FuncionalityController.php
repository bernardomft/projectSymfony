<?php
// src/Controller/FuncionalityController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SentTo;
use App\Entity\Users;
use App\Entity\Message;

class FuncionalityController extends AbstractController
{
    /**
     * @Route("/addFriends",  options={"expose"=true} , name="addFriends" ,methods={"POST", "GET"})
     * 
     */
    public function addFriend(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $param = json_decode($request->getContent());
            $message = new Message();
            $message2 = new Message();
            $user = $this->getUser();
            $destUser = $em->getRepository(Users::class)->findOneBy(['username' => $param[0]]);
            $fecha = new \DateTime(str_replace(' ', 'T', $param[1]));
            $message->setBody('asdfgh1234');
            $message->setTime($fecha);
            $message->setOriginUser($user);
            $em->persist($message);
            $sent_to = new SentTo();
            $sent_to->setIdMsg($message);
            $sent_to->setIdDestUser($destUser);
            $sent_to->setRead(false);
            $em->persist($sent_to);
            $message2->setBody('asdfgh1234');
            $message2->setTime($fecha);
            $message2->setOriginUser($destUser);
            $em->persist($message2);
            $sent_to2 = new SentTo();
            $sent_to2->setIdMsg($message2);
            $sent_to2->setIdDestUser($user);
            $sent_to2->setRead(false);
            $em->persist($sent_to2);
            $em->flush();
        }
        return new Response(json_encode($user->getCode()));
    }

     /**
     * @Route("/showProfile",  options={"expose"=true} , name="showProfile" ,methods={"POST", "GET"})
     * 
     */
    public function showProfile(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $params = json_decode($request->getContent());
            $destUser = $entityManager->getRepository(Users::class)->findOneBy(['username' => $params]);
            $arrayUser = [];
            array_push($arrayUser, $destUser->getName());
            array_push($arrayUser, $destUser->getAddress());
            array_push($arrayUser, $destUser->getEmail());
            array_push($arrayUser, $destUser->getPicture());
            return new Response(json_encode($arrayUser));
        }
    }

    /**
     * @Route("/updateProfile",  options={"expose"=true} , name="updateProfile" ,methods={"POST", "GET"})
     * 
     */
    public function updateProfile(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $params = json_decode($request->getContent());
            $destUser = $entityManager->getRepository(Users::class)->findOneBy(['username' => $params[0]]);
            $destUser->setName($params[1]);
            $destUser->setAddress($params[2]);
            $destUser->setEmail($params[3]);
            $entityManager->flush();
            return new Response(json_encode($params[4]));
        }
    }
}