<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $textSource;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="article_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @var Tag[]|Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="articles", cascade={"persist"})
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId(int $id): Article
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
     * @return Article
     */
    public function setTitle(string $title): Article
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
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Article
     */
    public function setText(string $text): Article
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextSource()
    {
        return $this->textSource;
    }

    /**
     * @param mixed $textSource
     * @return Article
     */
    public function setTextSource($textSource)
    {
        $this->textSource = $textSource;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @return Article
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Article
     */
    public function setPublished(bool $published): Article
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return Tag[]|Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): Article
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag[]|Collection $tags
     * @return Article
     */
    public function setTags($tags): Article
    {
        array_walk($tags, function(Tag $tag) {
            $tag->addArticle($this);
            $this->addTag($tag);
        });
        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
