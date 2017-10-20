<?php
  session_start();
  include 'database.php';
  $dt = new Database;
  date_default_timezone_set('Asia/Ho_Chi_Minh');

  function checkuser($username,$password)
  {
    GLOBAL $dt;
    $dt -> select("SELECT * FROM user");
    while( $r = $dt->fetch() )
    {
      if($username == $r['Username'] && $password == $r['Password'] &&  $r['Status'] == 'active')
      {
        return true;
      }
    }
    return false;
  }
  
  function checkaccessfalse($username,$password)
  {
    GLOBAL $dt;
    $dt -> select("SELECT * FROM user");
    while( $r = $dt->fetch() )
    {
      if($username == $r['Username'] && $password != $r['Password'] &&  $r['Status'] == 'active')
      {
        return true;
      }
    }
    return false;
  }

  function checkusername($username)
  {
    GLOBAL $dt;
    $dt -> select("SELECT * FROM user");
    while( $r = $dt->fetch() )
    {
      if($username == $r['Username'])
      {
        return false;
      }
    }
    return true;
  }

  function getiduser($string)
  {
    GLOBAL $dt;
    $dt -> select("SELECT * FROM user");
    while( $r = $dt->fetch() )
    {
      if($string == $r['Username'] || $string == $r['Password'] )
      {
        return $r['UserID'];
      }
    }
    return false;
  }

   function getaccessfalse($username)
  {
    GLOBAL $dt;
    $dt -> select("SELECT * FROM user");
    while( $r = $dt->fetch() )
    {
      if($username == $r['Username'])
      {
        return $r['AccessFalse'];
      }
    }
    return false;
  }

  if(isset($_POST['btnlogin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(checkuser($username,$password)==true){
      $lastlogin = date('Y/m/d H:i:s');
      $userid = getiduser($password);
      $_SESSION['userid'] = $userid;
      $dt -> command(" UPDATE user SET LastLogin = '$lastlogin' WHERE UserID = $userid ");
      echo "Dang nhap thanh cong";
    }
    else{
      if(checkaccessfalse($username,$password)==true){
        if(getaccessfalse($username) > 5){
          $dt -> command(" UPDATE user SET Status = 'block' WHERE Username = '$username' ");
          echo "Ban da qua so lan nhap";
        }
        else{
          $numAccessFalse = getaccessfalse($username) + 1; 
          $dt -> command(" UPDATE user SET AccessFalse = $numAccessFalse WHERE Username = '$username' ");
          echo "Bạn đã nhập sai username, password hoặc tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra lại!";
        }
      }
      else{
      echo "Bạn đã nhập sai username, password hoặc tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra lại!";
      }
    }

    
  }

?>

