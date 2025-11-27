<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonPedra extends Pokemon{

    public function __construct(string $name,string $description,int $number,float $height,float $weight,?Tipo $secondaryType = null){  
        $rockType = Tipo::createByTypeId(11);
        if ($rockType === null) {
            throw new \Exception("Tipo Pedra não encontrado");
        }
        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($name, $rockType,$secondaryType, $description, $number, $height, $weight);
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