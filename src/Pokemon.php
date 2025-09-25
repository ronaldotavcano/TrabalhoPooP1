<?php

namespace Src;

abstract class Pokemon{
    // Pq protected, pq as classes que herdam teram acesso
    protected string $name;  
    protected Tipo $primaryType;    
    protected ?Tipo $secondaryType; // ?Tipo-> significa que pode receber o valor nulo.
    protected string $description; 
    protected int $number; 
    protected float $height; 
    protected float $weight; 

    public function __construct(
        string $name,
        Tipo $primaryType,
        ?Tipo $secondaryType = null,
        string $description,
        int $number,
        float $height,
        float $weight,){
        $this->name = $name;
        $this->primaryType = $primaryType;
        $this->secondaryType = $secondaryType;
        $this->description = $description;
        $this->number = $number;
        $this->height = $height;
        $this->weight = $weight;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getPrimaryType(): Tipo{
        return $this->primaryType;
    }

    public function getSecondaryType(): ?Tipo{
        return $this->secondaryType;
    }

    public function getTypes(): array{
        // váriavel types é um array que recebe primeiro o tipo primário
        $types = [$this->primaryType];
        if ($this->secondaryType !== null) {
            $types[] = $this->secondaryType;
        }
        return $types;
    }

    public function hasSecondaryType(): bool{
        return $this->secondaryType !== null;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getNumber(): int{
        return $this->number;
    }

    public function getHeight(): float{
        return $this->height;
    }

    public function getWeight(): float{
        return $this->weight;
    }

    public function showInfos(): string{
        //operador .= serve para concatenar strings 
        $info = "=== POKÉMON ===\n";
        $info .= "Nome: {$this->name}\n";
        $info .= "Número: {$this->number}\n";
        
        $types = $this->primaryType->getName();
        if ($this->secondaryType !== null){
            $types .= " / " . $this->secondaryType->getName();
        }
        $info .= "Tipo(s): {$types}\n";
        
        $info .= "Descrição: {$this->description}\n";
        $info .= "Altura: {$this->height}m\n";
        $info .= "Peso: {$this->weight}kg\n";
        
        return $info;
    }

    public function showSummary(): string{
        $tipos = $this->primaryType->getName();
        if ($this->secondaryType !== null) {
            $tipos .= "/" . $this->secondaryType->getName();
        }
        return "{$this->number} - {$this->name} ({$tipos})"; //ex: 006 - Charizard - (Fogo/Voador)
    }

    public function pokemonToArray(): array{
        $data = [
            // Array associativo para salvar no pokemons.json, equivalente ao 'chave': valor,
            'nome' => $this->name,
            'descrição' => $this->description,
            'numero' => $this->number,
            'altura' => $this->height,
            'peso' => $this->weight,
            'tipo_primario' => [
                'nome' => $this->primaryType->getName(),
                'fraquezas' => $this->primaryType->getWeakness(),
                'resistencia' => $this->primaryType->getResistance()
            ]
        ];
        // Adiciona tipo secundário se existir
        if ($this->secondaryType !== null) {
            $data['tipo_secundario'] = [
                'nome' => $this->secondaryType->getName(),
                'fraquezas' => $this->secondaryType->getWeakness(),
                'resistencia' => $this->secondaryType->getResistance()
            ];
        }
        return $data;
    }
}
