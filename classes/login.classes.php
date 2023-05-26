<?php

class Login extends Dbh
{

    protected function getUser($uid, $pwd)
    {
        $stmt = $this->connect()->prepare('SELECT users_pwd FROM users WHERE users_uid = ? OR users_email = ?');


        if (!$stmt->execute(array($uid, $pwd))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkpwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);


        if ($checkpwd == false) {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        } elseif ($checkpwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE (users_id = ? OR users_email = ?) AND users_pwd = ?');

            if (!$stmt->execute(array($uid, $uid, $pwd))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        $loginData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($loginData) == 0) {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }



        session_start();
        $_SESSION["userid"] = $loginData[0]["users_id"];
        $_SESSION["useruid"] = $loginData[0]["users_uid"];
        $stmt = null;

        return $loginData;
    }
}
