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
 * @ORM\Table(name="stiwl_page_categories__languages")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\CategoryLanguageRepository")
 */
class CategoryLanguage {

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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="languages")
     */
    protected $category;

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
     * @return CategoryLanguage
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
     * @return CategoryLanguage
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
     * @return CategoryLanguage
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
     * @return CategoryLanguage
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
     * Set category
     *
     * @param \Stiwl\PageBundle\Entity\Category $category
     * @return CategoryLanguage
     */
    public function setCategory(\Stiwl\PageBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Stiwl\PageBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

}