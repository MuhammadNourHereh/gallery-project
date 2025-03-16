<?php
require_once getPath("conn");
require_once getPath("PhotoTagSkeleton");
require_once getPath("PhotoTagI");

class PhotoTag implements PhotoTagI{
    public static function attachTag(PhotoTagSkeleton $photoTag): bool {
        global $conn;

        $query = "INSERT INTO `photo_tag` (photo_id, tag_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ii", $photoTag->photo_id, $photoTag->tag_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public static function detachTag(PhotoTagSkeleton $photoTag): bool {
        global $conn;

        $query = "DELETE FROM `photo_tag` WHERE photo_id = ? AND tag_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param("ii", $photoTag->photo_id, $photoTag->tag_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public static function getAttachedTags(int $photo_id): array {
        global $conn;

        $query = "SELECT t.id, t.name, t.color FROM `tags` t 
                  INNER JOIN `photo_tag` pt ON t.id = pt.tag_id 
                  WHERE pt.photo_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) return [];

        $stmt->bind_param("i", $photo_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = $row;
        }

        $stmt->close();
        return $tags;
    }
}
