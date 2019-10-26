<?php

include 'FieldValidator.php';
session_start();

class dbConnection {

  public function __construct(){
    $this->conn = null;
  }

  public function connect(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "labweb3";

    try{
      $this->conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully";
    }
    catch(PDOException $e){
      //echo "Connection failed: " . $e->getMessage();
    }

  }

  public function changePassword(){
    if($this->conn != null){
      $fieldValidator = new FieldValidator();
      if($fieldValidator->validatePassword($_POST["newPassword"])){

        $sql = "UPDATE users SET password=? WHERE id=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$_POST["newPassword"], $_SESSION["username"] ]);

        $message = "Su contraseña fue cambiada";
        $newURL = "welcome.php?Message=".urlencode($message);
        header('Location: '.$newURL);



      }
      else{
        $message = "La contraseña ingresada no cumple con el formato requerido. Debe contener números y letras en mayúscula y minúscula ";
        print '<script type="text/javascript">alert("' . $message . '");</script>';
      }
    }
  }

  public function login(){

    if($this->conn != null){

      try{

        //Validate empty fields
        $fieldValidator = new FieldValidator();
        if(!$fieldValidator->isEmpty($_POST["username"]) &&
        !$fieldValidator->isEmpty($_POST["password"])){

          $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id AND password=:password");
          $stmt->execute(['id' => $_POST["username"],'password' => $_POST["password"]]);
          $user = $stmt->fetch();

          if (is_array($user))  {

            $_SESSION["username"] = $_POST["username"];
            $newURL = "welcome.php";
            header('Location: '.$newURL);

          }else {
            $errorMessage = "Nombre de usuario o contraseña incorrecta";
            $newURL = "login.php?Message=".urlencode($errorMessage);
            header('Location: '.$newURL);
          }
        }
        else{

          $errorMessage = "Debe ingresar todos los campos para poder iniciar sesión";
          $newURL = "login.php?Message=".urlencode($errorMessage);
          header('Location: '.$newURL);

        }
      }
      catch(PDOException $e){

        $errorMessage = "Fallo en la conexión";
        $newURL = "login.php?Message=".urlencode($errorMessage);
        header('Location: '.$newURL);

      }

    }
  }

  public function register(){
    if($this->conn != null){

      try{

        //Validate empty fields
        $fieldValidator = new FieldValidator();
        if($fieldValidator->validateRegister($_POST["username"], $_POST["firstname"], $_POST["lastname"],
        $_POST["cellphone"], $_POST["telephone"], $_POST["password"],$_POST["password"]) ) {

          $userType = "UsuarioEstandar";
          $insert = "INSERT INTO users (id,firstname,lastname,cellphone,telephone,password,role) VALUES(?,?,?,?,?,?,?)";
          $stmt = $this->conn->prepare($insert);
          $stmt->execute([ $_POST["username"], $_POST["firstname"], $_POST["lastname"],
          $_POST["cellphone"], $_POST["telephone"], $_POST["password"],$userType ]);

          $errorMessage = "Usuario registrado con éxito";
          $newURL = "login.php?Message=".urlencode($errorMessage);
          header('Location: '.$newURL);

        }
        else{

          $errorMessage = "Campos vacios o formato incorrecto";
          $newURL = "register.php?Message=".urlencode($errorMessage);
          header('Location: '.$newURL);

        }

      }
      catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }

    }
  }

}


 ?>
