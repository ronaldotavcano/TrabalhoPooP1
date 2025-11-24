<?php

namespace Src;

class Treinador{
    private string $nome;
    private int $idade;
    private array $pokemons; // Array de ['pokemon' => Pokemon, 'nivel' => int]

    public function __construct(string $nome, int $idade, array $pokemons = []){
        $this->nome = $nome;
        $this->idade = $idade;
        $this->pokemons = $pokemons;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getIdade(): int{
        return $this->idade;
    }

    public function getPokemons(): array{
        return $this->pokemons;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function setIdade(int $idade): void{
        $this->idade = $idade;
    }

    public function adicionarPokemon(Pokemon $pokemon, int $nivel = 1): bool{
        // Verifica se o Pokémon já existe (por número)
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $pokemon->getNumber()) {
                return false; // Pokémon já existe
            }
        }
        $this->pokemons[] = ['pokemon' => $pokemon, 'nivel' => $nivel];
        return true;
    }

    public function removerPokemon(int $numero): bool{
        foreach ($this->pokemons as $key => $p) {
            if ($p['pokemon']->getNumber() === $numero) {
                unset($this->pokemons[$key]);
                $this->pokemons = array_values($this->pokemons); // Reindexa o array
                return true;
            }
        }
        return false;
    }

    public function buscarPokemon(int $numero): ?Pokemon{
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $numero) {
                return $p['pokemon'];
            }
        }
        return null;
    }

    public function getNivelPokemon(int $numero): ?int{
        foreach ($this->pokemons as $p) {
            if ($p['pokemon']->getNumber() === $numero) {
                return $p['nivel'];
            }
        }
        return null;
    }

    public function getTotalPokemons(): int{
        return count($this->pokemons);
    }

    public function treinadorToArray(): array{
        $pokemonsData = [];
        foreach ($this->pokemons as $p) {
            $pokemonsData[] = [
                'nome' => $p['pokemon']->getName(),
                'nivel' => $p['nivel']
            ];
        }
        
        return [
            'nome' => $this->nome,
            'idade' => $this->idade,
            'pokemons' => $pokemonsData
        ];
    }

    public static function fromArray(array $data, Pokedex $pokedex): Treinador{
        $pokemons = [];
        
        if (isset($data['pokemons']) && is_array($data['pokemons'])) {
            foreach ($data['pokemons'] as $pokemonData) {
                // Se for formato antigo (com todos os dados), busca pelo número
                if (isset($pokemonData['numero'])) {
                    $pokemon = $pokedex->searchByNumber($pokemonData['numero']);
                    $nivel = $pokemonData['nivel'] ?? 1;
                    if ($pokemon !== null) {
                        $pokemons[] = ['pokemon' => $pokemon, 'nivel' => $nivel];
                    }
                }
                // Se for formato novo (apenas nome e nível)
                elseif (isset($pokemonData['nome'])) {
                    $pokemonsEncontrados = $pokedex->searchByName($pokemonData['nome']);
                    if (!empty($pokemonsEncontrados)) {
                        // Pega o primeiro Pokémon encontrado com esse nome
                        $pokemon = $pokemonsEncontrados[0];
                        $nivel = $pokemonData['nivel'] ?? 1;
                        $pokemons[] = ['pokemon' => $pokemon, 'nivel' => $nivel];
                    }
                }
            }
        }
        
        return new Treinador($data['nome'], $data['idade'], $pokemons);
    }

    public function showInfos(): string{
        $info = "=== TREINADOR ===\n";
        $info .= "Nome: {$this->nome}\n";
        $info .= "Idade: {$this->idade} anos\n";
        $info .= "Total de Pokémon: {$this->getTotalPokemons()}\n";
        
        if (!empty($this->pokemons)) {
            $info .= "\nPokémon do Treinador:\n";
            foreach ($this->pokemons as $p) {
                $info .= "- " . $p['pokemon']->showSummary() . " (Nível {$p['nivel']})\n";
            }
        }
        
        return $info;
    }
}

