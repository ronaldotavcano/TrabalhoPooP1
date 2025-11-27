<?php

namespace Src;

class Treinador{
    private string $name;
    private int $age;
    private array $pokemons; // Array de ['pokemon' => Pokemon, 'level' => int]

    public function __construct(string $name, int $age, array $pokemons = []){
        $this->name = $name;
        $this->age = $age;
        $this->pokemons = $pokemons;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getAge(): int{
        return $this->age;
    }

    public function getPokemons(): array{
        return $this->pokemons;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function setAge(int $age): void{
        $this->age = $age;
    }

    public function addPokemon(Pokemon $pokemon, int $level = 1): bool{
        // Verifica se o Pokémon já existe (por número)
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $pokemon->getNumber()) {
                return false; // Pokémon já existe
            }
        }
        $this->pokemons[] = ['pokemon' => $pokemon, 'level' => $level];
        return true;
    }

    public function removePokemon(int $number): bool{
        foreach ($this->pokemons as $key => $p) {
            if ($p['pokemon']->getNumber() === $number) {
                unset($this->pokemons[$key]);
                $this->pokemons = array_values($this->pokemons); // Reindexa o array
                return true;
            }
        }
        return false;
    }

    public function findPokemon(int $number): ?Pokemon{
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $number) {
                return $p['pokemon'];
            }
        }
        return null;
    }

    public function getPokemonLevel(int $number): ?int{
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $number) {
                return $p['level'];
            }
        }
        return null;
    }

    public function updatePokemonLevel(int $number, int $newLevel): bool{
        if ($newLevel < 1) {
            return false;
        }
        
        foreach ($this->pokemons as $key => $p) {
            if ($p['pokemon']->getNumber() === $number) {
                $currentLevel = $p['level'];
                if ($newLevel <= $currentLevel) {
                    return false;
                }
                
                $this->pokemons[$key]['level'] = $newLevel;
                return true;
            }
        }
        return false;
    }

    public function getTotalPokemons(): int{
        return count($this->pokemons);
    }

    public function trainerToArray(): array{
        $pokemonsData = [];
        foreach ($this->pokemons as $p) {
            $pokemonsData[] = [
                'nome' => $p['pokemon']->getName(),
                'nivel' => $p['level']
            ];
        }
        
        return [
            'nome' => $this->name,
            'idade' => $this->age,
            'pokemons' => $pokemonsData
        ];
    }

    public static function fromArray(array $data, Pokedex $pokedex): Treinador{
        $pokemons = [];
        
        if (isset($data['pokemons']) && is_array($data['pokemons'])) {
            foreach ($data['pokemons'] as $pokemonData) {
                // Se for formato antigo (com todos os dados), busca pelo número
                if (isset($pokemonData['numero'])) {
                    $pokemon = $pokedex->searchPokemonByNumber($pokemonData['numero']);
                    $level = $pokemonData['nivel'] ?? 1;
                    if ($pokemon !== null) {
                        $pokemons[] = ['pokemon' => $pokemon, 'level' => $level];
                    }
                }
                // Se for formato novo (apenas nome e nível)
                elseif (isset($pokemonData['nome'])) {
                    $foundPokemons = $pokedex->searchPokemonByName($pokemonData['nome']);
                    if (!empty($foundPokemons)) {
                        // Pega o primeiro Pokémon encontrado com esse nome
                        $pokemon = $foundPokemons[0];
                        $level = $pokemonData['nivel'] ?? 1;
                        $pokemons[] = ['pokemon' => $pokemon, 'level' => $level];
                    }
                }
            }
        }
        
        return new Treinador($data['nome'], $data['idade'], $pokemons);
    }

    public function showInfos(): string{
        $info = "=== TREINADOR ===\n";
        $info .= "Nome: {$this->name}\n";
        $info .= "Idade: {$this->age} anos\n";
        $info .= "Total de Pokémon: {$this->getTotalPokemons()}\n";
        
        if (!empty($this->pokemons)) {
            $info .= "\nPokémon do Treinador:\n";
            foreach ($this->pokemons as $p) {
                $info .= "- " . $p['pokemon']->showSummary() . " (Nível {$p['level']})\n";
            }
        }
        
        return $info;
    }
}

