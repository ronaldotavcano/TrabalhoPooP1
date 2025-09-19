<?php

namespace Pokemon\Tipos;

use Pokemon\Pokemon;
use Pokemon\Tipo;

/**
 * Classe que representa um Pokémon do tipo Elétrico
 * Aplica o princípio de herança, herdando características da classe Pokemon
 * Suporta tipos duplos (Elétrico + outro tipo)
 */
class PokemonEletrico extends Pokemon
{
    /**
     * Construtor da classe PokemonEletrico
     * Chama o construtor da classe pai com tipo Elétrico
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
        // Cria um objeto Tipo para elétrico com suas características
        $tipoEletrico = new Tipo(
            "Elétrico",
            "Amarelo",
            ["Terra"], // Fraco contra terra
            ["Voador", "Água", "Aço"] // Resistente contra voador, água e aço
        );

        // Chama o construtor da classe pai (Pokemon)
        parent::__construct($nome, $tipoEletrico, $descricao, $numero, $altura, $peso, $tipoSecundario);
    }


    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = parent::toArray(); // Obtém dados da classe pai
        $dados['classe'] = 'PokemonEletrico';
        return $dados;
    }

    /**
     * Método estático para criar Pokémon a partir de array (para carregamento)
     * @param array $dados Dados do Pokémon
     * @return PokemonEletrico Instância do Pokémon
     */
    public static function fromArray(array $dados): PokemonEletrico
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

        $pokemon = new PokemonEletrico(
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
