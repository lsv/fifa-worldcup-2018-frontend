<?php

namespace App\Model;

class ChannelModel
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
     * @var null|string
     */
    private $icon;

    public function __construct(int $id, string $name, ?string $icon)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
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
     * Get Icon
     *
     * @return null|string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

}
