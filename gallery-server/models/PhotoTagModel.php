<?php
class PhotoTagModel
{
    public int $photo_id;
    public int $tag_id;

    public function __construct(int $photo_id, int $tag_id)
    {
        $this->photo_id = $photo_id;
        $this->tag_id = $tag_id;
    }
}
