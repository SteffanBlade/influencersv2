<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Authors
 *
 * @ORM\Table(name="authors")
 * @ORM\Entity
 */
class Authors
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getVotes(): int
    {
        return $this->votes;
    }

    /**
     * @param int $votes
     */
    public function setVotes(): void
    {
        $this->votes = $this->votes + 1;
    }

    /**
     * @param int $votes
     */
    public function setVotesTo0(): void
    {
        $this->votes = 0;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=250, nullable=false,unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=false,unique=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="Votes", type="integer", nullable=false)
     */
    private $votes;




}
