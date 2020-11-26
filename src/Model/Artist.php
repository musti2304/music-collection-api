<?php


namespace App\Controller;


class Artist
{
    protected String $id;
    protected String $name;

    /**
     * Artist constructor.
     * @param String $id
     * @param String $name
     */
    public function __construct(String $id, String $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param String $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}