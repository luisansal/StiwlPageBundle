<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * HeaderImage
 *
 * @ORM\Table(name="stiwl_page_header_images")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\HeaderImageRepository")
 */
class HeaderImage {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)

      private $description; */

    /**
     *
     * @var type 
     * @ORM\Column(name="position",type="smallint")
     */
    protected $position;

    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="HeaderImageLanguage", mappedBy="headerImage", cascade={"all"}, orphanRemoval=true)
     * @Assert\Count(
     *      min = "1"
     * )
     */
    protected $languages;

    /**
     * This generate a row to the languages
     *
     * @param Stiwl\PageBundle\Entity\HeaderImageLanguage $languages
     * @return HeaderImage
     */
    public function addLanguages(\Stiwl\PageBundle\Entity\HeaderImageLanguage $headerImageLanguages) {
        $this->languages[] = $headerImageLanguages;
        return $this;
    }

    /**
     * Add languages
     *
     * @param Stiwl\PageBundle\Entity\HeaderImageLanguage $languages
     * @return HeaderImage
     */
    public function addLanguage(\Stiwl\PageBundle\Entity\HeaderImageLanguage $headerImageLanguages) {
        $this->languages[] = $headerImageLanguages;
        $headerImageLanguages->setHeaderImage($this);
        return $this;
    }

    public function __toString() {
        return '';
    }

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
     * Set position
     *
     * @param integer $position
     * @return HeaderImage
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
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return HeaderImage
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
     * @param \Stiwl\PageBundle\Entity\HeaderImageLanguage $languages
     */
    public function removeLanguage(\Stiwl\PageBundle\Entity\HeaderImageLanguage $languages) {
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