<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonFogo extends Pokemon{

    public function __construct(string $name,string $description,int $number,float $height,float $weight,?Tipo $secondaryType = null){
        $fireType = Tipo::createByTypeId(1);
        if ($fireType === null) {
            throw new \Exception("Tipo Fogo não encontrado");
        }

        parent::__construct($name, $fireType, $secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); 
        $data['classe'] = 'PokemonFogo';
        return $data;
    }

    public static function fromArray(array $data): PokemonFogo{
        
        $secondaryType = null;
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonFogo(
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