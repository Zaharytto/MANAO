<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthorizationAndRegistration</title>
    <script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous">
    </script>
    <link rel="stylesheet" text= "text/css"  href="/TZ2/assets/style.css">
</head>
<body>

    <div id= "profile">
        <h1 id= "hello"></h1>
        <button onclick="document.location='/TZ2/app/exitProfile.php'">Выход</button>
    </div>

    <?php if (!empty($_SESSION['name'])) :?>

    <div id= "profile-cookie">
        <h1 id= "hello"><?='hello ' . $_SESSION['name']?></h1>
        <button onclick="document.location='/TZ2/app/exitProfile.php'">Выход</button>
    </div>    

    <?php else :?>

    <p id= "all"></p>

    <form id="form-create-user" >
        <div class="form-element">
            <label>Логин</label>
            <input class= 'login' type="text" name="login" value = "" required/>
        </div>
        <p class= "error login-error">Логин должен состоять минимум из 6 симфолов, без пробела</p>

        <div class="form-element">
            <label>Пароль</label>
            <input class= 'password' type="password" name="password" value = "" required/>
        </div>
        <p class= "error password-error">Пароль должен состоять минимум из 6 симфолов, из цифр и букв, без пробела</p>

        <div class="form-element">
            <label>Подтверждение пароля</label>
            <input class= 'confirm_password' type="password" name="confirm_password" value = "" required/>
        </div>
        <p class= "error confirm_password-error">Пароли не совпадают</p>

        <div class="form-element">
            <label>Email</label>
            <input class= 'email' type="text" name="email" value = "" required/>
        </div>
        <p class= "error email-error">Неверно указан email</p>

        <div class="form-element">
            <label>Имя</label>
            <input class= 'name' type="text" name="name" value = "" required/>
        </div>
        <p class= "error name-error">Имя должено состоять минимум из 2 симфолов, только буквы</p>

        <button class= 'registration' type="submit" name="register">Регистрация</button>
    </form> 
    


    <form id="form-auth-user" >

        <p id= "auth-error" style= "background: orangered"></p>

        <div class="form-element">
            <label>Логин</label>
            <input class= 'loginAuth' type="text" name="login" value = "" required/>
        </div>
        <p class= "error loginAuth-error">Логин должен состоять минимум из 6 симфолов, без пробела</p>


        <div class="form-element">
            <label>Пароль</label>
            <input class= 'passwordAuth' type="password" name="password" value = "" required/>
        </div>
        <p class= "error passwordAuth-error">Пароль должен состоять минимум из 6 симфолов, из цифр и букв, без пробела</p>


        <button class= 'authorization' type="submit" name="send">Войти</button>

    </form>
    
    <?php endif; ?>

    <script>
        $(document).ready(function(){
            $("#form-create-user").submit(function(e){
                e.preventDefault();
                
                if ($('input.login').val().length >= 6 && /^[A-Z\d\S]+$/i.test($('input.login').val())) {     
                    var loginReg = $('input.login').val();
                } else {
                    var loginError= document.getElementsByClassName("login-error")[0];
                    loginError.style.display = 'block';
                }

                if ($('input.password').val().length >= 6 && /(([a-z]+\d+)|(\d+[a-z]+))[a-z\d]*/i.test($('input.password').val()) && /^[A-Z\d]+$/i.test($('input.password').val())
                ) {
                    var passwordR = $('input.password').val();
                } else {
                    var passwordError= document.getElementsByClassName("password-error")[0];
                    passwordError.style.display = 'block';
                }

                if ($('input.password').val() === $('input.confirm_password').val()) {
                    var passwordReg = passwordR;       
                } else {
                    var confirm_passwordError= document.getElementsByClassName("confirm_password-error")[0];
                    confirm_passwordError.style.display = 'block';
                }

                function validateEmail(emailReg) {
                    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
                    return re.test(String(emailReg).toLowerCase());
                }

                if (validateEmail($('input.email').val())) {  
                    var emailReg = $('input.email').val();  
                } else {   
                    var emailError= document.getElementsByClassName("email-error")[0];
                    emailError.style.display = 'block';   
                }

                if ($('input.name').val().length >= 2 && /^[a-zA-Z]+$/.test($('input.name').val())) {   
                    var nameReg = $('input.name').val();
                } else {   
                    var nameError= document.getElementsByClassName("name-error")[0];
                    nameError.style.display = 'block';
                }

                $.ajax({
                  method: "POST",
                  dataType: 'json',
                  url: "/TZ2/app/create.php",
                  data: { login: loginReg, password: passwordReg, email: emailReg, name: nameReg },
                  success: function (data) { 
                    if (data.status === false) {
                        var all = document.getElementById("all");
                        all.textContent = data.message;
                    } else {
                        var all = document.getElementById("all");
                        all.textContent = '';

                        var formCreateUser = document.getElementById("form-create-user");
                        formCreateUser.style.display = 'none';
                        var formAuthUser = document.getElementById("form-auth-user");
                        formAuthUser.style.display = 'none';
                        var profile = document.getElementById("profile");
                        profile.style.display = 'block';                       

                        var hello = document.getElementById("hello");
                        hello.textContent = 'hello ' + nameReg;
                    }
                }
                })

                $('input.login').val('');
                $('input.password').val('');
                $('input.confirm_password').val('');
                $('input.email').val('');
                $('input.name').val('');
            })
            });;
    


        $(document).ready(function(){
            $("#form-auth-user").submit(function(e){
                e.preventDefault();

                if ($('input.loginAuth').val().length >= 6 && /^[A-Z\d\S]+$/i.test($('input.loginAuth').val())) {     
                    var loginAuth  = $('input.loginAuth').val();
                } else {
                    var loginAuthError= document.getElementsByClassName("loginAuth-error")[0];
                    loginAuthError.style.display = 'block';
                }

                if ($('input.passwordAuth').val().length >= 6 && /(([a-z]+\d+)|(\d+[a-z]+))[a-z\d]*/i.test($('input.passwordAuth').val()) && /^[A-Z\d]+$/i.test($('input.passwordAuth').val())
                ) {
                    var passwordAuth = $('input.passwordAuth').val();
                } else {
                    var passwordAuthError= document.getElementsByClassName("passwordAuth-error")[0];
                    passwordAuthError.style.display = 'block';
                }                
                
                
                $.ajax({
                  method: "POST",
                  dataType: 'json',
                  url: "/TZ2/app/get.php",
                  data: { login: loginAuth, password: passwordAuth},
                  
                  success: function (data) { 
                    if (data.status === false) {

                        var authError = document.getElementById("auth-error");
                        authError.textContent = data.message;
                    } else {

                        var authError = document.getElementById("auth-error");
                        authError.textContent = '';

                        var formCreateUser = document.getElementById("form-create-user");
                        formCreateUser.style.display = 'none';
                        var formAuthUser = document.getElementById("form-auth-user");
                        formAuthUser.style.display = 'none';
                        var profile = document.getElementById("profile");
                        profile.style.display = 'block';

                        var hello = document.getElementById("hello");
                        hello.textContent = 'hello ' + data.name;
                        
                    }
                }
                })

                $('input.loginAuth').val('');
                $('input.passwordAuth').val('');

            })
        });

    </script>
    
</body>
</html>
