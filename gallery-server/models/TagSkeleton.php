<?php

class TagSkeleton
{

    public int $id;
    public string $name;
    public int $color;

    public function __construct(int $id, string $name, int $color)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
    }
}