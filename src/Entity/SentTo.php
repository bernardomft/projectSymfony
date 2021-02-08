<?php
// src/Entity/SentTo.php
namespace App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity 
 * @ORM\Table(name="sent_to")
*/
class SentTo{
    /** @ORM\Column(name="code", type="integer", nullable=false)
	* 	@ORM\id
	*   @ORM\GeneratedValue
    */
    private $code_sent;

	/**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="sent_to")
     * @ORM\JoinColumn(name="id_msg", referencedColumnName="id_msg")
     **/
    private $id_msg;

    /**
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="sent_to")
     * @ORM\JoinColumn(name="id_dest_user", referencedColumnName="code")
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