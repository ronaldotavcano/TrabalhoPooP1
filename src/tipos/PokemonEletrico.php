<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonEletrico extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){
        
        // Usa fonte única de verdade - Tipo ID 4 = Elétrico
        $electricType = Tipo::createByTypeId(4);
        if ($electricType === null) {
            throw new \Exception("Tipo Elétrico não encontrado");
        }

        parent::__construct($name, $electricType,$secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); 
        $data['classe'] = 'PokemonEletrico';
        return $data;
    }

    public static function fromArray(array $data): PokemonEletrico{
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonEletrico(
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
