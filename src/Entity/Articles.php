<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="Articles_Tags_Id", columns={"Articles_Tags_Id"}), @ORM\Index(name="Articles_Authors_Id", columns={"Articles_Authors_Id"})})
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
    private $articlesId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Articles_Date", type="datetime", nullable=false)
     */
    private $articlesDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Articles_Title", type="string", length=250, nullable=false)
     */
    private $articlesTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="Articles_Content", type="text", length=16777215, nullable=false)
     */
    private $articlesContent;

    /**
     * @var binary
     *
     * @ORM\Column(name="Articles_Image", type="binary", nullable=false)
     */
    private $articlesImage;

    /**
     * @var bool
     *
     * @ORM\Column(name="Articles_Edit", type="boolean", nullable=false)
     */
    private $articlesEdit;

    /**
     * @var int
     *
     * @ORM\Column(name="Articles_Votes", type="integer", nullable=false)
     */
    private $articlesVotes;

    /**
     * @var \Authors
     *
     * @ORM\ManyToOne(targetEntity="Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Articles_Authors_Id", referencedColumnName="Authors_Id")
     * })
     */
    private $articlesAuthors;

    /**
     * @var \Tags
     *
     * @ORM\ManyToOne(targetEntity="Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Articles_Tags_Id", referencedColumnName="Tags_Id")
     * })
     */
    private $articlesTags;


}
