<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupsUsers
 *
 * @ORM\Table(name="groups_users", indexes={@ORM\Index(name="group_id", columns={"id_group"}), @ORM\Index(name="user_group", columns={"id_user"})})
 * @ORM\Entity
 */
class GroupsUsers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_group_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroupUser;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups", inversedBy="groupsUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_group", referencedColumnName="id_group")
     * })
     */
    private $idGroup;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="groupsUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="code")
     * })
     */
    private $idUser;

    public function getIdGroupUser(): ?int
    {
        return $this->idGroupUser;
    }

    public function getIdGroup(): ?Groups
    {
        return $this->idGroup;
    }

    public function setIdGroup(?Groups $idGroup): self
    {
        $this->idGroup = $idGroup;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
