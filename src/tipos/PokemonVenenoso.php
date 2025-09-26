<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonVenenoso extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){  
        $poisonType = new Tipo(
            "Venenoso",                                 // Tipo
            ["Terrestre", "Psíquico", ],                // Fraqueza
            ["Grama", "Lutador", "Venenoso", "Inseto"]  // Resistencia
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($name, $poisonType,$secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonVenenoso';
        return $data;
    }

    public static function fromArray(array $data): PokemonVenenoso{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }
        
        $pokemon = new PokemonVenenoso(
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