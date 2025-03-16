<?php
require_once getPath("TagRepo");
require_once getPath("responses");

class TagController
{
    public function getTag($data)
    {
        // Validate required fields
        if (!isset($data['id'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        $id = $data['id'];

        $tag = TagRepo::getTag($id);
        if (!$tag) {
            http_response_code(NOT_FOUND);
            echo json_encode(["message" => "tag is not found"]);
            exit();
        }
        http_response_code(SUCCESS);
        $response = [
            "id" => $tag->id,
            "name" => $tag->name,
            "color" => $tag->color,
        ];
        echo json_encode($response);
    }
    public function getTags($data)
    {
        if (empty($data['owner'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing 'owner' field."]);
            exit();
        }

        $owner = $data['owner'];
        $tags = TagRepo::getTags($owner);

        if (empty($tags)) {
            http_response_code(NO_CONTENT);
            echo json_encode(["message" => "No tags found for this owner."]);
            exit();
        }

        http_response_code(SUCCESS);
        // exclude owner
        $response = array_map(fn($tag) => [
            "id" => $tag->id,
            "name" => $tag->name,
            "color" => $tag->color,
        ], $tags);
        echo json_encode($response);
    }

    public function createTag($data)
    {
        // Validate required fields
        if (!isset($data['name'], $data['color'], $data['owner'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // Sanitize inputs
        $name = trim($data['name']);
        $owner = trim($data['owner']);
        $color = (int) $data['color'];

        // Create TagModel object
        $tag = new TagModel(0, $name, $color, $owner);

        // Insert tag into database
        $insertedTag = TagRepo::addTag($tag);

        if (!$insertedTag) {
            http_response_code(INTERNAL_SERVER_ERROR);
            echo json_encode(["message" => "Failed to create tag."]);
            exit();
        }

        // Return response
        http_response_code(CREATED);
        echo json_encode([
            "id" => $insertedTag->id,
            "name" => $insertedTag->name,
            "color" => $insertedTag->color
        ]);
    }

    public function updateTag($data)
    {
        // Validate required fields
        if (!isset($data['name'], $data['color'], $data['id'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // Sanitize inputs
        $name = trim($data['name']);
        $id = (int) $data['id'];
        $color = (int) $data['color'];

        // Create TagModel object
        $tag = new TagModel($id, $name, $color, "");

        // Insert tag into database
        $insertedTag = TagRepo::updateTag($tag);

        if (!$insertedTag) {
            http_response_code(INTERNAL_SERVER_ERROR);
            echo json_encode(["message" => "Failed to update tag."]);
            exit();
        }

        // Return response
        http_response_code(SUCCESS);
        echo json_encode([
            "message" => "tag is updated successfully."
        ]);
    }

    public function deleteTag($data)
    {
        // Validate required fields
        if (!isset($data['id'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        $id = $data['id'];

        $tag = TagRepo::deleteTag($id);
        if (!$tag) {
            http_response_code(NOT_FOUND);
            echo json_encode(["message" => "tag is not found"]);
            exit();
        }
        http_response_code(SUCCESS);
        $response = [
            "message" => "tag is deleted successfuly"
        ];
        echo json_encode($response);
    }
}
