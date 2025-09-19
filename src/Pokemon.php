<?php

namespace Pokemon;

/**
 * Classe abstrata que representa um Pokémon
 * Aplica o princípio de abstração definindo características comuns de todos os Pokémon
 * Esta classe não pode ser instanciada diretamente, apenas suas subclasses
 */
abstract class Pokemon
{
    // Propriedades protegidas (acessíveis pelas subclasses)
    protected string $nome; // Nome do Pokémon
    protected Tipo $tipoPrimario; // Tipo primário do Pokémon
    protected ?Tipo $tipoSecundario; // Tipo secundário do Pokémon (pode ser null)
    protected string $descricao; // Descrição breve do Pokémon
    protected int $numero; // Número na Pokédex
    protected float $altura; // Altura em metros
    protected float $peso; // Peso em quilogramas

    /**
     * Construtor da classe Pokemon
     * @param string $nome Nome do Pokémon
     * @param Tipo $tipoPrimario Tipo primário do Pokémon
     * @param string $descricao Descrição do Pokémon
     * @param int $numero Número na Pokédex
     * @param float $altura Altura em metros
     * @param float $peso Peso em quilogramas
     * @param Tipo|null $tipoSecundario Tipo secundário do Pokémon (opcional)
     */
    public function __construct(
        string $nome,
        Tipo $tipoPrimario,
        string $descricao,
        int $numero,
        float $altura,
        float $peso,
        ?Tipo $tipoSecundario = null
    ) {
        $this->nome = $nome;
        $this->tipoPrimario = $tipoPrimario;
        $this->tipoSecundario = $tipoSecundario;
        $this->descricao = $descricao;
        $this->numero = $numero;
        $this->altura = $altura;
        $this->peso = $peso;
    }

    /**
     * Método getter para obter o nome do Pokémon
     * @return string Nome do Pokémon
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Método getter para obter o tipo primário do Pokémon
     * @return Tipo Objeto Tipo primário do Pokémon
     */
    public function getTipoPrimario(): Tipo
    {
        return $this->tipoPrimario;
    }

    /**
     * Método getter para obter o tipo secundário do Pokémon
     * @return Tipo|null Objeto Tipo secundário do Pokémon ou null
     */
    public function getTipoSecundario(): ?Tipo
    {
        return $this->tipoSecundario;
    }

    /**
     * Método para obter todos os tipos do Pokémon
     * @return array Array com os tipos do Pokémon
     */
    public function getTipos(): array
    {
        $tipos = [$this->tipoPrimario];
        if ($this->tipoSecundario !== null) {
            $tipos[] = $this->tipoSecundario;
        }
        return $tipos;
    }

    /**
     * Método para verificar se o Pokémon tem tipo secundário
     * @return bool True se tem tipo secundário, false caso contrário
     */
    public function temTipoSecundario(): bool
    {
        return $this->tipoSecundario !== null;
    }

    /**
     * Método getter para obter a descrição do Pokémon
     * @return string Descrição do Pokémon
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Método getter para obter o número do Pokémon
     * @return int Número na Pokédex
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * Método getter para obter a altura do Pokémon
     * @return float Altura em metros
     */
    public function getAltura(): float
    {
        return $this->altura;
    }

    /**
     * Método getter para obter o peso do Pokémon
     * @return float Peso em quilogramas
     */
    public function getPeso(): float
    {
        return $this->peso;
    }


    /**
     * Método para exibir informações completas do Pokémon
     * @return string String formatada com todas as informações
     */
    public function exibirInformacoes(): string
    {
        $info = "=== POKÉMON ===\n";
        $info .= "Nome: {$this->nome}\n";
        $info .= "Número: #{$this->numero}\n";
        
        // Exibe tipos (primário e secundário se existir)
        $tipos = $this->tipoPrimario->getNome();
        if ($this->tipoSecundario !== null) {
            $tipos .= " / " . $this->tipoSecundario->getNome();
        }
        $info .= "Tipo(s): {$tipos}\n";
        
        $info .= "Descrição: {$this->descricao}\n";
        $info .= "Altura: {$this->altura}m\n";
        $info .= "Peso: {$this->peso}kg\n";
        
        return $info;
    }

    /**
     * Método para exibir informações resumidas do Pokémon
     * @return string String formatada com informações básicas
     */
    public function exibirResumo(): string
    {
        $tipos = $this->tipoPrimario->getNome();
        if ($this->tipoSecundario !== null) {
            $tipos .= "/" . $this->tipoSecundario->getNome();
        }
        return "#{$this->numero} - {$this->nome} ({$tipos})";
    }

    /**
     * Método para serializar o Pokémon para array (para persistência)
     * @return array Array com dados do Pokémon
     */
    public function toArray(): array
    {
        $dados = [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'numero' => $this->numero,
            'altura' => $this->altura,
            'peso' => $this->peso,
            'tipo_primario' => [
                'nome' => $this->tipoPrimario->getNome(),
                'cor' => $this->tipoPrimario->getCor(),
                'fraquezas' => $this->tipoPrimario->getFraquezas(),
                'resistencia' => $this->tipoPrimario->getResistencia()
            ]
        ];

        // Adiciona tipo secundário se existir
        if ($this->tipoSecundario !== null) {
            $dados['tipo_secundario'] = [
                'nome' => $this->tipoSecundario->getNome(),
                'cor' => $this->tipoSecundario->getCor(),
                'fraquezas' => $this->tipoSecundario->getFraquezas(),
                'resistencia' => $this->tipoSecundario->getResistencia()
            ];
        }

        return $dados;
    }
}
