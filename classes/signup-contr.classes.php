<?php

class SignupContr extends Signup
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

    public function signupUser()
    {
        
        if ($this->emptyInput() == false) {
            // echo "Empty input!";
            header("location: ../index.php?error=emptyinput");
            exit();

        }
        if ($this->invalidUid() == false) {
            // echo "Empty input!";
            header("location: ../index.php?error=username");
            exit();

        }
        if ($this->invalidEmail() == false) {
            // echo "Invalid Email!";
            header("location: ../index.php?error=email");
            exit();

        }
        if ($this->pwdMatch() == false) {
            // echo "Passwords don't match!";
            header("location: ../index.php?error=passwordmatch");
            exit();

        }
        if ($this->uidTakenCheck() == false) {
            // echo "Username or email taken!";
            header("location: ../index.php?error=useroremailtaken");
            exit();

        }
        
        $this->setUser($this->uid, $this->pwd, $this->email);
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

    private function uidTakenCheck()
    {
        
        $results = false;
        if (!$this->checkUser($this->uid, $this->email)) {
            $results = false;
        } else {
            $results = true;
        }
        return $results;
    }
}
