<?php
// Arquivo de configuração para conexão com o banco de dados MySQL usando PDO
// Este arquivo cria uma conexão segura e trata erros básicos

// Configurações do banco de dados (ajuste conforme necessário)
$host = 'localhost';          // Endereço do servidor MySQL
$dbname = 'coffee_farm_erp';  // Nome do banco de dados
$user = 'root';               // Usuário do MySQL
$password = '';               // Senha do MySQL (deixe vazio se não houver)

// Tentativa de conexão usando PDO
try {
    // Cria a conexão PDO com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

    // Define o modo de erro para lançar exceções (facilita o debug)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Opcional: Define o modo de busca padrão
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Se chegou aqui, a conexão foi bem-sucedida
    echo "Conexão realizada com sucesso!"; // Descomente para testar

} catch (PDOException $e) {
    // Se houver erro, exibe a mensagem e para o script
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>