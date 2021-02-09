<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="code_user", columns={"origin_user_id"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_msg", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMsg;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=1000, nullable=false)
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    private $time;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users" , inversedBy="message");
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origin_user_id", referencedColumnName="code")
     * })
     */
    private $originUser;

    /**
     * @ORM\OneToMany(targetEntity="SentTo" , mappedBy="idMsg")
     */
    private $sentTo;

    public function __construct()
    {
        $this->sentTo = new ArrayCollection();
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

    public function getIdMsg(): ?int
    {
        return $this->idMsg;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getOriginUser(): ?Users
    {
        return $this->originUser;
    }

    public function setOriginUser(?Users $originUser): self
    {
        $this->originUser = $originUser;

        return $this;
    }


}
