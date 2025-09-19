<?php

namespace Pokemon\Tipos;

use Pokemon\Pokemon;
use Pokemon\Tipo;

/**
 * Classe que representa um Pokémon do tipo Fogo
 * Aplica o princípio de herança, herdando características da classe Pokemon
 * Suporta tipos duplos (Fogo + outro tipo)
 */
class PokemonFogo extends Pokemon
{
    /**
     * Construtor da classe PokemonFogo
     * Chama o construtor da classe pai com tipo Fogo
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
        // Cria um objeto Tipo para fogo com suas características
        $tipoFogo = new Tipo(
            "Fogo",
            "Vermelho",
            ["Água", "Terra"], // Fraco contra água e terra
            ["Grama", "Gelo", "Aço"] // Resistente contra grama, gelo e aço
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($nome, $tipoFogo, $descricao, $numero, $altura, $peso, $tipoSecundario);
    }


    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = parent::toArray(); // Obtém dados da classe pai
        $dados['classe'] = 'PokemonFogo';
        return $dados;
    }

    /**
     * Método estático para criar Pokémon a partir de array (para carregamento)
     * @param array $dados Dados do Pokémon
     * @return PokemonFogo Instância do Pokémon
     */
    public static function fromArray(array $dados): PokemonFogo
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

        $pokemon = new PokemonFogo(
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
