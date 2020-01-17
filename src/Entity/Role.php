<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="userRoles")
     */
    private $userS;

    public function __construct()
    {
        $this->userS = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserS(): Collection
    {
        return $this->userS;
    }

    public function addUser(User $user): self
    {
        if (!$this->userS->contains($user)) {
            $this->userS[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->userS->contains($user)) {
            $this->userS->removeElement($user);
        }

        return $this;
    }
}
