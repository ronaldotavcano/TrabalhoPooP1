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
    private GerenciadorTreinadores $trainerManager;
    private bool $systemOn;
    
    // Array com mapeamento de tipos para classes (fraquezas/resistências vêm de Tipo::TYPES_DATA)
    private const TIPOS_POKEMON = [
    // chave                   // nome da classe (::class -> retorna o nome da classe em forma de string)
        1 => ['classe' => PokemonFogo::class],
        2 => ['classe' => PokemonAgua::class],
        3 => ['classe' => PokemonPlanta::class],
        4 => ['classe' => PokemonEletrico::class],
        5 => ['classe' => PokemonGelo::class],
        6 => ['classe' => PokemonDragao::class],
        7 => ['classe' => PokemonFantasma::class],
        8 => ['classe' => PokemonInseto::class],
        9 => ['classe' => PokemonLutador::class],
        10 => ['classe' => PokemonNormal::class],
        11 => ['classe' => PokemonPedra::class],
        12 => ['classe' => PokemonPsiquico::class],
        13 => ['classe' => PokemonTerrestre::class],
        14 => ['classe' => PokemonVenenoso::class],
        15 => ['classe' => PokemonVoador::class]
    ];

    public function __construct(){
        $this->pokedex = new Pokedex();
        $this->trainerManager = new GerenciadorTreinadores($this->pokedex);
        $this->systemOn = true;
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
        echo "Agora na  segunda versão, você também pode Adicionar um treinador.\n";
        echo "editar as informações do treinador ou excluir o treinador.\n";
    }

    private function showMenu(): void{
        echo "\n--- MENU PRINCIPAL ---\n";
        echo "1) Cadastrar novo Pokémon\n";
        echo "2) Buscar Pokémon por número\n";
        echo "3) Buscar Pokémon por nome\n";
        echo "4) Listar todos os Pokémon\n";
        echo "5) Exibir estatísticas da Pokédex\n";
        echo "6) Cadastrar Treinador\n";
        echo "7) Editar Treinador\n";
        echo "8) Excluir Treinador\n";
        echo "9) Listar Treinadores\n";
        echo "10) Buscar Treinador\n";
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
            case 6:
                $this->registerTrainer();
                break;
            case 7:
                $this->editTrainer();
                break;
            case 8:
                $this->deleteTrainer();
                break;
            case 9:
                $this->listTrainers();
                break;
            case 10:
                $this->searchTrainer();
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
        
        $this->showTypesMenu();
        $optionType = (int) readline("Escolha o tipo (1 a 15): ");
        
        $pokemon = $this->createPokemonByType($optionType, $name, $description, $number, $height, $weight);
        
        if ($pokemon === null) {
            echo "Tipo inválido, por favor digite entre 1 e 15\n";
            return;
        }
        
        if ($this->pokedex->addPokemon($pokemon)) {
            echo "Pokémon cadastrado com sucesso!\n";
        } else {
            echo "Erro: Já existe um Pokémon com este número\n";
        }
    }

    private function showTypesMenu(): void{
        echo "\nTipos disponíveis:\n";
        $allTypes = Tipo::getAllTypes();
        foreach ($allTypes as $numero => $tipo) {
            echo "{$numero}) {$tipo['nome']}\n";
        }
    }

    private function createTipoByNumber(int $numero): ?Tipo{
        // 
        return Tipo::createByTypeId($numero);
    }

    private function createPokemonByType(int $optionType, string $name, string $description, int $number, float $height, float $weight): ?Pokemon{
        if ($optionType < 1 || $optionType > 15) {
            return null;
        }
        
        $hasSecondaryType = readline("Deseja adicionar um tipo secundário? (s/n): ");
        $secondaryType = null;
        
        if (strtolower(trim($hasSecondaryType)) === 's') {
            $this->showTypesMenu();
            $optionSecondary = (int) readline("Escolha o tipo secundário (1 a 15): ");
            $secondaryType = $this->createTipoByNumber($optionSecondary);
        }

        try {
            if (!isset(self::TIPOS_POKEMON[$optionType])) {
                return null;
            }
            
            $tipoData = self::TIPOS_POKEMON[$optionType];
            $className = $tipoData['classe'];
            return new $className($name, $description, $number, $height, $weight, $secondaryType);
            
        } catch (\Exception $e) {
            echo "Erro ao criar Pokémon: " . $e->getMessage() . "\n";
            return null;
        }
    }

    private function searchByNumber(): void{
        echo "\n--- BUSCAR POR NÚMERO ---\n";
        $number = (int) readline("Digite o número do Pokémon: ");
        
        $pokemon = $this->pokedex->searchPokemonByNumber($number);
        
        if ($pokemon !== null) {
            echo "\n" . $pokemon->showInfos() . "\n";
        } else {
            echo "Pokémon não encontrado!\n";
        }
    }

    private function searchByName(): void{
        echo "\n--- BUSCAR POR NOME ---\n";
        $name = readline("Digite o nome do Pokémon: ");
        
        $pokemons = $this->pokedex->searchPokemonByName($name);
        
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
        
        if ($this->pokedex->isPokedexEmpty()) {
            echo "A Pokédex está vazia!\n";
            return;
        }
        
        $pokemons = $this->pokedex->listAllPokemons();
        
        foreach ($pokemons as $pokemon) {
            echo $pokemon->showSummary() . "\n";
        }
    }

    private function showStatistics(): void{
        echo "\n" . $this->pokedex->showRecord() . "\n";
    }

    // Funcionalidades de Treinador
    private function registerTrainer(): void{
        echo "\n--- CADASTRAR TREINADOR ---\n";
        
        $name = readline("Nome do Treinador: ");
        $age = (int) readline("Idade do Treinador: ");
        
        $trainer = new Treinador($name, $age);
        
        // Permite adicionar Pokémon ao treinador
        $addPokemon = readline("Deseja adicionar Pokémon ao treinador? (s/n): ");
        if (strtolower(trim($addPokemon)) === 's') {
            $this->addPokemonsToTrainer($trainer);
        }
        
        if ($this->trainerManager->addTrainer($trainer)) {
            echo "Treinador cadastrado com sucesso!\n";
        } else {
            echo "Erro: Já existe um treinador com este nome\n";
        }
    }

    private function addPokemonsToTrainer(Treinador $trainer): void{
        $continue = true;
        while ($continue) {
            $number = (int) readline("Digite o número do Pokémon para adicionar (0 para parar): ");
            
            if ($number === 0) {
                $continue = false;
                continue;
            }
            
            $pokemon = $this->pokedex->searchPokemonByNumber($number);
            if ($pokemon !== null) {
                $level = (int) readline("Digite o nível do Pokémon (padrão: 1): ");
                if ($level < 1) {
                    $level = 1;
                }
                
                if ($trainer->addPokemon($pokemon, $level)) {
                    echo "Pokémon adicionado ao treinador (Nível {$level})!\n";
                } else {
                    echo "Este Pokémon já está com o treinador!\n";
                }
            } else {
                echo "Pokémon não encontrado na Pokédex!\n";
            }
        }
    }

    private function editTrainer(): void{
        echo "\n--- EDITAR TREINADOR ---\n";
        $name = readline("Digite o nome do treinador a editar: ");
        
        $trainer = $this->trainerManager->findTrainer($name);
        if ($trainer === null) {
            echo "Treinador não encontrado!\n";
            return;
        }
        
        echo "\nTreinador encontrado:\n";
        echo $trainer->showInfos() . "\n";
        
        $newName = readline("Novo nome (Enter para manter): ");
        $newAge = readline("Nova idade (Enter para manter): ");
        
        $finalName = trim($newName) !== '' ? $newName : null;
        $finalAge = trim($newAge) !== '' ? (int) $newAge : null;
        
        // Menu para gerenciar Pokémon
        $managePokemon = readline("\nDeseja gerenciar Pokémon do treinador? (s/n): ");
        if (strtolower(trim($managePokemon)) === 's' || strtolower(trim($managePokemon)) === 'sim') {
            $this->manageTrainerPokemons($trainer);
        }
        
        if ($this->trainerManager->updateTrainer($name, $finalName, $finalAge)) {
            $this->trainerManager->saveTrainers();
            echo "Treinador atualizado com sucesso!\n";
        } else {
            echo "Erro ao atualizar treinador!\n";
        }
    }

    private function manageTrainerPokemons(Treinador $trainer): void{
        $continue = true;
        while ($continue) {
            echo "\n--- GERENCIAR POKÉMON DO TREINADOR ---\n";
            echo "1) Adicionar Pokémon\n";
            echo "2) Remover Pokémon\n";
            echo "3) Ver Pokémon do treinador\n";
            echo "0) Voltar\n";
            
            $option = (int) readline("Escolha uma opção: ");
            
            switch ($option) {
                case 1:
                    $this->addPokemonToTrainer($trainer);
                    break;
                case 2:
                    $this->removePokemonFromTrainer($trainer);
                    break;
                case 3:
                    echo "\n" . $trainer->showInfos() . "\n";
                    break;
                case 0:
                    $continue = false;
                    break;
                default:
                    echo "Opção inválida!\n";
            }
        }
    }

    private function addPokemonToTrainer(Treinador $trainer): void{
        echo "\n--- ADICIONAR POKÉMON ---\n";
        $number = (int) readline("Digite o número do Pokémon para adicionar: ");
        
        $pokemon = $this->pokedex->searchPokemonByNumber($number);
        if ($pokemon === null) {
            echo "Pokémon não encontrado na Pokédex!\n";
            return;
        }
        
        $level = (int) readline("Digite o nível do Pokémon (padrão: 1): ");
        if ($level < 1) {
            $level = 1;
        }
        elseif( $level > 100){
            $level = 100;
        }
        
        if ($trainer->addPokemon($pokemon, $level)) {
            echo "Pokémon adicionado ao treinador com sucesso!\n";
        } else {
            echo "Este Pokémon já está com o treinador!\n";
        }
    }

    private function removePokemonFromTrainer(Treinador $trainer): void{
        echo "\n--- REMOVER POKÉMON ---\n";
        
        $pokemons = $trainer->getPokemons();
        if (empty($pokemons)) {
            echo "O treinador não possui Pokémon!\n";
            return;
        }
        
        echo "\nPokémon do treinador:\n";
        foreach ($pokemons as $index => $p) {
            echo ($index + 1) . ") " . $p['pokemon']->showSummary() . " (Nível {$p['level']})\n";
        }
        
        $choice = (int) readline("\nEscolha o número do Pokémon para remover (0 para cancelar): ");
        if ($choice === 0 || $choice < 1 || $choice > count($pokemons)) {
            return;
        }
        
        $pokemonToRemove = $pokemons[$choice - 1];
        $number = $pokemonToRemove['pokemon']->getNumber();
        
        if ($trainer->removePokemon($number)) {
            echo "Pokémon removido com sucesso!\n";
        } else {
            echo "Erro ao remover Pokémon!\n";
        }
    }

    private function deleteTrainer(): void{
        echo "\n--- EXCLUIR TREINADOR ---\n";
        $name = readline("Digite o nome do treinador a excluir: ");
        
        if ($this->trainerManager->removeTrainer($name)) {
            echo "Treinador excluído com sucesso!\n";
        } else {
            echo "Treinador não encontrado!\n";
        }
    }

    private function listTrainers(): void{
        echo "\n--- TODOS OS TREINADORES ---\n";
        
        if ($this->trainerManager->isTrainersEmpty()) {
            echo "Não há treinadores cadastrados!\n";
            return;
        }
        
        $trainers = $this->trainerManager->listAllTrainers();
        foreach ($trainers as $index => $trainer) {
            echo ($index + 1) . ") " . $trainer->getName() . " - " . $trainer->getAge() . " anos - " . $trainer->getTotalPokemons() . " Pokémon(s)\n";
        }
    }

    private function searchTrainer(): void{
        echo "\n--- BUSCAR TREINADOR ---\n";
        $name = readline("Digite o nome do treinador: ");
        
        $trainer = $this->trainerManager->findTrainer($name);
        
        if ($trainer !== null) {
            echo "\n" . $trainer->showInfos() . "\n";
        } else {
            echo "Treinador não encontrado!\n";
        }
    }

    private function exit(): void{
        $this->systemOn = false;
    }

    private function showExitMessage(): void{
        echo "\nObrigado por usar o nosso projeto.\n";
        echo "Essa foi a 2ª versão da nossa Pokedex\n";
        echo "Esperamos que tenha gostado\n";
    }
}
