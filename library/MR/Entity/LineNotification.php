<?php
namespace MR\Entity;
/**
 * Description of LineNotification
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class LineNotification {

    /**
     *
     * @var integer $id
     * @Id @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     *
     * @var Line $line
     * @ManyToOne(targetEntity="Line", inversedBy="notifications")
     */
    private $line;

    /**
     *
     * @var integer $level
     * @Column(type="smallint")
     */
    private $level;

    /**
     *
     * @var string $content_em
     * @Column(type="string")
     */
    private $content_en;

    /**
     *
     * @var string $content_zh
     * @Column(type="string")
     */
    private $content_zh;

    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime");
     */
    private $ts_created;

    /**
     *
     * @var datetime $ts_last_updated
     * @Column(type="datetime", nullable=true)
     */
    private $ts_last_updated;

    /**
     * Constructor 
     */
    public function __construct() {
        $this->ts_created = new \DateTime();
    }

    /**
     * Setter of Line
     * @param Line $line 
     */
    public function setLine(Line $line) {
        $this->line = $line;
        $this->line->setNotification($this);
    }

    /**
     * Getter of Line
     * @return Line
     */
    public function getLine() {
        return $this->line;
    }

    /**
     * Setter of level
     * @param integer $level 
     */
    public function setLevel($level) {
        $this->level = (int) $level;
    }

    /**
     * Getter of level
     * @return integer
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Setter of Content English
     * @param string $content 
     */
    public function setContentEn($content) {
        $this->content_en = $content;
    }

    /**
     * Setter of Content Chinese
     * @param string $content 
     */
    public function setContentZh($content) {
        $this->content_zh = $content;
    }

    /**
     * Getter of Content English
     * @return string
     */
    public function getContentEn() {
        return $this->content_en;
    }

    /**
     * Getter of Content Chinese
     * @return string
     */
    public function getContentZh() {
        return $this->content_zh;
    }

    /**
     * Pre-Update method
     * @PreUpdate
     */
    public function preUpdate() {
        $this->ts_last_updated = new \DateTime('now');
    }

}
