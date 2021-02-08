<?php
// src/Entity/Message.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity 
 * @ORM\Table(name="message")
*/
class Message{
	/** @ORM\Column(type="integer")
	* 	@ORM\id
	*   @ORM\GeneratedValue
    */
    private $id_msg;
    /** @ORM\Column(type="string")*/
	private $body;
	/**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="messages")
     * @ORM\JoinColumn(name="origin_user_id", referencedColumnName="code")
     **/
	private $origin_user_id;

	/**
	 * @ORM\OneToMany(targetEntity="SentTo", mappedBy="id_msg")
	 */
	private $sent_to;


	/**
	 * Message constructor.
	 */
	public function __construct()
	{
		$this->origin_user_id = new ArrayCollection();
		$this->sent_to = new ArrayCollection();
	}

	public function getIdMsg(){
		return $this->id_msg;
	}
	public function getBody(){
		return $this->body;
	}
	 /**
     * @return mixed
     */
    public function getOriginUserId()
    {
        return $this->origin_user_id;
    }

	 /**
     * @return ArrayCollection
     */
    public function getSentTo()
    {
        return $this->sent_to;
    }

	public function setBody($body){
		$this->body = $body;
	}

	/**
     * @param mixed $origin_user_id
     */
	public function setOriginUserId($origin_user_id){
		$this->origin_user_id = $origin_user_id;
	}

	/**
     * @param mixed $sent_to
     */
	public function setSentTo($sent_to){
		$this->sent_to = $sent_to;
	}


}