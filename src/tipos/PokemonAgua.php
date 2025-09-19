<?php

namespace Pokemon\Tipos;

use Pokemon\Pokemon;
use Pokemon\Tipo;

/**
 * Classe que representa um Pokémon do tipo Água
 * Aplica o princípio de herança, herdando características da classe Pokemon
 * Suporta tipos duplos (Água + outro tipo)
 */
class PokemonAgua extends Pokemon
{
    /**
     * Construtor da classe PokemonAgua
     * Chama o construtor da classe pai com tipo Água
     * @param string $nome Nome do Pokémon
     * @param string $descricao Descrição do Pokémon
     * @param int $numero Número na Pokédex
     * @param float $altura Altura em metros
     * @param float $peso Peso em quilogramas
     * @param Tipo|null $tipoSecundario Tipo secundário (opcional)
     */
    public function __construct(
        string $nome,
        string $descricao,
        int $numero,
        float $altura,
        float $peso,
        ?Tipo $tipoSecundario = null
    ) {
        // Cria um objeto Tipo para água com suas características
        $tipoAgua = new Tipo(
            "Água",
            "Azul",
            ["Grama", "Elétrico"], // Fraco contra grama e elétrico
            ["Fogo", "Terra", "Pedra"] // Resistente contra fogo, terra e pedra
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($nome, $tipoAgua, $descricao, $numero, $altura, $peso, $tipoSecundario);
    }


    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = parent::toArray(); // Obtém dados da classe pai
        $dados['classe'] = 'PokemonAgua';
        return $dados;
    }

    /**
     * Método estático para criar Pokémon a partir de array (para carregamento)
     * @param array $dados Dados do Pokémon
     * @return PokemonAgua Instância do Pokémon
     */
    public static function fromArray(array $dados): PokemonAgua
    {
        // Cria tipo secundário se existir
        $tipoSecundario = null;
        if (isset($dados['tipo_secundario'])) {
            $tipoSecundario = new Tipo(
                $dados['tipo_secundario']['nome'],
                $dados['tipo_secundario']['cor'],
                $dados['tipo_secundario']['fraquezas'] ?? [],
                $dados['tipo_secundario']['resistencia'] ?? []
            );
        }

        $pokemon = new PokemonAgua(
            $dados['nome'],
            $dados['descricao'],
            $dados['numero'],
            $dados['altura'],
            $dados['peso'],
            $tipoSecundario
        );
        return $pokemon;
    }
}
