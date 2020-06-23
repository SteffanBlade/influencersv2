<?php

namespace App\Entity;

use Cassandra\Blob;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="Articles_Authors_Id", columns={"Articles_Authors_Id"}), @ORM\Index(name="Articles_Tags_Id", columns={"Articles_Tags_Id"})})
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="Articles_Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $articlesId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Articles_Date", type="datetime", nullable=false)
     */
    public $articlesDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Articles_Title", type="string", length=250, nullable=false)
     */
    public $articlesTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="Articles_Content", type="text", length=16777215, nullable=false)
     */
    public $articlesContent;

    /**
     * @var string
     *
     * @ORM\Column(name="Articles_Image", type="blob", length=65535, nullable=false)
     */
    public $articlesImage;

    public function getPhoto()
    {
        return imagecreatefromstring($this->articlesImage);
    }

    public function displayPhoto()
    {
        rewind($this->getPhoto());
        return "data:image/jpg;base64," . base64_encode(stream_get_contents($this->getPhoto()));
    }

    /**
     * @return string
     */
    public function getArticlesImage(): string
    {
        return $this->articlesImage;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="Articles_Edit", type="boolean", nullable=false)
     */
    public $articlesEdit;

    /**
     * @var int
     *
     * @ORM\Column(name="Articles_Votes", type="integer", nullable=false)
     */
    public $articlesVotes;



    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Articles_Authors_Id", referencedColumnName="Authors_Id")
     * })
     */
    public $articlesAuthors;



    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Articles_Tags_Id", referencedColumnName="Tags_Id")
     * })
     */
    public $articlesTags;


}
