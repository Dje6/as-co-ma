<?php
namespace Service;

use \Model\UsersCustomModel;
use \Model\AssocModel;
use \Model\MairieModel;

class ValidationTools
{
  public static function IsValid($errors)
  {
    foreach ($errors as $key => $value) {
      if(!empty($value)) {
        return false;
      }
    }
    return true;
  }

  /**
   * emailValid
   * @param email $email
   * @return string $error
   */

  public static function emailValid($email,$exist=false)
  {
    $model = new UsersCustomModel();

    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
      return 'Adresse e-mail invalide.';
    }
      elseif(strlen($email) > 50) {
      return 'Votre adresse e-mail est trop longue.';
    }
    if($exist){
      if(!$model->emailExists($email)){
        return "Cet e-mail n'existe pas";
      }
    }
  }
  public static function emailValidAssoc($email,$exist=false)
  {
    $model = new AssocModel;

    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
      return 'Adresse e-mail invalide.';
    }
      elseif(strlen($email) > 50) {
      return 'Votre adresse e-mail est trop longue.';
    }
    if($exist){
      if(!$model->emailExistsOrga($email)){
        return "Cet e-mail n'existe pas";
      }
    }
  }
  public static function emailValidMairie($email,$exist=false)
  {
    $model = new MairieModel;

    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
      return 'Adresse e-mail invalide.';
    }
      elseif(strlen($email) > 50) {
      return 'Votre adresse e-mail est trop longue.';
    }
    if($exist){
      if(!$model->emailExistsOrga($email)){
        return "Cet e-mail n'existe pas";
      }
    }
  }

  public static function code_postalVerif($valeur)
  {
    if(empty($valeur)) {
      return 'Merci de saisir un code postal.';
    }elseif(strlen($valeur) > 5) {
      return 'Votre code postal est trop long.';
    }elseif(strlen($valeur) < 5) {
      return 'Votre code postal est trop court.';
    }elseif(!is_numeric($valeur)) {
      return 'Votre code postal doit être un nombre.';
    }
  }

  public static function telVerif($valeur,$empty=false)
  {
    if(!$empty) {
      if(empty($valeur)){
        return 'Merci de saisir un numéro.';
      }
    }
      if(!empty($valeur)){
        if(strlen($valeur) > 10) {
          return 'Votre numéro est trop long.';
        }elseif(strlen($valeur) < 10) {
          return 'Votre numéro est trop court.';
        }elseif(!is_numeric($valeur)) {
          return 'Votre numéro doit être un nombre.';
        }
      }
  }

  /**
   * textValid
   * @param POST $text string
   * @param title $title string
   * @param min $min int
   * @param max $max int
   * @param empty $empty bool
   * @return string $error
   */

  public static function textValid($text, $title, $min = 3,  $max = 50, $empty = false)
  {

    $error = '';
    if(!empty($text)) {
      $strtext = strlen($text);
      if($strtext > $max) {
        $error = 'Votre ' . $title . ' est trop long.';
      } elseif($strtext < $min) {
        $error = 'Votre ' . $title . ' est trop court.';
      }
    } else {
      if(!$empty) {
        $error = 'Veuillez renseigner un(e) ' . $title . '.';
      }
    }
    return $error;

  }

  public static function passwordValid($password,$r_password, $min = 3,  $max = 50)
  {
    if(!empty($password)) {
      $strtext = strlen($password);
      if($strtext > $max) {
        return 'Votre mot de passe est trop long.';
      } elseif($strtext < $min) {
        return 'Votre mot de passe est trop court.';
      }
      if(!empty($r_password)) {
        if($r_password != $password){
          return 'Vos mots de passe ne correspondent pas.';
        }
      }else {
        return 'Veuillez répéter votre mot de passe.' ;
      }
    }else{
      return 'Veuillez saisir un mot de passe.';
    }
  }
}
