<?php
// src/Controller/MainControler.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Users;


/**
  *  @IsGranted("ROLE_USER")
*/
class MainControler extends AbstractController{
     
    /**
     * @Route("/main", name="main")	 
     */
	 public function main(){
        $tmp = $this->getUser();
        $tmp_2 = $tmp->getMessages();
        $tmp = $tmp->getUsername();
        $arrayTmp = [];
        foreach( $tmp_2 as $a ){
          array_push($arrayTmp, $a->getBody());
        } 
        //return new Response('<html><body>'. $tmp.'</body></html>');
        return $this->render('main.html.twig',array('username' => $tmp));
        //return new Response('<html><body>'.print_r($arrayTmp).'</body></html>');
	 }

	 
}