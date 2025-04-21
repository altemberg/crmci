<?php
define('APPPATH', '../app/');
define('SYSTEMPATH', '../system/');

// Carrega o arquivo de rotas diretamente
$routes_content = file_get_contents(APPPATH . 'Config/Routes.php');
echo "<h2>Conteúdo do arquivo Routes.php:</h2>";
echo "<pre>" . htmlspecialchars($routes_content) . "</pre>";

// Tenta carregar a rota padrão
require APPPATH . '../vendor/autoload.php';
$routes = \Config\Services::routes();
$routes->loadRoutes();

echo "<h2>Rotas carregadas:</h2>";
echo "<pre>";
print_r($routes->getRoutes());
echo "</pre>";