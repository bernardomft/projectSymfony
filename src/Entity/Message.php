<?php
// src/Entity/Message.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="message")
*/
class Message{
	/** @ORM\Column(type="integer")
	* 	@ORM\id_msg
	*   @ORM\GeneratedValue
    */
    private $id_msg;
    /** @ORM\Column(type="string")*/
	private $body;
	/** @ORM\Column(type="integer")*/
	private $origin_user_id;



	public function getIdMsg(){
		return $this->id_msg;
	}
	public function getBody(){
		return $this->body;
	}
	public function getOriginUserId(){
		return $this->origin_user_id;
	}

	public function setBody($body){
		$this->body = $body;
	}
	public function setOriginUserId($origin_user_id){
		$this->origin_user_id = $origin_user_id;
	}
}