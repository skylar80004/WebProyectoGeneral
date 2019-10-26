<?php

class FieldValidator {
  //constructor
  public function __construct(){

  }
  public function validateEmail($email){
    if(!empty($email) && strpos($email,"@") !== true){
      return true;
    }
    else{
      echo "Correo no cumple con formato";
      return false;
    }
  }

  public function validatePassword($password){
    if(empty($password) || strlen($password) < 8 ){
      echo "Contraseña menor a 8 ";
      return false;
    }
    if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)){
      return true;
    }
    else{
      echo "Contraseña no cumple formato";
      return false;
    }
  }

  public function isEmpty($string){
    return(empty($string));
  }

  public function validateRegister($id,$firstname,$lastname,$cellphone,$telephone,$password,$email){

    return(!$this->isEmpty($id) && !$this->isEmpty($firstname) && !$this->isEmpty($lastname)
    && !$this->isEmpty($cellphone) && !$this->isEmpty($telephone) && $this->validatePassword($password)
    && $this->validateEmail($email));

  }
}
 ?>
