<?php

namespace Pokemon\Tipos;

use Pokemon\Pokemon;
use Pokemon\Tipo;

/**
 * Classe que representa um Pokémon do tipo Gelo
 * Aplica o princípio de herança, herdando características da classe Pokemon
 * Suporta tipos duplos (Gelo + outro tipo)
 */
class PokemonGelo extends Pokemon
{
    /**
     * Construtor da classe PokemonGelo
     * Chama o construtor da classe pai com tipo Gelo
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
        // Cria um objeto Tipo para gelo com suas características
        $tipoGelo = new Tipo(
            "Gelo",
            "Azul Claro",
            ["Fogo", "Lutador", "Pedra", "Aço"], // Fraco contra fogo, lutador, pedra e aço
            ["Grama", "Terra", "Voador", "Dragão"] // Resistente contra grama, terra, voador e dragão
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($nome, $tipoGelo, $descricao, $numero, $altura, $peso, $tipoSecundario);
    }


    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = parent::toArray(); // Obtém dados da classe pai
        $dados['classe'] = 'PokemonGelo';
        return $dados;
    }

    /**
     * Método estático para criar Pokémon a partir de array (para carregamento)
     * @param array $dados Dados do Pokémon
     * @return PokemonGelo Instância do Pokémon
     */
    public static function fromArray(array $dados): PokemonGelo
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

        $pokemon = new PokemonGelo(
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
