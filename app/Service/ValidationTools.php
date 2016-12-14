<?php
namespace Service;

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

  public static function emailValid($email)
  {
    $error = '';
    if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
      $error = 'Adresse email invalide.';
    }
      elseif(strlen($email) > 50) {
      $error = 'Votre adresse e-mail est trop longue.';
    }
    return $error;
  }

  public static function code_postalVerif($valeur)
  {
    if(empty($valeur)) {
      return 'Merci de saisir un code postal';
    }elseif(strlen($valeur) > 5) {
      return 'Votre code postal est trop long.';
    }elseif(strlen($valeur) < 5) {
      return 'Votre code postal est trop court.';
    }elseif(!is_numeric($valeur)) {
      return 'Votre code postal doit etre un nombre.';
    }
  }

  public static function telVerif($valeur,$empty=false)
  {
    if(!$empty) {
      if(empty($valeur)){
        return 'Merci de saisir un numeros';
      }
    }
      if(!empty($valeur)){
        if(strlen($valeur) > 10) {
          return 'Votre numeros est trop long.';
        }elseif(strlen($valeur) < 10) {
          return 'Votre numeros est trop court.';
        }elseif(!is_numeric($valeur)) {
          return 'Votre numeros doit etre un nombre entier.';
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
        $error = 'Your ' . $title . ' is too long.';
      } elseif($strtext < $min) {
        $error = 'Your ' . $title . ' is too short.';
      }
    } else {
      if(!$empty) {
        $error = 'Veuillez renseigner un ' . $title . '.';
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
          return 'Vos mots de passe ne sont pas identiques';
        }
      }else {
        return 'Veuillez repeter votre mot de passe ' ;
      }
    }else{
      return 'Veuillez saisir un mot de passe.';
    }
  }
}
