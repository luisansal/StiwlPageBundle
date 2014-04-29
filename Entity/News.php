<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 *
 * @ORM\Table(name="stiwl_page_news")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var \DateTime $disabledAt
     *
     * @ORM\Column(name="disabledAt", type="datetime", nullable=true)
     */
    protected $disabledAt;

    /**
     * @var \DateTime $disabledAt
     *
     * @ORM\Column(name="createdDateAt", type="date")
     */
    protected $createdDateAt;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="NewsLanguage", mappedBy="news", cascade={"all"}, orphanRemoval=true)
     * @Assert\Count(
     *      min = "1"
     * )
     */
    protected $languages;

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdatedAt() {
        $this->updatedAt = new \DateTime();
        if (!$this->getStatus()) {
            $this->disabledAt = new \DateTime();
        } else {
            $this->disabledAt = null;
        }
    }

    /**
     * This generate a row to the languages
     *
     * @param Stiwl\PageBundle\Entity\NewsLanguage $newsLanguage
     * @return News
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\NewsLanguage $newsLanguage) {
        $this->languages[] = $newsLanguage;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\NewsLanguage $newsLanguage
     * @return News
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\NewsLanguage $newsLanguage) {
        $this->languages[] = $newsLanguage;
        $newsLanguage->setNews($this);
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function __toString() {
        return '';
    }

    public function __construct() {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->status = true;
        $this->createdDateAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return News
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return News
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set disabledAt
     *
     * @param \DateTime $disabledAt
     * @return News
     */
    public function setDisabledAt($disabledAt) {
        $this->disabledAt = $disabledAt;

        return $this;
    }

    /**
     * Get disabledAt
     *
     * @return \DateTime 
     */
    public function getDisabledAt() {
        return $this->disabledAt;
    }

    /**
     * Set createdDateAt
     *
     * @param \DateTime $createdDateAt
     * @return News
     */
    public function setCreatedDateAt($createdDateAt) {
        $this->createdDateAt = $createdDateAt;

        return $this;
    }

    /**
     * Get createdDateAt
     *
     * @return \DateTime 
     */
    public function getCreatedDateAt() {
        return $this->createdDateAt;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return News
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Remove languages
     *
     * @param \Stiwl\PageBundle\Entity\NewsLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\NewsLanguage $languages) {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages() {
        return $this->languages;
    }

}