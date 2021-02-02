<?php
// src/Entity/Groups.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="groups_users")
*/
class Groups{
	/** @ORM\Column(type="integer")
	* 	@ORM\id
	*   @ORM\GeneratedValue
    */
    private $id_group_user;
   	/**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="groups_users")
     * @ORM\JoinColumn(name="users", referencedColumnName="code")
     **/
	private $id_user;
	/**
     * @ORM\ManyToMany(targetEntity="groups", inversedBy="groups_users")
     * @ORM\JoinColumn(name="group", referencedColumnName="id_group")
     **/
    private $id_group;
   
    //getters

	public function getIdGroup(){
		return $this->id_group;
	}
	public function getIdUser(){
		return $this->id_user;
    }
    public function getIdGroupUser(){
		return $this->id_group_user;
    }

    //settes

	public function setIdGroup($id_group){
		$this->id_group = $id_group;
	}
	public function setIdUser($id_user){
		$this->id_user = $id_user;
    }
    public function setIdGroupUser($id_group_user){
		$this->id_group_user = $id_group_user;
    }
}