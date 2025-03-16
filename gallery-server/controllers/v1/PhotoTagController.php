<?php
require_once getPath("PhotoTagRepo");
require_once getPath("responses");
class PhotoTagController {

// Attach a tag to a photo
public function attachTag(): void {
    // Get the input data
    $data = json_decode(file_get_contents("php://input"));

    // Ensure the required fields are provided
    if (!isset($data->photo_id) || !isset($data->tag_id)) {
        http_response_code(BAD_REQUEST); // Bad request
        echo json_encode(["message" => "Missing photo_id or tag_id"]);
        return;
    }

    // Create PhotoTagModel object
    $photoTagModel = new PhotoTagModel($data->photo_id, $data->tag_id);

    // Call the PhotoTag class to attach the tag
    if (PhotoTagRepo::attachTag($photoTagModel)) {
        http_response_code(CREATED); // Created
        echo json_encode(["message" => "Tag attached successfully"]);
    } else {
        http_response_code(INTERNAL_SERVER_ERROR); // Internal server error
        echo json_encode(["message" => "Failed to attach the tag"]);
    }
}

// Detach a tag from a photo
public function detachTag(): void {
    // Get the input data
    $data = json_decode(file_get_contents("php://input"));

    // Ensure the required fields are provided
    if (!isset($data->photo_id) || !isset($data->tag_id)) {
        http_response_code(BAD_REQUEST); // Bad request
        echo json_encode(["message" => "Missing photo_id or tag_id"]);
        return;
    }

    // Create PhotoTagModel object
    $photoTagModel = new PhotoTagModel($data->photo_id, $data->tag_id);

    // Call the PhotoTag class to detach the tag
    if (PhotoTagRepo::detachTag($photoTagModel)) {
        http_response_code(NO_CONTENT); // No content
        echo json_encode(["message" => "Tag detached successfully"]);
    } else {
        http_response_code(INTERNAL_SERVER_ERROR); // Internal server error
        echo json_encode(["message" => "Failed to detach the tag"]);
    }
}

// Get all tags attached to a specific photo
public function getAttachedTags(): void {
    // Get the photo_id from the request parameters
    if (!isset($_GET['photo_id'])) {
        http_response_code(BAD_REQUEST); // Bad request
        echo json_encode(["message" => "Missing photo_id"]);
        return;
    }

    $photo_id = $_GET['photo_id'];

    // Call the PhotoTag class to get the attached tags
    $tags = PhotoTagRepo::getAttachedTags($photo_id);

    if (!empty($tags)) {
        http_response_code(SUCCESS); // OK
        echo json_encode($tags);
    } else {
        http_response_code(NO_CONTENT); // Not found
        echo json_encode(["message" => "No tags found for the specified photo"]);
    }
}
}
