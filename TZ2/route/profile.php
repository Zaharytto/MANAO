<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" text= "text/css"  href="/TZ2/assets/style.css">
</head>
<body>   
    <h1>Hello <?=$_COOKIE['name']?></h1>
    <input class= "button" type="button" value = "Выход" onClick="location.href='/TZ2/index.php'">   
</body>
</html>
