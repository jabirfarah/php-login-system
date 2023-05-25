<?php

class SignupContr
{
    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;

    public function __construct($uid, $pwd, $pwdRepeat, $email)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }



private function emptyInput()
    {
        $result = false;
        if (empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) {
            $results = false;
        } else {
            $results = true;
        }

        return $results;
    }

    private function invalidUid()
    {
        $results = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) {
            $results = false;
        } else {
            $results = true;
        }
        return $results;
    }
    private function invalidEmail()
    {
        $results = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $results = false;
        } else {
            $results = true;
        }
        return $results;
    }
    private function pwdMatch()
    {
        $results = false;
        if ($this->pwd !== $this->pwdRepeat) {
            $results = false;
        } else {
            $results = true;
        }
        return $results;
    }
}
