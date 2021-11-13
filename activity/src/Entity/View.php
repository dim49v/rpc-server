<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * View.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ViewRepository")
 */
class View
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    protected string $url;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected DateTime $date;

    protected int $viewsCount = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): View
    {
        $this->id = $id;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): View
    {
        $this->url = $url;

        return $this;
    }

    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    public function setViewsCount(int $viewsCount): View
    {
        $this->viewsCount = $viewsCount;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): View
    {
        $this->date = $date;

        return $this;
    }
}
