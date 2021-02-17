<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SentTo
 *
 * @ORM\Table(name="sent_to", indexes={@ORM\Index(name="message_id", columns={"id_msg"}), @ORM\Index(name="message_des", columns={"id_dest_user"})})
 * @ORM\Entity
 */
class SentTo
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_sent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeSent;

    /**
     * @var bool
     *
     * @ORM\Column(name="`read`", type="boolean", nullable=false)
     */
    private $read;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users" , inversedBy="sentTo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dest_user", referencedColumnName="code")
     * })
     */
    private $idDestUser;

    /**
     * @var \Message
     *
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="sentTo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_msg", referencedColumnName="id_msg")
     * })
     */
    private $idMsg;

    public function getCodeSent(): ?int
    {
        return $this->codeSent;
    }

    public function getRead(): ?bool
    {
        return $this->read;
    }

    public function setRead(bool $read): self
    {
        $this->read = $read;

        return $this;
    }

    public function getIdDestUser(): ?Users
    {
        return $this->idDestUser;
    }

    public function setIdDestUser(?Users $idDestUser): self
    {
        $this->idDestUser = $idDestUser;

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
