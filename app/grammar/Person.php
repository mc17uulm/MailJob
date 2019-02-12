<?php

namespace app\grammar;

class Person
{

    private $type;
    private $female;
    private $plural;

    public function __construct(int $type, bool $female = false, bool $plural = false)
    {
        $this->type = $type;
        $this->female = $female;
        $this->plural = $plural;
    }

    public function get_type() : int
    {
        return $this->type;
    }

    public function is_female() : bool
    {
        return $this->female;
    }

    public function is_plural() : bool
    {
        return $this->plural;
    }

}