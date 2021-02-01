<?php
// src/Entity/Groups.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="groups")
*/
class Groups{
	/** @ORM\Column(type="integer")
	* 	@ORM\id_group
	*   @ORM\GeneratedValue
    */
    private $id_group;
    /** @ORM\Column(type="string")*/
	private $id_msg;
	/** @ORM\Column(type="integer")*/
    private $id_user;
    /** @ORM\Column(type="name")*/
	private $name;



	public function getIdGroup(){
		return $this->id_group;
	}
	public function getIdMsg(){
		return $this->id_msg;
	}
	public function getIdUser(){
		return $this->id_user;
    }
    public function getName(){
		return $this->name;
	}

	public function setIdmsg($id_msg){
		$this->id_msg = $id_msg;
	}
	public function setIdUser($id_user){
		$this->id_user = $id_user;
    }
    public function setName($name){
		$this->name = $name;
    }
}