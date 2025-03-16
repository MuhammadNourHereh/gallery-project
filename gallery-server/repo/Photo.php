<?php
require_once getPath("conn");
require_once getPath("PhotoI");
require_once getPath("PhotoSkeleton");
require_once getPath("TagSkeleton");

class Photo implements PhotoI
{
    // Add a new photo
    public static function addPhoto(PhotoSkeleton $photo): PhotoSkeleton|false
    {
        global $conn;

        $query = "INSERT INTO photos (title, `desc`, url, owner) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $photo->title, $photo->desc, $photo->url, $photo->owner);

        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }

        $photo->id = $stmt->insert_id;
        $stmt->close();
        return $photo;
    }

    // Get a photo by its ID
    public static function getPhoto(int $id): ?PhotoSkeleton
    {
        global $conn;

        $query = "SELECT * FROM photos WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return new PhotoSkeleton($row['id'], $row['title'], $row['desc'], $row['url'], $row['owner']);
        }

        return null;
    }

    // Get all photos
    public static function getPhotos($owner): array
    {
        global $conn;

        $query = "SELECT * FROM photos WHERE `owner` = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt)
            return [];

        $stmt->bind_param("s", $owner);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = [];

        while ($row = $result->fetch_assoc()) {
            $photos[] = new PhotoSkeleton($row['id'], $row['title'], $row['desc'], $row['url'], $row['owner']);
        }

        $stmt->close();
        return $photos;
    }

    // Delete a photo by its ID
    public static function deletePhoto(int $id): bool
    {
        global $conn;

        $query = "DELETE FROM photos WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Update a photo
    public static function updatePhoto(PhotoSkeleton $photo): bool
    {
        global $conn;

        $query = "UPDATE photos SET title = ?, `desc` = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssi", $photo->title, $photo->desc, $photo->id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Add a tag to a photo
    public static function addTagToPhoto(int $photo_id, int $tag_id): bool
    {
        global $conn;

        $query = "INSERT INTO `photo-tag` (photo_id, tag_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $photo_id, $tag_id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Remove a tag from a photo
    public static function removeTagFromPhoto(int $photo_id, int $tag_id): bool
    {
        global $conn;

        $query = "DELETE FROM `photo-tag` WHERE photo_id = ? AND tag_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $photo_id, $tag_id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}
