<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonPlanta extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ) {
        $grassType = new Tipo(
            "Planta",                                         // Tipo
            ["Fogo", "Gelo", "Venenoso", "Voador", "Inseto"], // Fraquezas
            ["Água", "Terra", "Pedra", "Elétrico"]            // Resistencias
        );

        parent::__construct($name, $grassType, $secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray();
        $data['classe'] = 'PokemonPlanta';
        return $data;
    }

    public static function fromArray(array $data): PokemonPlanta{
        
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonPlanta(
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
