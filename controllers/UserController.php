<?php
class UserController {

  public function actionRegister() {
    $name = false;
    $email = false;
    $password = false;
    $result = false;
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $errors = false;
      if (!User::checkName($name)) {
        $errors[] = "Ім'я повинне бути довше ніж 2 символи";
      }
      if (!User::checkEmail($email)) {
        $errors[] = 'Неправильний email';
      }
      if (User::checkEmailExists($email)) {
        $errors[] = 'Такий email вже використовується';
      }
      if (!User::checkPassword($password)) {
        $errors[] = 'Пароль повинен бути довше ніж 6 символів';
      }
      if ($errors == false) {
        $result = User::register($name, $email, $password);
      }
    }
    require_once(ROOT.'/views/user/register.php');
    return true;
  }

  public function actionLogin() {
    $email = '';
    $password = '';
    if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $errors = false;
      if (!User::checkEmail($email)) {
        $errors[] = 'Неправильний email';
      }
      if (!User::checkPassword($password)) {
        $errors[] = 'Пароль повинен бути довше ніж 6 символів';
      }
      $userId = User::checkUserData($email, $password);
      if ($userId == false) {
        $errors[] = 'Невірні дані для входу на сайт';
      } else {
        User::auth($userId);
        header("Location: /cabinet/");
      }
    }
    require_once(ROOT.'/views/user/login.php');
    return true;
  }

  public function actionLogout() {
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION['user_name']);
    header("Location: /");
  }

}
?>
