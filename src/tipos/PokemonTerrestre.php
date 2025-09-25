<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonTerrestre extends Pokemon{

    public function construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){
        $groundType = new Tipo(
            "Terrestre",                // Tipo
            ["Água", "Grama", " Gelo"], // Fraqueza
            ["Venenoso", "Pedra"]       // Resistencia
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::construct($secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonTerrestre';
        return $data;
    }

    public static function fromArray(array $data): PokemonTerrestre{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonTerrestre(
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