<?php

namespace Pokemon;

/**
 * Classe que representa um tipo de Pokémon
 * Aplica o princípio de abstração definindo características comuns dos tipos
 */
class Tipo
{
    // Propriedades privadas da classe
    private string $nome; // Nome do tipo (ex: Fogo, Água, Grama)
    private string $cor; // Cor associada ao tipo
    private array $fraquezas; // Array com tipos que são fracos contra este tipo
    private array $resistencia; // Array com tipos que são resistentes contra este tipo

    /**
     * Construtor da classe Tipo
     * @param string $nome Nome do tipo
     * @param string $cor Cor associada ao tipo
     * @param array $fraquezas Tipos fracos contra este tipo
     * @param array $resistencia Tipos resistentes contra este tipo
     */
    public function __construct(string $nome, string $cor, array $fraquezas = [], array $resistencia = [])
    {
        $this->nome = $nome;
        $this->cor = $cor;
        $this->fraquezas = $fraquezas;
        $this->resistencia = $resistencia;
    }

    /**
     * Método getter para obter o nome do tipo
     * @return string Nome do tipo
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Método getter para obter a cor do tipo
     * @return string Cor do tipo
     */
    public function getCor(): string
    {
        return $this->cor;
    }

    /**
     * Método getter para obter as fraquezas do tipo
     * @return array Array com tipos fracos contra este tipo
     */
    public function getFraquezas(): array
    {
        return $this->fraquezas;
    }

    /**
     * Método getter para obter as resistências do tipo
     * @return array Array com tipos resistentes contra este tipo
     */
    public function getResistencia(): array
    {
        return $this->resistencia;
    }

    /**
     * Método para verificar se um tipo é fraco contra outro
     * @param string $tipoAlvo Tipo a ser verificado
     * @return bool True se for fraco, false caso contrário
     */
    public function ehFracoContra(string $tipoAlvo): bool
    {
        return in_array($tipoAlvo, $this->fraquezas);
    }

    /**
     * Método para verificar se um tipo é resistente contra outro
     * @param string $tipoAlvo Tipo a ser verificado
     * @return bool True se for resistente, false caso contrário
     */
    public function ehResistenteContra(string $tipoAlvo): bool
    {
        return in_array($tipoAlvo, $this->resistencia);
    }

    /**
     * Método para exibir informações do tipo
     * @return string String formatada com informações do tipo
     */
    public function exibirInformacoes(): string
    {
        $info = "Tipo: {$this->nome}\n";
        $info .= "Cor: {$this->cor}\n";
        
        if (!empty($this->fraquezas)) {
            $info .= "Fraco contra: " . implode(", ", $this->fraquezas) . "\n";
        }
        
        if (!empty($this->resistencia)) {
            $info .= "Resistente contra: " . implode(", ", $this->resistencia) . "\n";
        }
        
        return $info;
    }
}
