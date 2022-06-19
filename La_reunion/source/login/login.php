<?php
	$pdo = new PDO('mysql:host=localhost;dbname=blog;', 'root', '');
	 
	
	if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
	    $pseudo = $_POST['pseudo'];
	    $password = $_POST['password'];

		$query = $pdo->prepare('SELECT * FROM administrateur WHERE pseudo = :pseudo');
	    $query->bindValue('pseudo', $pseudo,PDO::PARAM_STR);
	    $query->execute();
	    $result = $query->fetch(PDO::FETCH_ASSOC);
	    
	    if ($result) {
	        $passwordHash = $result['password'];
	        if (password_verify($password, $passwordHash)) {	            
				header('Location: ../accueil');
	        } else {
	            echo "Identifiants invalides";
	        }
	    } else {
	        echo "Identifiants invalides";
	    }
	}