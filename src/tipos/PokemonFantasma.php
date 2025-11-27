<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonFantasma extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){  
        // Usa fonte única de verdade - Tipo ID 7 = Fantasma
        $ghostType = Tipo::createByTypeId(7);
        if ($ghostType === null) {
            throw new \Exception("Tipo Fantasma não encontrado");
        }

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($name, $ghostType,$secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonFantasma';
        return $data;
    }

    public static function fromArray(array $data): PokemonFantasma{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }
        
        $pokemon = new PokemonFantasma(
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