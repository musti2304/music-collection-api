<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistId(): ?string
    {
        return $this->artist_id;
    }

    public function setArtistId(string $artist_id): self
    {
        $this->artist_id = $artist_id;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artist_name;
    }

    public function setArtistName(string $artist_name): self
    {
        $this->artist_name = $artist_name;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->artist_id,
            'name' => $this->artist_name
        ];
    }
}
