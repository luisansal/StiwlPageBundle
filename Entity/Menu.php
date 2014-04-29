<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Menu
 *
 * @ORM\Table(name="stiwl_page_menus")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\MenuRepository")
 */
class Menu {

    //uniqueConstraints={@ORM\UniqueConstraint(name="unique_menu",columns={"position"})}
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
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank()

      protected $name; */
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     * @Assert\NotBlank()

      protected $description; */
    /**
     *
     * @var type 
     * @ORM\Column(name="slug", type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"name"})

      protected $slug; */

    /**
     *
     * @var type 
     * @ORM\OneToOne(targetEntity="Page", mappedBy="menu")
     */
    protected $page;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     * */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * */
    protected $parent;

    /**
     *
     * @var type 
     * @ORM\Column(name="position", type="smallint")
     */
    protected $position;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="MenuLanguage", mappedBy="menu", cascade={"all"}, orphanRemoval=true)
     * @Assert\Count(
     *      min = "1"
     * )
     */
    protected $languages;

    /**
     * This generate a row to the languages
     *
     * @param Stiwl\PageBundle\Entity\MenuLanguage $languages
     * @return Menu
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\MenuLanguage $menuLanguages) {
        $this->languages[] = $menuLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\MenuLanguage $languages
     * @return Menu
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\MenuLanguage $menuLanguages) {
        $this->languages[] = $menuLanguages;
        $menuLanguages->setMenu($this);
        return $this;
    }

    public function __toString() {
        return '';
    }

    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set position
     *
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Set page
     *
     * @param \Stiwl\PageBundle\Entity\Page $page
     * @return Menu
     */
    public function setPage(\Stiwl\PageBundle\Entity\Page $page = null) {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Stiwl\PageBundle\Entity\Page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Add children
     *
     * @param \Stiwl\PageBundle\Entity\Menu $children
     * @return Menu
     */
    public function addChildren(\Stiwl\PageBundle\Entity\Menu $children) {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Stiwl\PageBundle\Entity\Menu $children
     */
    public function removeChildren(\Stiwl\PageBundle\Entity\Menu $children) {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Stiwl\PageBundle\Entity\Menu $parent
     * @return Menu
     */
    public function setParent(\Stiwl\PageBundle\Entity\Menu $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Stiwl\PageBundle\Entity\Menu
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Remove languages
     *
     * @param \Stiwl\PageBundle\Entity\MenuLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\MenuLanguage $languages) {
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