<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Stiwl\ShopcartBundle\Entity\NewsLanguage
 *
 * @ORM\Table(name="stiwl_page_news__languages")
 * @ORM\Entity(repositoryClass="Stiwl\PageBundle\Repository\NewsLanguageRepository")
 */
class NewsLanguage {

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
    protected $title;

    /**
     *
     * @var type 
     * @ORM\Column(name="description", type="text")
     */
    protected $content;

    /**
     *
     * @var type 
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=250, unique=true)
     */
    protected $slug;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="News", inversedBy="languages")
     */
    protected $news;

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
     * Set title
     *
     * @param string $title
     * @return NewsLanguages
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return NewsLanguages
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NewsLanguages
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
     * @return NewsLanguages
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
     * Set news
     *
     * @param \Stiwl\PageBundle\Entity\News $news
     * @return NewsLanguages
     */
    public function setNews(\Stiwl\PageBundle\Entity\News $news = null) {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Stiwl\PageBundle\Entity\News
     */
    public function getNews() {
        return $this->news;
    }

}