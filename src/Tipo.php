<?php

namespace Src;

class Tipo{
    private string $name;  
    private array $weakeness; 
    private array $resistance;
    
    
    private const TYPES_DATA = [
        1 => [
            'nome' => 'Fogo',
            'fraquezas' => ['Água', 'Terra'],
            'resistencia' => ['Planta', 'Gelo', 'Aço']
        ],
        2 => [
            'nome' => 'Água',
            'fraquezas' => ['Planta', 'Elétrico'],
            'resistencia' => ['Fogo', 'Terra', 'Pedra']
        ],
        3 => [
            'nome' => 'Planta',
            'fraquezas' => ['Fogo', 'Gelo', 'Venenoso', 'Voador', 'Inseto'],
            'resistencia' => ['Água', 'Terra', 'Pedra', 'Elétrico']
        ],
        4 => [
            'nome' => 'Elétrico',
            'fraquezas' => ['Terra'],
            'resistencia' => ['Voador', 'Água', 'Aço']
        ],
        5 => [
            'nome' => 'Gelo',
            'fraquezas' => ['Fogo', 'Lutador', 'Pedra', 'Aço'],
            'resistencia' => ['Planta', 'Terra', 'Voador', 'Dragão']
        ],
        6 => [
            'nome' => 'Dragão',
            'fraquezas' => ['Gelo', 'Dragão'],
            'resistencia' => ['Fogo', 'Água', 'Elétrico', 'Grama']
        ],
        7 => [
            'nome' => 'Fantasma',
            'fraquezas' => ['Fantasma'],
            'resistencia' => ['Venenoso', 'Inseto']
        ],
        8 => [
            'nome' => 'Inseto',
            'fraquezas' => ['Fogo', 'Voador', 'Pedra'],
            'resistencia' => ['Planta', 'Lutador', 'Terrestre']
        ],
        9 => [
            'nome' => 'Lutador',
            'fraquezas' => ['Voador', 'Psíquico'],
            'resistencia' => ['Inseto', 'Pedra']
        ],
        10 => [
            'nome' => 'Normal',
            'fraquezas' => ['Lutador'],
            'resistencia' => ['']
        ],
        11 => [
            'nome' => 'Pedra',
            'fraquezas' => ['Água', 'Planta', 'Lutador', 'Terrestre'],
            'resistencia' => ['Fogo', 'Normal', 'Voador', 'Venenoso']
        ],
        12 => [
            'nome' => 'Psíquico',
            'fraquezas' => ['Inseto', 'Fantasma'],
            'resistencia' => ['Lutador', 'Psíquico']
        ],
        13 => [
            'nome' => 'Terrestre',
            'fraquezas' => ['Água', 'Grama', 'Gelo'],
            'resistencia' => ['Venenoso', 'Pedra']
        ],
        14 => [
            'nome' => 'Venenoso',
            'fraquezas' => ['Terrestre', 'Psíquico'],
            'resistencia' => ['Grama', 'Lutador', 'Venenoso', 'Inseto']
        ],
        15 => [
            'nome' => 'Voador',
            'fraquezas' => ['Elétrico', 'Gelo', 'Pedra'],
            'resistencia' => ['Grama', 'Lutador', 'Inseto']
        ]
    ]; 

    public function __construct(string $name, array $weakeness = [], array $resistance = []){
        $this->name = $name;
        $this->weakeness = $weakeness;
        $this->resistance = $resistance;
    }

    public function getName(): string{
        return $this->name;
    }
    // Fogo, in_array -> [PokemonsTipos] -> Fogo (Agua / Terra) // true 
    public function getWeakness(): array{
        return $this->weakeness;
    }

    public function getResistance(): array{
        return $this->resistance;
    }
    // tipo alvo -> ex: Fogo (alvo) é fraco contra ["água", "terrestre"]
    public function isWeakAgainst(string $targetType): bool{
                // função in_array procura no array se targetType está dentro do array de fraquezas se sim, return True
        return in_array($targetType, $this->weakeness);
    }
    // tipo alvo -> ex: Fogo (alvo) é resistente contra ["água", "terrestre"]
    public function isResistanceAgainst(string $targetType): bool{
        return in_array($targetType, $this->resistance);
    }

    public function showInfos(): string{
        $info = "Tipo: {$this->name}\n";
        
        if (!empty($this->weakeness)) {
                                        // implode -> transforma um array em string, o 1º) Parametro é o separador
                                        // ex: weakness = ["Água", "Terrestre"] -> implode(", $this->weakness") OUTPUT: Água, Terrestre
            $info .= "Fraco contra: " . implode(", ", $this->weakeness) . "\n";
        }
        
        if (!empty($this->resistance)) {
            $info .= "Resistente contra: " . implode(", ", $this->resistance) . "\n";
        }
        
        return $info;
    }
    
    // Método estático para criar Tipo baseado no ID (usa fonte única de verdade)
    public static function createByTypeId(int $typeId): ?Tipo{
        if (!isset(self::TYPES_DATA[$typeId])) {
            return null;
        }
        
        $typeData = self::TYPES_DATA[$typeId];
        return new Tipo(
            $typeData['nome'],
            $typeData['fraquezas'],
            $typeData['resistencia']
        );
    }
    
    // Método estático para obter dados do tipo (para uso em outras classes)
    public static function getTypeData(int $typeId): ?array{
        return self::TYPES_DATA[$typeId] ?? null;
    }
    
    // Método estático para obter todos os tipos (para menus, etc)
    public static function getAllTypes(): array{
        return self::TYPES_DATA;
    }
}
