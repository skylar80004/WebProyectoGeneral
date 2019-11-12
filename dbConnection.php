<?php

error_reporting(E_ALL ^ E_NOTICE);
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
  public function insertRoute(){
    if($this->conn != null){

      $json = file_get_contents('php://input');
      // Converts it into a PHP object
      $data = json_decode($json);

      $routeHandicapCheck = $data->routeHandicapCheck;
      $routeNumber = $data->routeNumber;
      $routeDescription = $data->routeDescription;
      $routeCost = $data->routeCost;
      $routeDuration = $data->routeDuration;
      $routePoints = $data->routePoints;
      $enterpriseID = $data->enterpriseID;
      $enterpriseName = $data->enterpriseName;

      try {
        $sqlRoute = "INSERT INTO route
        (id, enterpriseID,routeNumber,description, cost,duration,handicapCheck)
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sqlRoute);
        $stmt->execute([null,(int)$enterpriseID,(int)$routeNumber,$routeDescription,
        $routeCost,$routeDuration,$routeHandicapCheck]);

        try {

          $counter = 0;
          $size = sizeof($routePoints);
          $sqlRoutePoints = "INSERT INTO routepoints(enterpriseID,routeNumber,
          lat,lng,type) VALUES (?,?,?,?,?)";

          foreach ($routePoints as $value) {

            if($counter == 0){
              $stmt = $this->conn->prepare($sqlRoutePoints);
              $stmt->execute([(int)$enterpriseID,(int)$routeNumber,(float)$value->lat,
              (float)$value->lng,"Start"]);
            }
            else if($counter == $size-1){
              $stmt = $this->conn->prepare($sqlRoutePoints);
              $stmt->execute([(int)$enterpriseID,(int)$routeNumber,(float)$value->lat,
              (float)$value->lng,"Finish"]);
            }
            else{
              $stmt = $this->conn->prepare($sqlRoutePoints);
              $stmt->execute([(int)$enterpriseID,(int)$routeNumber,(float)$value->lat,
              (float)$value->lng,"Intermedium"]);
            }
            $counter++;
          }

          $action = "Se insertó una nueva ruta para la empresa " . $enterpriseName;
          $this->insertLog($action);

        } catch (\Exception $e) {
            echo "Error " . $e;
          }
        } catch (\Exception $e) {
          echo "Error ruta " . $e;
        }
      }
    }

  public function getLogs(){
    if($this->conn != null){
      try {
        $data = $this->conn->query("SELECT * FROM log")->fetchAll();
        return $data;

      } catch (\Exception $e) {
        echo "Error en el get log " . $e;
      }

    }
  }
  public function insertLog($action){
    if($this->conn != null){
      try {
        $username = $_SESSION["username"];
        $insert = "INSERT INTO log (user,action) VALUES(?,?)";
        $stmt = $this->conn->prepare($insert);
        $stmt->execute([$username,$action]);
        echo "Insertado log";

      } catch (\Exception $e) {
        echo "Error en log " . $e;
      }
    }
  }

  public function updateSchedule(){ // TODO
    if($this->conn != null){

      /*
      echo "hola";
      echo $enterpriseId;
      $sql = "UPDATE enterprise SET name=?, origin=?, destiny=?,
      phone=?, email=?, address= ?, latitude=?, longitude=?,
      anomalyContact=? WHERE id=?";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$enterpriseName,$enterpriseOrigin,$enterpriseDestiny,
      $enterprisePhone,$enterpriseEmail,$enterpriseAddress,$enterpriseLat,
      $enterpriseLng,$enterpriseAnomalyContact,$enterpriseId]);
      echo "Updated";
      */

      $enterpriseId = $_SESSION['enterpriseId'];
      $mondayStart = $_POST['mondayStart'];
      $mondayFinish = $_POST['mondayFinish'];
      $tuesdayStart = $_POST['tuesdayStart'];
      $tuesdayFinish = $_POST['tuesdayFinish'];
      $wednesdayStart = $_POST['wednesdayStart'];
      $wednesdayFinish = $_POST['wednesdayFinish'];
      $thursdayStart = $_POST['thursdayStart'];
      $thursdayFinish = $_POST['thursdayFinish'];
      $fridayStart = $_POST['fridayStart'];
      $fridayFinish = $_POST['fridayFinish'];
      $saturdayStart = $_POST['saturdayStart'];
      $saturdayFinish = $_POST['saturdayFinish'];
      $sundayStart = $_POST['sundayStart'];
      $sundayFinish = $_POST['sundayFinish'];

      $sql = "UPDATE schedule SET start=?,finish=?
      WHERE enterpriseID=? and day=?";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$mondayStart,$mondayFinish,$enterpriseId,"Lunes"]);
      echo "Day updated";

    }
  }

  public function getSchedule($enterpriseId){
    if($this->conn != null){
      try {
        $sql = "select * from schedule where enterpriseID=:enterpriseID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['enterpriseID' =>(int)$enterpriseId]);
        $data = $stmt->fetchAll();
        return $data;
      } catch (\Exception $e) {
        echo $e;
      }
    }
  }

  public function insertSchedule(){

    if($this->conn != null){

      $fieldValidator = new FieldValidator();
      $enterpriseId = $_SESSION['enterpriseId'];
      $mondayStart = $_POST['mondayStart'];
      $mondayFinish = $_POST['mondayFinish'];
      $tuesdayStart = $_POST['tuesdayStart'];
      $tuesdayFinish = $_POST['tuesdayFinish'];
      $wednesdayStart = $_POST['wednesdayStart'];
      $wednesdayFinish = $_POST['wednesdayFinish'];
      $thursdayStart = $_POST['thursdayStart'];
      $thursdayFinish = $_POST['thursdayFinish'];
      $fridayStart = $_POST['fridayStart'];
      $fridayFinish = $_POST['fridayFinish'];
      $saturdayStart = $_POST['saturdayStart'];
      $saturdayFinish = $_POST['saturdayFinish'];
      $sundayStart = $_POST['sundayStart'];
      $sundayFinish = $_POST['sundayFinish'];

      if($fieldValidator->isEmpty($enterpriseId)){
        echo "Id nulo";
      }
      // TODO: validate isEmpty

      try {

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Lunes",$mondayStart,$mondayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Martes",$tuesdayStart,$tuesdayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Miercoles",$wednesdayStart,$wednesdayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Jueves",$thursdayStart,$thursdayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Viernes",$fridayStart,$fridayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Sabado",$saturdayStart,$saturdayFinish]);

        $sql = "insert into schedule(id,enterpriseID,day,start,finish) values(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([null,(int)$enterpriseId,"Sunday",$sundayStart,$sundayFinish]);

        echo "insertado horario ";

        $action = "Horario creado para empresa con id" . $enterpriseId ;
        $this->insertLog($action);

      } catch (\Exception $e) {
        echo "error ".$e;

      }


    }
  }

  public function editEnterprise(){
    if($this->conn != null){

      $fieldValidator = new FieldValidator();
      $enterpriseName = $_POST["enterpriseName"];
      $enterpriseOrigin = $_POST["enterpriseOrigin"];
      $enterpriseDestiny = $_POST["enterpriseDestiny"];
      $enterprisePhone= $_POST["enterprisePhone"];
      $enterpriseEmail = $_POST["enterpriseEmail"];
      $enterpriseAddress= $_POST["enterpriseAddress"];
      $enterpriseLat = $_POST["enterpriseLat"];
      $enterpriseLng = $_POST["enterpriseLng"];
      $enterpriseAnomalyContact = $_POST["anomalyContact"];
      $enterpriseId = $_SESSION["enterpriseId"];

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
      if($fieldValidator->isEmpty($enterpriseAnomalyContact)){

        $message = "Debe ingresar el contacto para reportar anomalías";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      if($fieldValidator->isEmpty($enterpriseId)){

        $message = "ID nulo";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      // End of input valiations

      try {
        echo "hola";
        echo $enterpriseId;
        $sql = "UPDATE enterprise SET name=?, origin=?, destiny=?,
        phone=?, email=?, address= ?, latitude=?, longitude=?,
        anomalyContact=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$enterpriseName,$enterpriseOrigin,$enterpriseDestiny,
        $enterprisePhone,$enterpriseEmail,$enterpriseAddress,$enterpriseLat,
        $enterpriseLng,$enterpriseAnomalyContact,$enterpriseId]);
        echo "Updated";

        $action = "Horario de empresa id  " . $enterprisId. " actualizado" ;
        $this->insertLog($action);

      } catch (\Exception $e) {
        echo $e;

      }

    }
  }
  public function getEnterprise($id){
    if($this->conn != null){

      try {
        $sql = "select * from enterprise where id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' =>(int)$id]);
        $enterprise = $stmt->fetch();
        return $enterprise;


      } catch (\Exception $e) {
        echo $e;

      }
    }
  }
  public function getEnterprises(){

    if($this->conn != null){
      try {
        $data = $this->conn->query("SELECT * FROM enterprise")->fetchAll();
        return $data;
      } catch (\Exception $e) {
        echo $e;

      }


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
      $enterpriseAnomalyContact = $_POST["anomalyContact"];


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
      if($fieldValidator->isEmpty($enterpriseAnomalyContact)){

        $message = "Debe ingresar el contacto para reportar anomalías";
        $newURL = "createEnterprise.php?Message=".urlencode($message);
        header('Location: '.$newURL);
        return;
      }
      // End of input valiations
      try {

        $insert = "INSERT INTO ENTERPRISE(id,name,origin,destiny,phone,email,address,latitude,longitude,anomalyContact) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($insert);
        $stmt->execute([null,$enterpriseName,$enterpriseOrigin,
        $enterpriseDestiny,$enterprisePhone,$enterpriseEmail,$enterpriseAddress,
        (float) $enterpriseLat,(float) $enterpriseLng,$enterpriseAnomalyContact]);
        echo "Insertado empresa";

        $action = "Nueva empresa " . $enterpriseName . " creada" ;
        $this->insertLog($action);

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
