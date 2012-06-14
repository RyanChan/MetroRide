<?php
namespace MR\Entity;
/**
 * Description of LineProfile
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class LineProfile {
    /**
     *
     * @var integer $id
     * @Id @GeneratedValue
     * @Column(type="bigint")
     */
    private $id;
    /**
     *
     * @var Line $line
     * @ManyToOne(targetEntity="Line", inversedBy="profile")
     */
    private $line;
    /**
     *
     * @var string $profile_key
     * @Column(type="string")
     */
    private $profile_key;
    /**
     *
     * @var text $profile_value
     * @Column(type="text", nullable=true)
     */
    private $profile_value;
    
    public function __construct() {
        
    }
    
    public function setLine(Line $line){
        $this->line = $line;
        $this->line->setProfile($this);
    }
    
    public function setProfileKey($key){
        $this->profile_key = $key;
    }
    
    public function setProfileValue($value){
        $this->profile_value = $value;
    }
    
    public function getProfileKey(){
        return $this->profile_key;
    }
    
    public function getProfileValue(){
        return $this->profile_value;
    }
    /**
     * @PostUpdate 
     */
    public function updateDatetime(){
        $this->line->updateDatetime();
    }
}
