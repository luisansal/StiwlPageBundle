<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stiwl\ShopcartBundle\Entity\Service
 *
 * @ORM\Table(name="stiwl_page_products")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var type 
     * @ORM\Column(name="name", type="string", length=50)

      protected $name; */
    /**
     *
     * @var type 
     * @ORM\Column(name="slug", type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"name"})

      protected $slug; */
    /**
     *
     * @var type 
     * @ORM\Column(name="description", type="text")

      protected $description; */

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    protected $price;

    /**
     *
     * @var type 
     * @ORM\Column(name="stock", type="integer")

      protected $stock; */
    /**
     * @var integer $categories
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products");
     * @ORM\JoinTable(name="products_categories",
     *  joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     * @Assert\NotBlank()
     * @Assert\Count(
     *      min = "1"
     * )

      protected $categories; */

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    protected $image;

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
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="ProductLanguage", mappedBy="product", cascade={"all"}, orphanRemoval=true)
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
     * @param Stiwl\PageBundle\Entity\ProductLanguage $languages
     * @return Product
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\ProductLanguage $productLanguages) {
        $this->languages[] = $productLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\ProductLanguage $languages
     * @return Product
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\ProductLanguage $productLanguages) {
        $this->languages[] = $productLanguages;
        $productLanguages->setProduct($this);
        return $this;
    }

    public function __toString() {
        return '';
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->status = true;
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
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
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set status
     *
     * @param boolean $status
     * @return Product
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
     * Set category
     *
     * @param \Stiwl\PageBundle\Entity\Category $category
     * @return Product
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

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Product
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Remove languages
     *
     * @param \Stiwl\PageBundle\Entity\ProductLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\ProductLanguage $languages) {
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