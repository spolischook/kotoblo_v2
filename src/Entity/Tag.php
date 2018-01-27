<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @var Article[]|Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="tags")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Tag
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Tag
     */
    public function setTitle(string $title): Tag
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return Tag
     */
    public function setWeight(int $weight): Tag
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return Article[]|Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     * @return Tag
     */
    public function addArticle(Article $article): Tag
    {
        $this->articles->add($article);
        return $this;
    }

    /**
     * @param Article[]|Collection $articles
     * @return Tag
     */
    public function setArticles($articles): Tag
    {
        $this->articles = $articles;
        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
