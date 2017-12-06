<?php

namespace App\Model;

class TeamModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $iso2;

    /**
     * @param int $id
     * @param string $name
     * @param string $iso2
     */
    public function __construct(int $id, string $name, string $iso2)
    {
        $this->id = $id;
        $this->name = $name;
        $this->iso2 = $iso2;
    }

    /**
     * Get Id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Iso2
     *
     * @return string
     */
    public function getIso2(): string
    {
        return $this->iso2;
    }

}
