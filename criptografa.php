<?php
$senha = 'admin'; // Altere para a senha desejada
$hashed_senha = password_hash($senha, PASSWORD_BCRYPT);
echo 'Senha Hashed: ' . $hashed_senha;
?>
