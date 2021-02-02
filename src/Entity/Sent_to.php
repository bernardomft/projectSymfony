<?php
// src/Entity/Sent_to.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="sent_to")
*/
class Message{
    /** @ORM\Column(name="code", type="integer", nullable=false)
	* 	@ORM\id
	*   @ORM\GeneratedValue
    */
    private $code_sent;
	/**
     * @ORM\ManyToMany(targetEntity="Message", inversedBy="sent_to")
     * @ORM\JoinColumn(name="message", referencedColumnName="id_msg")
     **/
    private $id_msg;
    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="sent_to")
     * @ORM\JoinColumn(name="user", referencedColumnName="code")
     **/
    private $id_dest_user;
    /** @ORM\Column(type="string")*/
	private $read;

    

    //getters

	public function getIdMsg(){
		return $this->id_msg;
	}
	public function getCodeSent(){
		return $this->code_sent;
    }
    public function getRead()
    {
        return $this->read;
    }
	 /**
     * @return mixed
     */
    public function getIdDestUser()
    {
        return $this->id_dest_user;
    }

    //Setters

	public function setIdMsg($id_msg){
		$this->id_msg = $id_msg;
    }
    public function setCodeSent($code_sent){
		$this->code_sent = $code_sent;
    }
    public function setRead($read){
		$this->read = $read;
	}

	/**
     * @param mixed $id_dest_user
     */
	public function setIdDestUser($id_dest_user){
		$this->id_dest_user = $id_dest_user;
	}


}