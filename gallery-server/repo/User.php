<?php
require_once getPath("conn");
require_once getPath("UserSkeleton");
require_once getPath("UserI");

class User implements UserI
{
    public static function addUser(UserSkeleton $user): UserSkeleton|false
    {
        global $conn;

        // Hash password for security
        $hashed_password = hash('sha256', $user->password);

        // Prepare the SQL statement
        $query = "INSERT INTO users (username, password, firstname, lastname) 
              VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $user->username, $hashed_password, $user->firstname, $user->lastname);

        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }

        $stmt->close();

        return $user;
    }

    public static function getUser(string $username, string $password): ?UserSkeleton
    {
        global $conn;

        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stmt->close();

            // Verify the password
            if (hash('sha256', $password) == $row['password']) {
                return new UserSkeleton(
                    $row['username'],
                    $row['password'],
                    $row['firstname'],
                    $row['lastname']
                );
            }
        }

        return null;
    }

    public static function getAllUsers(): array
    {
        global $conn;

        $query = "SELECT * FROM users";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = new UserSkeleton(
                $row['username'],
                $row['password'],
                $row['firstname'],
                $row['lastname']
            );
        }

        $stmt->close();
        return $users;
    }

    public static function deleteUser(string $username): bool
    {
        global $conn;

        // First, check if the user exists
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If user does not exist, return false
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }

        // now delete the user
        $query = "DELETE FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $username);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public static function updateUser(UserSkeleton $user): bool
    {
        global $conn;

        // First, check if the user exists
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $user->username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // If user does not exist, return false
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }

        // now delete the user
        // Hash the new password for security
        $hashed_password = hash('sha256', $user->password);

        $query = "UPDATE users SET password = ?, firstname = ?, lastname = ? WHERE username = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $hashed_password, $user->firstname, $user->lastname, $user->username);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}
