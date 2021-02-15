<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('main');
             //return $this->render('main.html.twig');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/signUp", name="signUp",  options={"expose"=true})
     */
    public function signUp(Request $request)
    {
        
        if ($request->isXmlHttpRequest())
        {
            $param=json_decode($request->getContent());
            $user = new Users();
            $user->setUsername($param[0]); 
            $user->setName($param[1]); 
            $user->setSurname($param[2]); 
            $user->setEmail($param[3]); 
            $user->setPassword($param[4]);
            $user->setAddress('');
            $user->setPicture('');
            $user->setRole(0);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

        }
       
        return new Response(json_encode($param[0]));
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}