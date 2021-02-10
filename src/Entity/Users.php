<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="USER_NAME", columns={"username"})})
 * @ORM\Entity
 */
class Users implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=30, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=80, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=15, nullable=false)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture", type="string", length=2000, nullable=true)
     */
    private $picture;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer", nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="Message" , mappedBy="originUser");
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity="SentTo" , mappedBy="idDestUser");
     */
    private $sentTo;

    /**
     * @ORM\OneToMany(targetEntity="GroupsUsers" , mappedBy="idUser");
     */
    private $groupsUser;

    public function __construct()
    {
        $this->message = new ArrayCollection();
        $this->sentTo = new ArrayCollection();
        $this->groupsUser = new ArrayCollection();
    }

     /**
	 * @return ArrayCollection
	 */
	public function getGroupUser(){
		return $this->groupsUser;	
	}

	/**
	 * @param ArrayCollection $groupsUser
	 */
	public function setGroupUser($groupsUser){
		$this->groupsUser = $groupsUser;
	}

     /**
	 * @return ArrayCollection
	 */
	public function getSentTo(){
		return $this->sentTo;	
	}

	/**
	 * @param ArrayCollection $sentTo
	 */
	public function setSentTo($sentTo){
		$this->sentTo = $sentTo;
	}

    /**
	 * @return ArrayCollection
	 */
	public function getMessages(){
		return $this->message;	
	}

	/**
	 * @param ArrayCollection $message
	 */
	public function setMessage($message){
		$this->message = $message;
	}

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSalt(){
		return null;
	}
    
    public function eraseCredentials(){
		return null; 
	}

    public function getRoles()  {
        if ($this->role==0) {
            return ['ROLE_USER'];
        } else {
            return ['ROLE_USER', 'ROLE_ADMIN'];
        }
    }
}
