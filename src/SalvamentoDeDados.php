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

class SalvamentoDeDados{
    private string $dataFiles; 

    public function __construct(string $dataFiles = 'data/pokemons.json'){
        $this->dataFiles = $dataFiles;
        $this->creatDirectoryIfNecessary(); 
    }

    private function creatDirectoryIfNecessary(): void{
        // fala que o nome do diretorio recebe data/pokemons.json
        $directory = dirname($this->dataFiles);
        
        // se nn for um diretório, ele vai criar com o mkdir
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    public function savePokemons(array $pokemons): bool{
        try {
            $dataToSave = [];
            // vai salvar os dados no array para cada pokemon no array de pokemons
            foreach ($pokemons as $pokemon) {
                                            // transforma pokemons em array
                $dataToSave[] = $pokemon->pokemonToArray();
            }

            // configura para json
            $json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                return false;
            }
            // coloca o datafiles no json
            $results = file_put_contents($this->dataFiles, $json);
            return $results !== false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function loadPokemons(): array{
        try {
            // se o arquivo nn existir, retorna array vazio
            if (!file_exists($this->dataFiles)) {
                return [];
            }
            // se o conteudo do arquivo for nulo, retorna array vazio
            $fileContents = file_get_contents($this->dataFiles);
            if ($fileContents === false) {
                return [];
            }

            // se a estrutura é nula, retorna um array vazio
            $data = json_decode($fileContents, true);
            if ($data === null) {
                return [];
            }

            $pokemons = [];

            // percorre o array pokemons, cria o array de pokemons e se pokemon nn for nula adiciona ele no array
            foreach ($data as $pokemonData) {
                $pokemon = $this->createPokemonsArray($pokemonData);
                if ($pokemon !== null) {
                    $pokemons[] = $pokemon;
                }
            }
            return $pokemons;  
        } catch (Exception $e) {
            return [];
        }
    }

    private function createPokemonsArray(array $data): ?Pokemon{
        try {
            // se o array data nn tiver a chave classe ou se ela é nula, então retorna nulo
            if (!isset($data['classe'])) {
                return null;
            }

            switch ($data['classe']) {
                case 'PokemonAgua':
                    // cria um nova instancia para o tipo agua e accesa o método estático fromArray (pega os dados do array e transforma em um objeto)
                    return PokemonAgua::fromArray($data);
                case 'PokemonDragao':
                    return PokemonDragao::fromArray($data);
                case 'PokemonEletrico':
                    return PokemonEletrico::fromArray($data);
                case 'PokemonFantasma':
                    return PokemonFantasma::fromArray($data);
                case 'PokemonFogo':
                    return PokemonFogo::fromArray($data);
                case 'PokemonGelo':
                    return PokemonGelo::fromArray($data);
                case 'PokemonInseto':
                    return PokemonInseto::fromArray($data);
                case 'PokemonLutador':
                    return PokemonLutador::fromArray($data);
                case 'PokemonNormal':
                    return PokemonNormal::fromArray($data);
                case 'PokemonPedra':
                    return PokemonPedra::fromArray($data);
                case 'PokemonPlanta':
                    return PokemonPlanta::fromArray($data);
                case 'PokemonPsiquico':
                    return PokemonPsiquico::fromArray($data);
                case 'PokemonTerrestre':
                    return PokemonTerrestre::fromArray($data);
                case 'PokemonVenenoso':
                    return PokemonVenenoso::fromArray($data);
                case 'PokemonVoador':
                    return PokemonVoador::fromArray($data);
                default:
                    return null;
            }            
        } catch (Exception $e) {
            return null;
        }
    }

    public function fileExists(): bool{
        // verifica se o arquivo existe
        return file_exists($this->dataFiles);
    }
}


