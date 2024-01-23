<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Imagen::class)]
    private Collection $imagens;

    public function __construct()
    {
        $this->imagens = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Imagen>
     */
    public function getImagens(): Collection
    {
        return $this->imagens;
    }

    public function addImagen(Imagen $imagen): static
    {
        if (!$this->imagens->contains($imagen)) {
            $this->imagens->add($imagen);
            $imagen->setCategoria($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): static
    {
        if ($this->imagens->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getCategoria() === $this) {
                $imagen->setCategoria(null);
            }
        }

        return $this;
    }
}
