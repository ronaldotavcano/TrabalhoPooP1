<?php

require_once 'vendor/autoload.php';

// Importa as classes necessárias
use Src\SistemaPokedex;

try {
    $system = new SistemaPokedex(); // instância (objeto)
        
    $system->start();
    
} catch (Exception $e) {
    
    echo "Error: " . $e->getMessage() . "\n";
    echo "Verifique se o Composer foi instalado corretamente.\n";
    echo "Execute: composer install\n";
}
