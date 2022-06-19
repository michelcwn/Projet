
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion admin</title>
    <link rel="stylesheet" href="../public/style/css/main.css">
</head>

<body>
    <div class="wrapper">
        <div class="connexion__box">
        
            <h1 class="connexion__box--title">Connexion administrateur</h1>

            <form method="POST" action="login/login.php" class="connexion__box--form">
            <input type="text" placeholder="Pseudo" class="connexion__box--form-pseudo" name="pseudo"class="form-control">        
            <input type="password" placeholder="Mot de pass" class="connexion__box--form-password" name="password"class="form-control">        
            <button class="connexion__box--form-btn" type="submit">Valider</button>        
            <a href="../public/index.php" class="connexion__box--form-link">Exit</a>

            </form>
        </div>
    </div>
</body>

</html>
