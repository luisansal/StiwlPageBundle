<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Stiwl\ShopcartBundle\Entity\CategoryLanguage
 *
 * @ORM\Table(name="stiwl_page_menus__languages")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\MenuLanguageRepository")
 */
class MenuLanguage {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     *
     * @var type 
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     *
     * @var type 
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=250, unique=true)
     */
    protected $slug;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="languages")
     */
    protected $menu;

    /**
     *
     * @var type 
     * @ORM\Column(name="language", type="string", length=5)
     */
    protected $language;

    public function __toString() {
        return '';
    }

    public function __construct() {
        
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
     * Set name
     *
     * @param string $name
     * @return MenuLanguage
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MenuLanguage
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return MenuLanguage
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return MenuLanguage
     */
    public function setLanguage($language) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Set menu
     *
     * @param \Stiwl\PageBundle\Entity\Menu $menu
     * @return MenuLanguage
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

}