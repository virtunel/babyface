<?php
require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    echo "Conexão bem sucedida!";
} catch(Exception $e) {
    echo "Erro: " . $e->getMessage();
}
