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

  public function insertEnterprise(){

    if($this->conn != null){

      $enterpriseName = $_POST["enterpriseName"];
      $enterpriseOrigin = $_POST["enterpriseOrigin"];
      $enterpriseDestiny = $_POST["enterpriseDestiny"];
      $enterprisePhone= $_POST["enterprisePhone"];
      $enterpriseEmail = $_POST["enterpriseEmail"];
      $enterpriseAddress= $_POST["enterpriseAddress"];
      $enterpriseLat = $_POST["enterpriseLat"];
      $enterpriseLng = $_POST["enterpriseLng"];

      echo $enterpriseName . PHP_EOL;
      echo $enterpriseOrigin . PHP_EOL;
      echo $enterprisePhone . PHP_EOL;
      echo $enterpriseEmail . PHP_EOL;
      echo $enterpriseAddress . PHP_EOL;
      echo $enterpriseLat . PHP_EOL;
      echo $enterpriseLng . PHP_EOL;

      //Input Validations
      $fieldValidator = new FieldValidator();
      if($fieldValidator->isEmpty($enterpriseName)){

        $message = "Debe ingresar el nombre de la empresa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseOrigin)){

        $message = "Debe ingresar el sitio origen de la empresa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterprisePhone)){

        $message = "Debe ingresar el número de teléfono de la empresa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseEmail)){

        $message = "Debe ingresar el correo electrónico la empresa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseAddress)){

        $message = "Debe ingresar la dirección física de la empresa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseLat)){

        $message = "Debe ingresar la latitud de la empresa, utilice el mapa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseLng)){

        $message = "Debe ingresar la longitud nombre de la empresa, utilice el mapa";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      // End of input valiations
      try {

        $insert = "INSERT INTO ENTERPRISE(id,name,origin,destiny,phone,email,address,latitude,longitude) VALUES(?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($insert);
        $stmt->execute([null,$enterpriseName,$enterpriseOrigin,
        $enterpriseDestiny,$enterprisePhone,$enterpriseEmail,$enterpriseAddress,
        (float) $enterpriseLat,(float) $enterpriseLng]);
        echo "Insertado";

      } catch (\Exception $e) {
        echo $e;

      }
    }
    else{ // Error, null connection

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
