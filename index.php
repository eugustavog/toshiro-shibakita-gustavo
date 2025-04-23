<html>
<head>
<title>Exemplo PHP</title>
</head>
<body>

<?php
require_once 'config/db-config.php';

ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

echo 'Versao Atual do PHP: ' . phpversion() . '<br>';
echo 'Servidor: ' . gethostname() . '<br>';

// Criar conexão
$link = new mysqli($db_host, $db_user, $db_password, $db_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$valor_rand1 = rand(1, 999);
$valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));
$host_name = gethostname();

$query = "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) 
          VALUES ('$valor_rand1', '$valor_rand2', '$valor_rand2', '$valor_rand2', '$valor_rand2', '$host_name')";

if ($link->query($query) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $link->error;
}

// Mostrar todos os registros
$result = $link->query("SELECT * FROM dados ORDER BY AlunoID DESC LIMIT 10");
if ($result->num_rows > 0) {
    echo "<h2>Últimos 10 registros:</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Nome</th><th>Host</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["AlunoID"]."</td><td>".$row["Nome"]."</td><td>".$row["Host"]."</td></tr>";
    }
    echo "</table>";
}

$link->close();
?>
</body>
</html>
