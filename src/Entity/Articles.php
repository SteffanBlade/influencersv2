<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="Articles_Tags_Id", columns={"Articles_Tags"}), @ORM\Index(name="Articles_Authors_Id", columns={"Articles_Authors_Id"})})
 * @ORM\Entity(repositoryClass = "App\Repository\ArticlesRepository")
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
     * @var string
     *
     * @ORM\Column(name="Articles_Tags", type="string", length=255, nullable=false)
     */
    public $articlesTags;

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
     * @var string|null
     *
     * @ORM\Column(name="Articles_Image", type="blob", length=0, nullable=true)
     */
    public $articlesImage;

    /**
     * @var int
     *
     * @ORM\Column(name="Articles_Votes", type="integer", nullable=false)
     */
    public $articlesVotes;

    /**
     * @param int $articlesVotes
     */
    public function setArticlesVotes(): void
    {
        $this->articlesVotes = $this->articlesVotes+1;
    }

    /**
     * @var \Authors
     *
     * @ORM\ManyToOne(targetEntity="Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Articles_Authors_Id", referencedColumnName="Authors_Id")
     * })
     */
    public $articlesAuthors;


}
