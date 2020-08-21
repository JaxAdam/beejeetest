<?php

namespace application\models;

use application\core\Model;

class Account extends Model
{
    // registration

    public function getRegistrationValidationResult($data)
    {
        $result = true;
        (!empty($data['password2'])) ? $password2 = htmlspecialchars($data['password2']) : $result = 'Повторите пароль';
        (!empty($data['password1'])) ? $password1 = htmlspecialchars($data['password1']) : $result = 'Введите пароль';
        (!empty($data['taskerMail'])) ? $email = htmlspecialchars($data['taskerMail']) : $result = 'Введите email';
        (!empty($data['taskerName'])) ? $name = htmlspecialchars($data['taskerName']) : $result = 'Введите имя';
        if ($email != null) (filter_var($email, FILTER_VALIDATE_EMAIL)) ?: $result = "Не правильный формат email";;
        if ($name != null) (strlen($name) < 150) ?: $result = 'Слишком длинное имя';
        if ($email != null) (strlen($email) < 350) ?: $result = 'Слишком длинный email';
        if ($password1 != null && $password2 != null) ($password1 === $password2) ?: $result = 'Пароли не совпадают';
        if ($password1 != null) (strlen($password1) >= 6) ?: $result = 'Пароль слишком короткий. Должно быть не меньше 6.';
        if ($password1 != null) (strlen($password1) <= 30) ?: $result = 'Пароль слишком длинный. Должно быть не больше 30.';
        if ($email != null) ($this->getUserByEmail($email) == null) ?: $result = 'Пользователь с таким email уже существует.';
        return $result;
    }

    public function addNewUser($data)
    {
        $token = $this->createToken();
        $passwordHash = sha1(htmlspecialchars($data['password1']));
        $this->db->addRow('INSERT INTO `users` (`username`, `email`, `pass`, `token`) VALUES 
                                (:username, :email, :pass, :token)', [
            'username' => htmlspecialchars($data['taskerName']),
            'email' => htmlspecialchars($data['taskerMail']),
            'pass' => $passwordHash,
            'token' => $token,
        ]);
    }

    public function createToken()
    {
        $token = bin2hex(random_bytes(41));
        if ($this->tokenExists($token)) {
            $token = $this->createToken();
        }
        return $token;
    }

    public function tokenExists($token)
    {
        $result = $this->db->getAll('SELECT token FROM users WHERE token = :token', ['token' => $token]);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // login

    public function getLoginValidationResult($data)
    {
        $result = true;
        (!empty($data['password'])) ? $passwordHash = sha1(htmlspecialchars($data['password'])) : $result = 'Введите пароль';
        (!empty($data['taskerMail'])) ? $email = htmlspecialchars($data['taskerMail']) : $result = 'Введите email';
        ($passwordHash == $this->getUserPasswordHashByEmail($email)) ?: $result = 'Неверный логин или пароль';
        if($email != null)(filter_var($email, FILTER_VALIDATE_EMAIL) || $email == 'admin') ?: $result = "Не правильный формат email";
        return $result;
    }

    public function getUserPasswordHashByEmail($email)
    {
        return $this->db->getValue('SELECT `pass` FROM `users` WHERE `email` = :email', ['email' => $email]);
    }

    public function getUserByEmail($email)
    {
        return $this->db->getRow('SELECT * FROM `users` WHERE `email` = :email', ['email' => $email]);
    }

    public function login($email)
    {
        $userData = $this->getUserByEmail(htmlspecialchars($email));
        $_SESSION['userToken'] = $userData['token'];
        $_SESSION['userName'] = $userData['username'];
        $_SESSION['userId'] = $userData['id'];
        $_SESSION['userEmail'] = $userData['email'];
        (htmlspecialchars($email) !== 'admin') ?: $_SESSION['status'] = 1;
    }
}