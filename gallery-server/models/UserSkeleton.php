<?php

class UserSkeleton
{
    public string $email;
    public string $password;
    public string $first_name;
    public string $last_name;
    
    public function __construct(string $email, string $password, string $first_name, string $last_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }
}