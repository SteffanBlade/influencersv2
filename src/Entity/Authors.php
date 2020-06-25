<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Authors
 *
 * @ORM\Table(name="authors")
 * @ORM\Entity
 */
class Authors
{
    /**
     * @var int
     *
     * @ORM\Column(name="Authors_Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $authorsId;

    /**
     * @var int
     *
     * @ORM\Column(name="Authors_Votes", type="integer", nullable=false)
     */
    public $authorsVotes;

    /**
     * @param int $authorsVotes
     */
    public function setAuthorsVotes(): void
    {
        $this->authorsVotes = $this->authorsVotes + 1;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="Authors_Name", type="string", length=255, nullable=false)
     */
    public $authorsName;

    /**
     * @var string
     *
     * @ORM\Column(name="Authors_Email", type="string", length=320, nullable=false)
     */
    public $authorsEmail;


}
