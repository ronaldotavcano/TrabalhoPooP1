<?php

namespace Src;

use Src\Tipos\PokemonFogo;
use Src\Tipos\PokemonAgua;
use Src\Tipos\PokemonPlanta;
use Src\Tipos\PokemonEletrico;
use Src\Tipos\PokemonGelo;

class PersistenciaPokemon{
    private string $dataFiles; 

    public function __construct(string $dataFiles = 'data/pokemons.json'){
        $this->dataFiles = $dataFiles;
        $this->creatDirectoryIfNecessary(); 
    }

    private function creatDirectoryIfNecessary(): void{
        $directory = dirname($this->dataFiles);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // Cria o diretório, 0755 -> leitura + escrita + execução (rwx) para o dono, grupo e outros
        }
    }

    public function savePokemons(array $pokemons): bool{
        try {
            $dataToSave = [];
            foreach ($pokemons as $pokemon) {
                $dataToSave[] = $pokemon->pokemonToArray();
            }

            // Converte array para json com formatação
            $json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if ($json === false) {
                return false;
            }
            // escreve o conteúdo no arquivo json
            $results = file_put_contents($this->dataFiles, $json);
            return $results !== false;
            
        } catch (Exception $e) {
            return false;
        }
    }

    public function loadPokemons(): array{
        try {
            if (!file_exists($this->dataFiles)) {
                return [];
            }
            $fileContents = file_get_contents($this->dataFiles);
            
            if ($fileContents === false) {
                return [];
            }

            // Decodifica o JSON
            $data = json_decode($fileContents, true);
            
            // Verifica se a decodificação foi bem-sucedida
            if ($data === null) {
                return [];
            }

            $pokemons = [];
            foreach ($data as $pokemonData) {
                $pokemon = $this->createPokemonsArray($pokemonData);
                if ($pokemon !== null) {
                    $pokemons[] = $pokemon; // Adiciona Pokémon válido ao array
                }
            }
            return $pokemons;  

        } catch (Exception $e) {
            return [];
        }
    }
                                                        //Retorna um objeto da classe pokemon ou nulo
    private function createPokemonsArray(array $data): ?Pokemon{
        try {
           
            if (!isset($data['classe'])) {
                return null;
            }

            switch ($data['classe']) {
                case 'PokemonFogo':
                    return PokemonFogo::fromArray($data);
                case 'PokemonAgua':
                    return PokemonAgua::fromArray($data);
                case 'PokemonPlanta':
                    return PokemonPlanta::fromArray($data);
                case 'PokemonEletrico':
                    return PokemonEletrico::fromArray($data);
                case 'PokemonGelo':
                    return PokemonGelo::fromArray($data);
                default:
                    return null;
            }            
        } catch (Exception $e) {
            return null;
        }
    }

    public function fileExists(): bool{
        return file_exists($this->dataFiles);
    }
}