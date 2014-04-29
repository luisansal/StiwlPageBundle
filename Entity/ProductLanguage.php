<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Stiwl\ShopcartBundle\Entity\ProductLanguage
 *
 * @ORM\Table(name="stiwl_page_products__languages")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\ProductLanguageRepository")
 */
class ProductLanguage {

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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="languages")
     */
    protected $product;

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
     * @return ProductLanguage
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
     * @return ProductLanguage
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
     * @return ProductLanguage
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
     * @return ProductLanguage
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
     * Set product
     *
     * @param \Stiwl\PageBundle\Entity\Product $product
     * @return ProductLanguage
     */
    public function setProduct(\Stiwl\PageBundle\Entity\Product $product = null) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Stiwl\PageBundle\Entity\Product
     */
    public function getProduct() {
        return $this->product;
    }

}