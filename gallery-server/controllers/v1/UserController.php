<?php
require_once getPath("UserRepo");
require_once getPath("responses");

class UserController
{
    public function getAllUsers()
    {
        $users = UserRepo::getAllUsers();

        if (empty($users)) {
            http_response_code(NO_CONTENT);
            exit();
        }

        http_response_code(SUCCESS);
        header("Content-Type: application/json");
        echo json_encode($users);
    }

    public function login($data)
    {
        // Validate required fields
        if (!isset($data['username'], $data['password'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // get credentials
        $username = $data['username'];
        $password = $data['password'];

        $user = UserRepo::getUser($username, $password);
        if (!$user) {
            http_response_code(FORBIDDEN);
            echo json_encode(["message" => "user doesn't exists or wrong password."]);
            exit();
        }
        http_response_code(SUCCESS);
        $response = [
            "username" => $user->username,
            "first_name" => $user->firstname,
            "last_name" => $user->lastname,
        ];
        echo json_encode($response);
    }

    public function signup($data)
    {

        // Validate required fields
        if (!isset($data['username'], $data['password'], $data['firstname'], $data['lastname'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // Create UserModel object
        $user = new UserModel(
            $data['username'],
            $data['password'],
            $data['firstname'],
            $data['lastname']
        );

        // Check if user already exists
        if (UserRepo::getUser($user->username, $user->password)) {
            http_response_code(CONFLICT);
            echo json_encode(["message" => "Username already taken."]);
            exit();
        }

        // Attempt to add the user
        $newUser = UserRepo::addUser($user);
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

    public function deleteAccount($data)
    {
        // Validate required fields
        if (!isset($data['username'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // get username
        $username = $data['username'];

        if (UserRepo::deleteUser($username)) {
            http_response_code(SUCCESS); 
            echo json_encode(["message" => "Account deleted successfully."]);
        } else {
            http_response_code(INTERNAL_SERVER_ERROR);
            echo json_encode(["message" => "Failed to deleted account."]);
        }
    }

    public function updateAccount($data)
    {
        // Validate required fields
        if (!isset($data['username'], $data['password'], $data['firstname'], $data['lastname'])) {
            http_response_code(BAD_REQUEST);
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        // Create UserModel object
        $user = new UserModel(
            $data['username'],
            $data['password'],
            $data['firstname'],
            $data['lastname']
        );

        // update user
        if (UserRepo::updateUser($user)) {
            http_response_code(SUCCESS);
            echo json_encode(["message" => "Account updated successfully."]);
        } else {
            http_response_code(INTERNAL_SERVER_ERROR);
            echo json_encode(["message" => "Failed to update account."]);
        }
    }
}