<?php

namespace Src;

class Tipo{
    private string $name;  
    private array $weakeness; 
    private array $resistance; 

    public function __construct(string $name, array $weakeness = [], array $resistance = []){
        $this->name = $name;
        $this->weakeness = $weakeness;
        $this->resistance = $resistance;
    }

    public function getName(): string{
        return $this->name;
    }

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
}
