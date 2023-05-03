<?php
// Verifica se o usuário clicou no botão de enviar o formulário
if(isset($_POST['enviar'])) {
  // Conecta ao banco de dados
  $conexao = mysqli_connect("localhost", "root", "", "cadastro");

  // Verifica se houve erro na conexão
  if(mysqli_connect_errno()) {
    echo "Não foi possível conectar ao banco de dados: " . mysqli_connect_error();
    exit;
  }

  // Pega as informações do formulário
  $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
  $email = mysqli_real_escape_string($conexao, $_POST['email']);
  $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

  // Verifica se o e-mail já existe no banco de dados
  $consulta = "SELECT * FROM usuarios WHERE email='$email'";
  $resultado = mysqli_query($conexao, $consulta);
  if(mysqli_num_rows($resultado) > 0) {
    echo "O e-mail informado já está cadastrado.";
    exit;
  }

  // Insere os dados do usuário no banco de dados
  $inserir = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
  if(mysqli_query($conexao, $inserir)) {
    echo "Usuário cadastrado com sucesso!";
  } else {
    echo "Não foi possível cadastrar o usuário: " . mysqli_error($conexao);
  }

  // Fecha a conexão com o banco de dados
  mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Cadastro de Usuário</title>
</head>
<body>
  <h1>Cadastro de Usuário</h1>
  <form method="post">
    <p>
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>
    </p>
    <p>
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>
    </p>
    <p>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required>
    </p>
    <p>
      <input type="submit" name="enviar" value="Cadastrar">
    </p>
  </form>
</body>
</html>
