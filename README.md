Após clonar o repositório é necessário fazer a criação do banco de dados e tabelas no PHPMYADMIN, de acordo com os comandos SQL abaixo:

1. Criação do banco de dados:

  CREATE DATABASE PROJETO_FACUL;
  USE PROJETO_FACUL;

2. Criação tabela de usuários:
  CREATE TABLE usuarios (
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (usuario)
);

3. Inserir o usuário e senha:
   O usuário a ser inserido pode ser de sua escolha, no entanto, a senha antes de ser inserida deve ser criptografa por meio do arquivo "criptografa.php" disponível no repositôrio. Segue exemplo:

       <?php
          $senha = 'senhaExemplo'; // Altere para a senha desejada
          $hashed_senha = password_hash($senha, PASSWORD_BCRYPT);
          echo 'Senha Hashed: ' . $hashed_senha;
       ?>

   Após alterar a senha diretamente no código, abra o arquivo no navegador, copie a senha 'hashed' e salve na tabela com o código abaixo:

    INSERT INTO usuarios (usuario, senha) VALUES ('usuariEscolhido', 'senhaHashed');

4. Criação da tabela de equipamentos:
   CREATE TABLE equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    numero_serie VARCHAR(100) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    data_aquisicao DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    usuario VARCHAR(50) NOT NULL
);

5. Criação da tabela de chamados:
   CREATE TABLE chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Aberto',
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    modulo VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    setor VARCHAR(100) NOT NULL,
    descricao_encerramento TEXT
);

