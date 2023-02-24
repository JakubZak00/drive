<?php

namespace App\Entity;

use App\Repository\QueryDriveRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: QueryDriveRepository::class)]
class QueryDrive
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumberQuery = null;

    #[ORM\Column(length: 255)]
    private ?string $Query = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $A = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $B = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $C = null;

    #[ORM\Column(length: 50)]
    private ?string $answer = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(length: 50)]
    private ?string $Category = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $Media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberQuery(): ?int
    {
        return $this->NumberQuery;
    }

    public function setNumberQuery(int $NumberQuery): self
    {
        $this->NumberQuery = $NumberQuery;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->Query;
    }

    public function setQuery(string $Query): self
    {
        $this->Query = $Query;

        return $this;
    }

    public function getA(): ?string
    {
        return $this->A;
    }

    public function setA(?string $A): self
    {
        $this->A = $A;

        return $this;
    }

    public function getB(): ?string
    {
        return $this->B;
    }

    public function setB(?string $B): self
    {
        $this->B = $B;

        return $this;
    }

    public function getC(): ?string
    {
        return $this->C;
    }

    public function setC(?string $C): self
    {
        $this->C = $C;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->Media;
    }

    public function setMedia(?string $Media): self
    {
        $this->Media = $Media;

        return $this;
    }
}
