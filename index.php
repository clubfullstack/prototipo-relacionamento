<?php
// Configuração de conexão com o banco de dados
$host = "sql.example.com"; // Substituir pelo host do banco
$user = "seu_usuario";     // Substituir pelo usuário do banco
$password = "sua_senha";   // Substituir pela senha do banco
$database = "ciclico";     // Substituir pelo nome do banco

// Conexão com o banco
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Lógica de Cadastro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $specialty = $_POST["specialty"];
    $description = $_POST["description"];
    $location = $_POST["location"];

    // Query de inserção
    $sql = "INSERT INTO users (name, email, specialty, description, location) 
            VALUES ('$name', '$email', '$specialty', '$description', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='color: green;'>Usuário cadastrado com sucesso!</div>";
    } else {
        echo "<div style='color: red;'>Erro ao cadastrar: " . $conn->error . "</div>";
    }
}

// Lógica de Busca
$searchResults = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
    $query = $_POST["searchInput"];
    $sql = "SELECT * FROM users WHERE specialty LIKE '%$query%' OR description LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
}

// Fechar conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Cadastro e Busca</title>
</head>
<body>
    <h1>Cadastro de Usuários</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="specialty" placeholder="Especialidade" required>
        <textarea name="description" placeholder="Descrição"></textarea>
        <input type="text" name="location" placeholder="Localização" required>
        <button type="submit" name="register">Cadastrar</button>
    </form>

    <h1>Busca de Usuários</h1>
    <form method="POST">
        <input type="text" name="searchInput" placeholder="Buscar especialidades" required>
        <button type="submit" name="search">Buscar</button>
    </form>

    <h2>Resultados da Busca</h2>
    <?php if (!empty($searchResults)): ?>
        <ul>
            <?php foreach ($searchResults as $user): ?>
                <li>
                    <strong><?php echo $user['name']; ?></strong> - <?php echo $user['specialty']; ?>
                    <p><?php echo $user['description']; ?></p>
                    <small><?php echo $user['location']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($_POST["search"])): ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif; ?>
</body>
</html>
