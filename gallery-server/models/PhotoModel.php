<?php

class PhotoModel
{
    public string $id;
    public string $title;
    public string $desc;
    public string $url;
    public string $owner;

    public function __construct(string $id, string $title, string $desc, string $url,string $owner)
    {
        $this->id = $id;
        $this->title = $title;
        $this->desc = $desc;
        $this->url = $url;
        $this->owner = $owner;
    }
}