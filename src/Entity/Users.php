<?php
// src/Entity/Users.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity 
 * @ORM\Table(name="users")
*/
class Users implements UserInterface{
	/** @ORM\Column(type="integer")
	* 	@ORM\Id
	*   @ORM\GeneratedValue
	*/
	private $cod;
	/** @ORM\Column(type="string")*/
	private $username;
	/** @ORM\Column(type="string")*/	
	private $password;
	/** @ORM\Column(type="integer")*/
	private $role;



	public function getCod(){
		return $this->cod;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getRoles()  {
        if ($this->role==0) {
            return ['ROLE_USER'];
        } else {
            return ['ROLE_USER', 'ROLE_ADMIN'];
        }
    }

	public function setUsername($username){
		$this->username = $username;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setRole($role){
		$this->role = $role;
	}
	public function getSalt(){
		return null;
	}
	public function eraseCredentials(){
		return null; 
	}
}