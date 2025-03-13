<?php

class UserSkeleton
{
    public string $username;
    public string $password;
    public string $firstname;
    public string $lastname;
    
    public function __construct(string $username, string $password, string $firstname, string $lastname)
    {
        $this->username = $username;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
}