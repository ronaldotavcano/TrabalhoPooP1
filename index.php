<?php

/**
 * Arquivo principal do Sistema de Pokédex
 * Este é o ponto de entrada da aplicação CLI
 * 
 * Requisitos atendidos:
 * - Aplicação CLI (Command-Line Interface)
 * - Uso do Composer para autoload
 * - Princípios de abstração e herança
 * - Uso de arrays obrigatório
 * - Mínimo de 5 classes
 * - Uso da função readline para input
 * - Type castings para conversão de entrada
 * - Opções para cadastrar objetos
 */

// Inclui o autoloader do Composer
require_once 'vendor/autoload.php';

// Importa as classes necessárias
use Pokemon\SistemaPokedex;

try {
    // Cria uma instância do sistema de Pokédex
    $sistema = new SistemaPokedex();
    
    // Inicia o sistema
    $sistema->iniciar();
    
} catch (Exception $e) {
    // Trata erros que possam ocorrer durante a execução
    echo "❌ Erro: " . $e->getMessage() . "\n";
    echo "Verifique se o Composer foi instalado corretamente.\n";
    echo "Execute: composer install\n";
}
