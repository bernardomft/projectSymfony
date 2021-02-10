<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Groups
 *
 * @ORM\Table(name="groups", indexes={@ORM\Index(name="message_id", columns={"id_msg"}), @ORM\Index(name="user_group", columns={"id_user"})})
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_group", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroup;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var \Message
     *
     * @ORM\ManyToOne(targetEntity="Message")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_msg", referencedColumnName="id_msg")
     * })
     */
    private $idMsg;

    /**
     * @ORM\OneToMany(targetEntity="GroupsUsers" , mappedBy="idGroup");
     */    
    private $groupUser;

    public function __construct()
    {
        $this->groupUser = new ArrayCollection();
    }

    /**
	 * @return ArrayCollection
	 */
	public function getGroupUser(){
		return $this->groupsUser;	
	}

	/**
	 * @param ArrayCollection $groupUser
	 */
	public function setGroupUser($groupUser){
		$this->groupUser = $groupUser;
	}


    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
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

    public function getIdMsg(): ?Message
    {
        return $this->idMsg;
    }

    public function setIdMsg(?Message $idMsg): self
    {
        $this->idMsg = $idMsg;

        return $this;
    }


}
