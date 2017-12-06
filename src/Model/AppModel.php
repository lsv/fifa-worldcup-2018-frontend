<?php

namespace App\Model;

class AppModel
{

    /**
     * @var GroupModel[]
     */
    private $groups;

    /**
     * @var KnockoutModel[]
     */
    private $knockouts;

    public function __construct(array $groups = null, array $knockouts = null)
    {
        $this->groups = $groups;
        $this->knockouts = $knockouts;
    }

    /**
     * Set Groups
     *
     * @param GroupModel[] $groups
     *
     * @return AppModel
     */
    public function setGroups(array $groups): AppModel
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * Get Groups
     *
     * @return GroupModel[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * Set Knockouts
     *
     * @param KnockoutModel[] $knockouts
     *
     * @return AppModel
     */
    public function setKnockouts(array $knockouts): AppModel
    {
        $this->knockouts = $knockouts;
        return $this;
    }

    /**
     * Get Knockouts
     *
     * @return KnockoutModel[]
     */
    public function getKnockouts(): array
    {
        return $this->knockouts;
    }

}
