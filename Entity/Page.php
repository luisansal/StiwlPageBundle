<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table(name="stiwl_page_pages")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\PageRepository")
 */
class Page {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45)
     * @Assert\NotBlank()

      protected $title; */
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()

      protected $content; */

    /**
     *
     * @var type 
     * @ORM\OneToOne(targetEntity="Menu", inversedBy="page", cascade={"persist"})
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    protected $menu;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="PageLanguage", mappedBy="page", cascade={"all"}, orphanRemoval=true)
     * @Assert\Count(
     *      min = "1"
     * )
     */
    protected $languages;

    /**
     * This generate a row to the languages
     *
     * @param Stiwl\PageBundle\Entity\PageLanguage $languages
     * @return Page
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\PageLanguage $pageLanguages) {
        $this->languages[] = $pageLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\PageLanguage $languages
     * @return Page
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\PageLanguage $pageLanguages) {
        $this->languages[] = $pageLanguages;
        $pageLanguages->setPage($this);
        return $this;
    }

    public function __toString() {
        return '';
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set menu
     *
     * @param \Stiwl\PageBundle\Entity\Menu $menu
     * @return Page
     */
    public function setMenu(\Stiwl\PageBundle\Entity\Menu $menu = null) {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Stiwl\PageBundle\Entity\Menu
     */
    public function getMenu() {
        return $this->menu;
    }

    /**
     * Remove languages
     *
     * @param \Stiwl\PageBundle\Entity\PageLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\PageLanguage $languages) {
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