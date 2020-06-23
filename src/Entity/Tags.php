<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var int
     *
     * @ORM\Column(name="Tags_Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tagsId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tag_First", type="string", length=50, nullable=true)
     */
    private $tagFirst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tag_Second", type="string", length=50, nullable=true)
     */
    private $tagSecond;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tag_Third", type="string", length=50, nullable=true)
     */
    private $tagThird;


}
