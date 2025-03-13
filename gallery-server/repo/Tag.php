<?php
require_once getPath("conn");
require_once getPath("TagI");
require_once getPath("TagSkeleton");
class Tag implements TagI
{
    // Add a new tag
    public static function addTag(TagSkeleton $tag): TagSkeleton|false
    {
        global $conn;

        $query = "INSERT INTO tags (name, color, owner) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("sis", $tag->name, $tag->color, $tag->owner);

        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }

        $tag->id = $conn->insert_id; // Set the newly created ID
        $stmt->close();
        return $tag;
    }

    // Get a tag by its ID
    public static function getTag(int $id): ?TagSkeleton
    {
        global $conn;

        $query = "SELECT * FROM tags WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) return null;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return new TagSkeleton($row['id'], $row['name'], $row['color'], $row['owner']);
        }

        $stmt->close();
        return null;
    }

    // Get all tags
    public static function getTags(string $owner): array
    {
        global $conn;

        $query = "SELECT * FROM tags WHERE `owner` = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) return [];

        $stmt->bind_param("s", $owner);
        $stmt->execute();
        $result = $stmt->get_result();
        $tags = [];

        while ($row = $result->fetch_assoc()) {
            $tags[] = new TagSkeleton($row['id'], $row['name'], $row['color'], $row['owner']);
        }

        $stmt->close();
        return $tags;
    }

    // Delete a tag by its ID
    public static function deleteTag(int $id): bool
    {
        global $conn;

        $query = "DELETE FROM tags WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Update a tag
    public static function updateTag(TagSkeleton $tag): bool
    {
        global $conn;

        $query = "UPDATE tags SET name = ?, color = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("sii", $tag->name, $tag->color, $tag->id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}