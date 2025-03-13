<?php
require_once getPath("Photo");
require_once getPath("responses");
class PhotoController
{
    public function getPhotos($data)
    {
        if (empty($data['owner'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing 'owner' field."]);
            exit();
        }

        $owner = $data['owner'];
        $photos = photo::getPhotos($owner);

        if (empty($photos)) {
            http_response_code(NOT_FOUND);
            echo json_encode(["message" => "No photos found for this owner."]);
            exit();
        }

        http_response_code(SUCCESS);
        // exclude owner
        $response = array_map(fn($photo) => [
            "id" => $photo->id,
            "name" => $photo->name,
            "color" => $photo->color,
        ], $photos);
        echo json_encode($response);
    }
    public function getPhotosByphoto($data)
    {
        // TODO: Implement logic
    }
    public function getPhoto($data)
    {
        // Validate required fields
        if (!isset($data['id'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        $id = $data['id'];

        $photo = Photo::getPhoto($id);
        if (!$photo) {
            http_response_code(NOT_FOUND);
            echo json_encode(["message" => "photo is not found"]);
            exit();
        }
        http_response_code(SUCCESS);
        $response = [
            "id" => $photo->id,
            "title" => $photo->title,
            "desc" => $photo->desc,
            "url" => $photo->url
        ];
        echo json_encode($response);
    }
    public function uploadPhoto($data)
    {
        // TODO: Implement logic
    }

    public function updatePhoto($data)
    {
        // TODO: Implement logic
    }

    public function deletePhoto($data)
    {
        // TODO: Implement logic
    }
}