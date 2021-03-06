<?php
    require('dbconnect.php');
    // サインイン処理
    session_start();
    $errors = array();

    if (!empty($_POST)) {
      $email = $_POST['input_email'];
      $password = $_POST['input_password'];

      if ($email == '') {
            $errors['email'] = 'blank';
        }

      if ($password == '') {
            $errors['password'] = 'blank';
        }

      if($email !='' && $password !=''){

        //データベースとの照合処理
          $sql = 'SELECT * FROM `users` WHERE `email`=?';
          $data = array($email);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $record = $stmt->fetch(PDO::FETCH_ASSOC);

          if($record == false) {  //一致するレコードが無かったとき
            $errors['signin'] = 'failed';
          }else {
            //アドレスがあった時
            //パスワードの一致確認
            //$recordはデータベースに入ってたpassword
            if (password_verify($password,$record['password'])){
              //一致した時 = 認証成功
              echo "<h1>認証成功<h1>";
              var_dump($record);

              //SESSION変数にIDを保存

              //ここで現在ログインしているユーザーのid(user_id)を$_SESSIONに代入している
              
              $_SESSION['id'] = $record['id'];
              //timeline.phpに移動
              header("Location: index.php");
              exit();


            }else {
              //不一致だった時
              $errors['signin'] = 'failed';
              echo "<h1>認証失敗</h1>";
            }
          }

          var_dump($errors);
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>BookON</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>
  <body>

    <div id="login-page">
      <div class="container">
      
          <form method="POST" class="form-login" action="login.php">
            <h2 class="form-login-heading">sign in now</h2>
              <div class="login-wrap">
                <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com" autofocus>
                  <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                    <p class="text-danger">メールアドレスを入力してください</p>
                  <?php } ?>
                <br>

                <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                  <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
                    <p class="text-danger">パスワードを入力してください</p>
                  <?php } ?>
                  <?php if(isset($errors['signin']) && $errors['signin'] == 'failed') { ?>
                    <p class="text-danger">サインインに失敗しました</p>
                  <?php } ?>

                <label class="checkbox">
                    <span class="pull-right">
                        <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
    
                    </span>
                </label>
                <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
                <hr>
                
                <div class="login-social-link centered">
                <p>or you can sign in via your social network</p>
                    <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
                    <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
                </div>
                <div class="registration">
                    Don't have an account yet?<br/>
                    <a class="" href="#">
                        Create an account
                    </a>
                </div>
    
              </div>
    
              <!-- Modal -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title">Forgot Password ?</h4>
                          </div>
                          <div class="modal-body">
                              <p>Enter your e-mail address below to reset your password.</p>
                              <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
    
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                              <button class="btn btn-theme" type="button">Submit</button>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- modal -->
    
          </form>     
      
      </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
