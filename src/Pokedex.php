<?php

namespace Src;

class Pokedex{
    
    private array $pokemons;
    private int $totalPokemons; 
    private SalvamentoDeDados $persistencia; 

    public function __construct(){
        $this->pokemons = []; 
        $this->totalPokemons = 0; 
        $this->persistencia = new SalvamentoDeDados(); 
        $this->loadData(); 
    }

    public function addPokemon(Pokemon $pokemon): bool{
        
        // procura um pokemon pelo numero, se existir um pokemon com aquele numero bloqueia a ação
        if ($this->searchPokemonByNumber($pokemon->getNumber()) !== null) {
            return false; 
        }
        // se não existir ele adiciona no array $pokemons usando o número como chave e o $pokemon como o valor
        $this->pokemons[$pokemon->getNumber()] = $pokemon;
        $this->totalPokemons++;
        $this->saveData();
        
        return true;
    }

    public function searchPokemonByNumber(int $number): ?Pokemon{
        // procura dentro do array pokemons pelo número, se não achar retorna null
        return $this->pokemons[$number] ?? null;
    }

    public function searchPokemonByName(string $name): array{
        $result = []; 
        
        // Percorre todos os Pokémon no array
        foreach ($this->pokemons as $pokemon) {
            // Verifica se o name contém o termo buscado (busca parcial)
            if (stripos($pokemon->getName(), $name) !== false) {
                $result[] = $pokemon; // Adiciona ao array de resultados
            } 
        }      
        return $result;
    }

    public function listAllPokemons(): array{
        // lista o array de pokemons
        return $this->pokemons;
    }

    public function getTotalPokemons(): int{
        // retorna o número total de pokemons
        return $this->totalPokemons;
    }

    public function isPokedexEmpty(): bool{
        // verifica se o array está vazio, se sim retorna 1 se não 0, empty -> nativo do php
        return empty($this->pokemons);
    }

    public function getStatistics(): array{
        $statistics = [
            'total' => $this->totalPokemons,
            // quantos pokemons tem em cada tipagem
            'por_tipo' => [],
            'mais_pesado' => null,
            'mais_alto' => null
        ];

        $maxWeight = 0;
        $maxHeight = 0;

        // Percorre todos os Pokémon para calcular estatísticas
        foreach ($this->pokemons as $pokemon) {
            $primaryType = $pokemon->getPrimaryType()->getName();
            if (!isset($statistics['por_tipo'][$primaryType])) {
                $statistics['por_tipo'][$primaryType] = 0;
            }
            $statistics['por_tipo'][$primaryType]++;

            // Conta Pokémon por tipo secundário se existir
            if ($pokemon->getSecondaryType() !== null) {
                $secondaryType = $pokemon->getSecondaryType()->getName();
                if (!isset($statistics['por_tipo'][$secondaryType])) {
                    $statistics['por_tipo'][$secondaryType] = 0;
                }
                // incrementa +1 no tipo secundário
                $statistics['por_tipo'][$secondaryType]++;
            }

            // Encontra o Pokémon mais pesado
            if ($pokemon->getWeight() > $maxWeight) {
                $maxWeight = $pokemon->getWeight();
                $statistics['mais_pesado'] = $pokemon;
            }

            // Encontra o Pokémon mais alto
            if ($pokemon->getHeight() > $maxHeight) {
                $maxHeight = $pokemon->getHeight();
                $statistics['mais_alto'] = $pokemon;
            }
        }
        return $statistics;
    }

    public function showRecord(): string{
        if ($this->isPokedexEmpty() ) {
            return "A Pokédex está vazia!\n";
        }
        $record = "=== RELATÓRIO DA POKÉDEX ===\n";
        $statistics = $this->getStatistics();
        $record .= "Total de Pokémon: {$statistics['total']}\n\n";
        $record .= "Pokémon por tipo:\n";

        // percorre todos os tipos e mostra sua quantidade
        foreach ($statistics['por_tipo'] as $tipo => $quantity) {
            $record .= "- {$tipo}: {$quantity}\n";
        }
        
        if ($statistics['mais_pesado']) {
                                                                        // retorna um resumo do pokemon mais pesado
            $record .= "\nPokémon mais pesado: {$statistics['mais_pesado']->showSummary()} ({$statistics['mais_pesado']->getWeight()}kg)\n";
        }
        
        if ($statistics['mais_alto']) {
                                                                        // retorna um resumo do pokemon mais alto
            $record .= "Pokémon mais alto: {$statistics['mais_alto']->showSummary()} ({$statistics['mais_alto']->getHeight()}m)\n";
        }
        return $record;
    }

    public function loadData(): bool{
        try {
            $pokemonsCarregados = $this->persistencia->loadPokemons();
            
            // Limpa dados antigos
            $this->pokemons = [];
            $this->totalPokemons = 0;
            
            // Adiciona Pokémon carregados (dados novos)
            foreach ($pokemonsCarregados as $pokemon) {
                $this->pokemons[$pokemon->getNumber()] = $pokemon;
                $this->totalPokemons++;
            }
            
            return true; // Retorna true se carregou com sucesso
            
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    public function saveData(): bool{
        try {
            // salvamento de dados acessa o array pokemon 
            return $this->persistencia->savePokemons($this->pokemons);
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    public function hasDataSaved(): bool{
        // verifica se o arquivo de salvamento de dados existe
        return $this->persistencia->fileExists();
    }
}
