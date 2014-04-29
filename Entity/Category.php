<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stiwl\PageBundle\Entity\Category
 *
 * @ORM\Table(name="stiwl_page_categories")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category {

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
     * @ORM\Column(name="description", type="string", length=200)

      protected $description; */

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $products;

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
     * @ORM\OneToMany(targetEntity="CategoryLanguage", mappedBy="category", cascade={"all"}, orphanRemoval=true)
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
     * @param Stiwl\PageBundle\Entity\CategoryLanguage $languages
     * @return Category
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\CategoryLanguage $categoryLanguages) {
        $this->languages[] = $categoryLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\CategoryLanguage $languages
     * @return Category
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\CategoryLanguage $categoryLanguages) {
        $this->languages[] = $categoryLanguages;
        $categoryLanguages->setCategory($this);
        return $this;
    }

    public function __toString() {
        return '';
    }

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = true;
        $this->createdAt = new \Datetime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * Add products
     *
     * @param \Stiwl\PageBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\Stiwl\PageBundle\Entity\Product $products) {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Stiwl\PageBundle\Entity\Product $products
     */
    public function removeProduct(\Stiwl\PageBundle\Entity\Product $products) {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * Remove languages
     *
     * @param \Stiwl\PageBundle\Entity\CategoryLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\CategoryLanguage $languages) {
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