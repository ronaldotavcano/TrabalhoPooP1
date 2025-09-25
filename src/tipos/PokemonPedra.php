<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonPedra extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){  
        $rockType = new Tipo(
            "Pedra",                                    // Tipo
            ["Água", "Planta", "Lutador", "Terrestre"], // Fraquezas
            ["Fogo", "Normal", "voador", "Venenoso"]    // Resistencias
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonPedra';
        return $data;
    }

    public static function fromArray(array $data): PokemonPedra{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }
        
        $pokemon = new PokemonPedra(
            $data['nome'],
            $data['descrição'],
            $data['numero'],
            $data['altura'],
            $data['peso'],
            $secondaryType
        );
        return $pokemon;
    }
}