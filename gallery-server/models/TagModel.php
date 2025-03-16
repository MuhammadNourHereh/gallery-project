<?php

class TagModel
{

    public int $id;
    public string $name;
    public int $color;

    public string $owner;

    public function __construct(int $id, string $name, int $color, string $owner)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->owner = $owner;
    }
}