<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonVoador extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){  
        $flyingType = new Tipo(
            "Voador",                      // Tipo
            ["Elétrico", "Gelo", "Pedra"], // Fraqueza
            ["Grama", "Lutador", "Inseto"] // Resistencia
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonVoador';
        return $data;
    }

    public static function fromArray(array $data): PokemonVoador{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }
        
        $pokemon = new PokemonVoador(
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