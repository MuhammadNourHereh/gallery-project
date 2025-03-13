<?php

class PhotoSkeleton
{
    public string $id;
    public string $title;
    public string $desc;
    public string $url;
    public string $owner;
    public array $tags;

    public function __construct(string $id, string $title, string $desc, string $url, array $tags = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->desc = $desc;
        $this->url = $url;
        $this->tags = $tags;
    }
    
}