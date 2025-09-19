<?php

namespace Pokemon\Tipos;

use Pokemon\Pokemon;
use Pokemon\Tipo;

/**
 * Classe que representa um Pokémon do tipo Grama
 * Aplica o princípio de herança, herdando características da classe Pokemon
 * Suporta tipos duplos (Grama + outro tipo)
 */
class PokemonGrama extends Pokemon
{
    /**
     * Construtor da classe PokemonGrama
     * Chama o construtor da classe pai com tipo Grama
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
        // Cria um objeto Tipo para grama com suas características
        $tipoGrama = new Tipo(
            "Grama",
            "Verde",
            ["Fogo", "Gelo", "Venenoso", "Voador", "Inseto"], // Fraco contra vários tipos
            ["Água", "Terra", "Pedra", "Elétrico"] // Resistente contra água, terra, pedra e elétrico
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($nome, $tipoGrama, $descricao, $numero, $altura, $peso, $tipoSecundario);
    }


    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = parent::toArray(); // Obtém dados da classe pai
        $dados['classe'] = 'PokemonGrama';
        return $dados;
    }

    /**
     * Método estático para criar Pokémon a partir de array (para carregamento)
     * @param array $dados Dados do Pokémon
     * @return PokemonGrama Instância do Pokémon
     */
    public static function fromArray(array $dados): PokemonGrama
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

        $pokemon = new PokemonGrama(
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
