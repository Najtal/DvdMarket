<?php

# Identifier la SESSION en cours car nous sommes 
# dans un nouveau script à côté de index.php!
session_start();

# (ré)Initialiser le tableau des variables de session
$_SESSION = array();

# Détruire la session
session_destroy();

# Redirection HTTP à la page d'accueil
header("Location: index.php"); 
die();

?>
