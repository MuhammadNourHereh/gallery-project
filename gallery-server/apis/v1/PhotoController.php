<?php
require_once getPath("Photo");
require_once getPath("responses");
require_once getPath("base64Utils");
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
            http_response_code(NO_CONTENT);
            echo json_encode(["message" => "No photos found for this owner."]);
            exit();
        }

        http_response_code(SUCCESS);
        // exclude owner
        $response = array_map(fn($photo) => [
            "id" => $photo->id,
            "title" => $photo->title,
            "desc" => $photo->desc,
            "url" => $photo->url
        ], $photos);
        echo json_encode($response);
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
        if (empty($data['owner']) || empty($data['title']) || empty($data['base64'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing some fields."]);
            exit();
        }

        $title = $data['title'];
        $desc = $data['desc'];
        $owner = $data['owner'];
        $base64 = $data['base64'];

        $url = verifyAndSave($base64);
        // validate base64
        if ($url === false) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "invalid base64"]);
            exit();
        }

        $photoSkeleton = new PhotoSkeleton(
            0,
            $title,
            $desc,
            $url,
            $owner
        );

        $photo = Photo::addPhoto($photoSkeleton);

        http_response_code(CREATED);
        echo json_encode([
            "id" => $photo->id,
            "title" => $photo->title,
            "desc" => $photo->desc,
            "url" => $photo->url
        ]);
    }

    public function updatePhoto($data)
    {
        if (empty($data['id']) || empty($data['title'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing some fields."]);
            exit();
        }

        $id = $data['id'];
        $title = $data['title'];
        $desc = $data['desc'];




        $skeleton = new PhotoSkeleton(
            $id,
            $title,
            $desc,
            "",
            ""
        );

        $photo = Photo::updatePhoto($skeleton);


        http_response_code(CREATED);
        echo json_encode(
            ["msg" => "img updated"]
        );
    }

    public function deletePhoto($data)
    {
        $id = $data['id'];
        if (!isset($data['id'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing some fields."]);
            exit();
        }

        $photo = Photo::getPhoto($id);
        if (!$photo) {
            http_response_code(NOT_FOUND);
            echo json_encode(["msg" => "photo doesn't exists"]);
            exit();
        }

        $res = Photo::deletePhoto($id);

        $filePath = __DIR__ . '/../../..' . $photo->url;
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the server
        }


        if ($res) {
            echo json_encode(["msg" => "photo has been deleted"]);
        } else {
            echo json_encode(["msg" => "coudn't delete"]);
        }
    }
}