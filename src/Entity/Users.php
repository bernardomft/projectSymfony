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

	/**
     * @var int
     *
     * @ORM\Column(name="CodRes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
	private $cod;
	/** @ORM\Column(type="string")*/
	private $name;
	/** @ORM\Column(type="string")*/	
	private $surname;
	/** @ORM\Column(type="string")*/
	private $email;
	/** @ORM\Column(type="string")*/	
	private $password;
	/** @ORM\Column(type="string")*/	
	private $address;
	/** @ORM\Column(type="string")*/	
	private $username;
	/** @ORM\Column(type="string")*/	
	private $picture;
	/** @ORM\Column(type="integer")*/
	private $role;

	public function getCod(){
		return $this->cod;
	}
	public function getName(){
		return $this->name;
	}
	public function getSurname(){
		return $this->surname;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getAddress(){
		return $this->address;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getPicture(){
		return $this->picture;
	}
	public function getRoles()  {
        if ($this->role==0) {
            return ['ROLE_USER'];
        } else {
            return ['ROLE_USER', 'ROLE_ADMIN'];
        }
    }

	public function setName($name){
		$this->name = $name;
	}
	public function setSurname($surname){
		$this->surname = $surname;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setAddress($address){
		$this->address = $address;
	}
	public function setUsername($username){
		$this->username = $username;
	}
	public function setPicture($picture){
		$this->picture = $picture;
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