<?php
echo "<h2>Diagnóstico de Estrutura do CodeIgniter</h2>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br><br>";

echo "Diretório atual: " . __DIR__ . "<br>";
echo "Diretório app: " . realpath(__DIR__ . '/../app') . "<br><br>";

echo "Arquivos existentes:<br>";
$files = [
    'app/Controllers/Auth.php',
    'app/Controllers/TestAuth.php',
    'app/Controllers/Home.php',
    'app/Views/auth/login.php',
    'app/Config/Routes.php',
    'app/Config/App.php',
];

foreach ($files as $file) {
    $path = realpath(__DIR__ . '/../' . $file);
    echo $file . ": " . (file_exists($path) ? "EXISTE" : "NÃO EXISTE") . "<br>";
}