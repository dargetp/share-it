<?php

namespace App\Database;

/**
 * Les objets de la classe Files représentent les données de la table 'files'
 * 1 instant = 1 ligne
 * 
 */
class Files
{
    /*
     *PHP 7.4 ET +
        private ?int $id = null;
        
        php < 7.4
          private $id;
     */
    private ?int $id = null;
    private ?string $filename = null;
    private ?string $original_filename = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * self désigne la classe actuelle
     * @return self retourne l'objet actuel
     * return objet de class Files
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->original_filename;
    }

    public function setOriginalFilename(string $original_filename): self
    {
        $this->original_filename = $original_filename;
        return $this;
    }
    
}


