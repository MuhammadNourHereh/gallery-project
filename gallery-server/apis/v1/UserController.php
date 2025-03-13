<?php
require_once getPath("User");
require_once getPath("responses");

class UserController {
    public function getAllUsers() {
        $users = User::getAllUsers();
        
        if (empty($users)) {
            http_response_code(NO_CONTENT);
            exit();
        }
    
        http_response_code(SUCCESS);
        header("Content-Type: application/json");
        echo json_encode($users);
    }
    
    public function login() {
        // TODO: Implement logic
    }
    
    public function signup() {
        // get request data
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate required fields
        if (!isset($data['username'], $data['password'], $data['firstname'], $data['lastname'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }
    
        // Create UserSkeleton object
        $user = new UserSkeleton(
            $data['username'],
            $data['password'],
            $data['firstname'],
            $data['lastname']
        );
    
        // Check if user already exists
        if (User::getUser($user->username, $user->password)) {
            http_response_code(CONFLICT);
            echo json_encode(["message" => "Username already taken."]);
            exit();
        }
    
        // Attempt to add the user
        $newUser = User::addUser($user);
        if (!$newUser) {
            http_response_code(INTERNAL_SERVER_ERROR);
            echo json_encode(["message" => "Failed to create user."]);
            exit();
        }
    
        http_response_code(CREATED);
        header("Content-Type: application/json");
        echo json_encode(["message" => "User registered successfully."]);
        exit();
    }
    
    public function deleteAccount() {
        // TODO: Implement logic
    }
    
    public function updateAccount() {
        // TODO: Implement logic
    }
}