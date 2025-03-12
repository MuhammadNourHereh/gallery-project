<?php

class TagSkeleton
{
    public string $name;
    public int $color;
    
    public function __construct(string $name, int $color)
    {
        $this->name = $name;
        $this->color = $color;
    }
}