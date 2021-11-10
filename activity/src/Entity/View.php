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
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    protected string $url = '';

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $viewsCount = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $lastView;

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

    public function getLastView(): DateTime
    {
        return $this->lastView;
    }

    public function setLastView(DateTime $lastView): View
    {
        $this->lastView = $lastView;

        return $this;
    }

    public function increment(): View
    {
        ++$this->viewsCount;

        return $this;
    }
}
