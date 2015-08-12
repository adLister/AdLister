<?php


class Auth
{
    public static function attempt($email, $password, $dbc)
    {
        $query = 'SELECT email, password FROM users WHERE email = :email;';
        $stmt  = $dbc->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $userId  = $results['email'];
        $passwordHash = $results['password'];
        if(password_verify($password, $passwordHash))
        {
            $_SESSION['LOGGED_IN_USER'] = $email;
            $_SESSION['email'] = $userId;
            return true;
        }
        
    }
    static function currentUser()
    {
        return $_SESSION['LOGGED_IN_USER'];
    }
    static function checkUser()
    {
        return !empty($_SESSION['LOGGED_IN_USER']) && isset($_SESSION['LOGGED_IN_USER']) ? true : false;
    }
    static function logoutUser()
    {
        $_SESSION = array();
        if(ini_get("session.use_cookies"))
        {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }
}
