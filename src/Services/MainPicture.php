<?php

namespace App\Services;

use Doctrine\ORM\Mapping as ORM;


class MainPicture
{
    
    private $id;
    
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}
