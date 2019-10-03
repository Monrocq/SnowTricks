<?php

namespace App\Services;

use Doctrine\ORM\Mapping as ORM;


class Upload
{
    
    private $id;

    
    private $name;
    
    private $nb;


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
    
    public function getNb()
    {
        return $this->nb;
    }
    
    public function setNb($nb): self
    {
        $this->nb = $nb;
    
        return $this;
    }
}
