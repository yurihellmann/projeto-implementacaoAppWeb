<?php
$senha = 'admin'; //recebe a senha - inserção manual
$hashed_senha = password_hash($senha, PASSWORD_BCRYPT); //utiliza a função do PHP e recebe dois parametros, a senha e o metodo a ser utilizada no criptografia
echo 'Senha Hashed: ' . $hashed_senha; //imprime na tela o hash da senha que deve ser salvo na banco de dados
?>
