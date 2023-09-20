<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Task::class, cascade: ['persist'])]
    protected Collection $tasks;

    public function __construct() 
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }
}
