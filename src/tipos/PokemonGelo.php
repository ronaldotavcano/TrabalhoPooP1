<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;


class PokemonGelo extends Pokemon{
    
    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ) {
        $iceType = new Tipo(
            "Gelo",                                 // Tipo
            ["Fogo", "Lutador", "Pedra", "Aço"],    // Fraquezas 
            ["Planta", "Terra", "Voador", "Dragão"] // Resistencias
        );
        parent::__construct($name, $iceType, $secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray();
        $data['classe'] = 'PokemonGelo';
        return $data;
    }

    public static function fromArray(array $data): PokemonGelo{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonGelo(
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
