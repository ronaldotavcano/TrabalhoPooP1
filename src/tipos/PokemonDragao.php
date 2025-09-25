<?php

namespace Src\Tipos;

use Src\Pokemon;
use Src\Tipo;

class PokemonDragao extends Pokemon{

    public function __construct(
        string $name,
        string $description,
        int $number,
        float $height,
        float $weight,
        ?Tipo $secondaryType = null
    ){  
        $dragonType = new Tipo(
            "Dragão",                              // Tipo
            ["Gelo", "Dragão"],                    // Fraquezas
            ["Fogo", "Água", "Elétrico", "Grama"]  // Resistencias
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($secondaryType, $description, $number, $height, $weight);
    }

    public function pokemonToArray(): array{
        $data = parent::pokemonToArray(); // Obtém data da classe pai
        $data['classe'] = 'PokemonDragao';
        return $data;
    }

    // Pq do static, sem o static precisaria ter criado o objeto para chamar o método
    // fromArrray pega os dados do array e transforma em um objeto
    public static function fromArray(array $data): PokemonDragao{
        $secondaryType = null;
            // isset verifica se a variavel existe e se não é nula
        if (isset($data['tipo_secundario'])) {
            $secondaryType = new Tipo(
                $data['tipo_secundario']['nome'],
                $data['tipo_secundario']['fraquezas'] ?? [],
                $data['tipo_secundario']['resistencia'] ?? []
            );
        }
        
        $pokemon = new PokemonDragao(
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