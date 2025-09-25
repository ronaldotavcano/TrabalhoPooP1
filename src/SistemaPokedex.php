<?php

namespace Src;

use Src\Tipos\PokemonAgua;
use Src\Tipos\PokemonDragao;
use Src\Tipos\PokemonEletrico;
use Src\Tipos\PokemonFantasma;
use Src\Tipos\PokemonFogo;
use Src\Tipos\PokemonGelo;
use Src\Tipos\PokemonInseto;
use Src\Tipos\PokemonLutador;
use Src\Tipos\PokemonNormal;
use Src\Tipos\PokemonPedra;
use Src\Tipos\PokemonPlanta;
use Src\Tipos\PokemonPsiquico;
use Src\Tipos\PokemonTerrestre;
use Src\Tipos\PokemonVenenoso;
use Src\Tipos\PokemonVoador;


class SistemaPokedex{
    
    private Pokedex $pokedex; 
    private bool $systemOn; 

    public function __construct(){
        $this->pokedex = new Pokedex(); 
        $this->systemOn = true; // Define sistema estando ativo
    }

    public function start(): void{
        $this->showWelcomeMessage(); 
        
        while ($this->systemOn) {
            $this->showMenu(); 
            $option = $this->readOption(); 
            $this->processOption($option); 
        }
        
        $this->showExitMessage(); 
    }

    private function showWelcomeMessage(): void{       
        echo "\n     SISTEMA DE POKÉDEX \n";   
        echo "Bem-vindo ao sistema de gerenciamento de Pokémon!\n";
        echo "Aqui você pode cadastrar, buscar e gerenciar seus Pokémon.\n";
    }

    private function showMenu(): void{
        echo "\n--- MENU PRINCIPAL ---\n";
        echo "1) Cadastrar novo Pokémon\n";
        echo "2) Buscar Pokémon por número\n";
        echo "3) Buscar Pokémon por nome\n";
        echo "4) Listar todos os Pokémon\n";
        echo "5) Exibir estatísticas da Pokédex\n";
        echo "0) Sair do sistema\n";
        echo "----------------------\n";
    }

    private function readOption(): int{
        $option = readline("Digite sua opção: "); 
        return (int) $option;
    }

    private function processOption(int $option): void{
        switch ($option) {
            case 1:
                $this->registerPokemon(); 
                break;
            case 2:
                $this->searchByNumber(); 
                break;
            case 3:
                $this->searchByName(); 
                break;
            case 4:
                $this->listAll(); 
                break;
            case 5:
                $this->showStatistics(); 
                break;
            case 0:
                $this->exit(); 
                break;
            default:
                echo "Opção inválida, tente novamente.\n"; 
        }
    }

    private function registerPokemon(): void{
        echo "\n--- CADASTRAR NOVO POKÉMON ---\n";
        
        $name = readline("Nome do Pokémon: ");
        $description = readline("Descrição: ");
        $number = (int) readline("Número na Pokédex: ");
        $height = (float) readline("Altura (metros): ");
        $weight = (float) readline("Peso (kg): ");
        
        echo "\nTipos disponíveis:\n";
        echo "1. Fogo\n";
        echo "2. Água\n";
        echo "3. Planta\n";
        echo "4. Elétrico\n";
        echo "5. Gelo\n";
        echo "6) Dragão\n";
        echo "7) Fantasma\n";
        echo "8) Inseto\n";
        echo "9) Lutador\n";
        echo "10) Normal\n";
        echo "11) Pedra\n";
        echo "12) Psíquico\n";
        echo "13) Terrestre\n";
        echo "14) Venenoso\n";
        echo "15) Voador\n";
        
        $optionType = (int) readline("Escolha o tipo (1 a 15): ");
        
        
        $pokemon = $this->createPokemonByType($optionType, $name, $description, $number, $height, $weight);
        
        if ($pokemon === null) {
            echo "Tipo inválido, por favor digite entre 1 e 15 \n";
            return;
        }
        
        if ($this->pokedex->addPokemon($pokemon)) {
            echo "Pokémon cadastrado com sucesso!\n";
        } else {
            echo "Erro: Já existe um Pokémon com este número\n";
        }
    }

    private function createPokemonByType(int $optionType, string $name, string $description, int $number, float $height, float $weight): ?Pokemon{
        
        $hasSecondaryType = readline("Deseja adicionar um tipo secundário? (s/n): ");
        $secondaryType = null;
        
        if (strtolower($hasSecondaryType) === 's') {
            $secondaryType = $this->chooseSecondaryType();
        }

        switch ($optionType){
            case 1: 
                return new PokemonFogo($name, $description, $number, $height, $weight, $secondaryType);
            case 2: 
                return new PokemonAgua($name, $description, $number, $height, $weight, $secondaryType);
            case 3: 
                return new PokemonPlanta($name, $description, $number, $height, $weight, $secondaryType);
            case 4: 
                return new PokemonEletrico($name, $description, $number, $height, $weight, $secondaryType);
            case 5: 
                return new PokemonGelo($name, $description, $number, $height, $weight, $secondaryType);
            case 6: 
                return new PokemonDragao($name, $description, $number, $height, $weight, $secondaryType);
            case 7: 
                return new PokemonFantasma($name, $description, $number, $height, $weight, $secondaryType);
            case 8: 
                return new PokemonInseto($name, $description, $number, $height, $weight, $secondaryType);
            case 9: 
                return new PokemonLutador($name, $description, $number, $height, $weight, $secondaryType);
            case 10: 
                return new PokemonNormal($name, $description, $number, $height, $weight, $secondaryType);
            case 11: 
                return new PokemonPedra($name, $description, $number, $height, $weight, $secondaryType);
            case 12: 
                return new PokemonPsiquico($name, $description, $number, $height, $weight, $secondaryType);
            case 13: 
                return new PokemonTerrestre($name, $description, $number, $height, $weight, $secondaryType);
            case 14: 
                return new PokemonVenenoso($name, $description, $number, $height, $weight, $secondaryType);
            case 15: 
                return new PokemonVoador($name, $description, $number, $height, $weight, $secondaryType);
            default:
                return null; 
        }
    }

    private function chooseSecondaryType(): ?Tipo{
        echo "\nTipos disponíveis para tipo secundário:\n";
        echo "1) Fogo\n";
        echo "2) Água\n";
        echo "3) Planta\n";
        echo "4) Elétrico\n";
        echo "5) Gelo\n";
        echo "6) Dragão\n";
        echo "7) Fantasma\n";
        echo "8) Inseto\n";
        echo "9) Lutador\n";
        echo "10) Normal\n";
        echo "11) Pedra\n";
        echo "12) Psíquico\n";
        echo "13) Terrestre\n";
        echo "14) Venenoso\n";
        echo "15) Voador\n";
        
        $optionType = (int) readline("Escolha o tipo secundário (1 a 15): ");
        
        switch ($optionType) {
            case 1: //        Tipagem       Fraquezas              Resistências
                return new Tipo("Fogo", ["Água", "Terra"], ["Planta", "Gelo", "Aço"]);
            case 2: 
                return new Tipo("Água", ["Planta", "Elétrico"], ["Fogo", "Terra", "Pedra"]);
            case 3: 
                return new Tipo("Planta", ["Fogo", "Gelo", "Venenoso", "Voador", "Inseto"], ["Água", "Terra", "Pedra", "Elétrico"]);
            case 4: 
                return new Tipo("Elétrico", ["Terra"], ["Voador", "Água", "Aço"]);
            case 5: 
                return new Tipo("Gelo", ["Fogo", "Lutador", "Pedra", "Aço"], ["Planta", "Terra", "Voador", "Dragão"]);
            case 6: 
                return new Tipo("Dragão", ["Gelo", "Dragão"], ["Fogo", "Água", "Elétrico", "Grama"] );
            case 7: 
                return new Tipo("Fantasma", ["Fantasma"], ["Venenoso", "Inseto"]);
            case 8: 
                return new Tipo("Inseto", ["Fogo", "Voador", "Pedra"], ["Planta", "Lutador", "Terrestre"] );
            case 9: 
                return new Tipo("Lutador", ["Voador", "Psíquico"], ["Inseto", "Pedra"] );
            case 10: 
                return new Tipo("Normal", ["Lutador"], [" "]);
            case 11: 
                return new Tipo("Pedra", ["Água", "Planta", "Lutador", "Terrestre"], ["Fogo", "Normal", "voador", "Venenoso"]);
            case 12: 
                return new Tipo("Psíquico", ["Inseto", "Fantasma"], ["Lutador", "Psíquico"]);
            case 13: 
                return new Tipo("Terrestre", ["Água", "Grama", " Gelo"], ["Venenoso", "Pedra"]);
            case 14: 
                return new Tipo("Venenoso", ["Terrestre", "Psíquico", ], ["Grama", "Lutador", "Venenoso", "Inseto"]);
            case 15: 
                return new Tipo("Voador",["Elétrico", "Gelo", "Pedra"], ["Grama", "Lutador", "Inseto"]);
            default:
                return null; // se nenhum retorna nulo, ou seja apenas 1 tipagem
        }
    }

    private function searchByNumber(): void{
        echo "\n--- BUSCAR POR NÚMERO ---\n";
        $number = (int) readline("Digite o número do Pokémon: ");
        
        $pokemon = $this->pokedex->searchByNumber($number);
        
        if ($pokemon !== null) {
            echo "\n" . $pokemon->showInfos() . "\n";
        } else {
            echo "Pokémon não encontrado!\n";
        }
    } 

    private function searchByName(): void{
        echo "\n--- BUSCAR POR NOME ---\n";
        $name = readline("Digite o nome do Pokémon: ");
        
        $pokemons = $this->pokedex->searchByName($name);
        
        if (!empty($pokemons)) {
            echo "\nPokémon encontrados:\n";
            foreach ($pokemons as $pokemon) {
                echo "- " . $pokemon->showSummary() . "\n";
            }
        } else {
            echo "Nenhum Pokémon encontrado!\n";
        }
    }

    private function listAll(): void{
        echo "\n--- TODOS OS POKÉMON ---\n";
        
        if ($this->pokedex->isEmpty()) {
            echo "A Pokédex está vazia!\n";
            return;
        }
        
        $pokemons = $this->pokedex->listAll();
        
        foreach ($pokemons as $pokemon) {
            echo $pokemon->showSummary() . "\n";
        }
    }

    private function showStatistics(): void{                               
                                // exibir relatório
        echo "\n" . $this->pokedex->showRecord() . "\n";
    }

    private function exit(): void{
        $this->systemOn = false; // Define sistema como inativo
    }

    private function showExitMessage(): void{      
        echo("Obrigado por usar o nosso protótipo de Pokedex.\n");
        echo("Essa foi a 1ª versão da nossa Pokedex, até a próxima, quando ela estiver mais completa");
    }
}
