<?php

namespace Pokemon;

/**
 * Classe que representa uma Pokédex
 * Gerencia uma coleção de Pokémon usando arrays
 * Aplica o princípio de abstração ao trabalhar com objetos Pokemon
 * Integra com sistema de persistência para salvar/carregar dados
 */
class Pokedex
{
    // Propriedades privadas da classe
    private array $pokemons; // Array que contém todos os Pokémon cadastrados
    private int $totalPokemons; // Contador do total de Pokémon cadastrados
    private PersistenciaPokemon $persistencia; // Objeto para gerenciar persistência

    /**
     * Construtor da classe Pokedex
     * Inicializa o array vazio, contador zerado e sistema de persistência
     */
    public function __construct()
    {
        $this->pokemons = []; // Inicializa array vazio
        $this->totalPokemons = 0; // Inicializa contador em zero
        $this->persistencia = new PersistenciaPokemon(); // Cria sistema de persistência
        $this->carregarDados(); // Carrega dados salvos automaticamente
    }

    /**
     * Método para adicionar um Pokémon à Pokédex
     * @param Pokemon $pokemon Objeto Pokémon a ser adicionado
     * @return bool True se adicionado com sucesso, false se já existir
     */
    public function adicionarPokemon(Pokemon $pokemon): bool
    {
        // Verifica se já existe um Pokémon com o mesmo número
        if ($this->buscarPorNumero($pokemon->getNumero()) !== null) {
            return false; // Retorna false se já existir
        }

        // Adiciona o Pokémon ao array usando o número como chave
        $this->pokemons[$pokemon->getNumero()] = $pokemon;
        $this->totalPokemons++; // Incrementa o contador
        
        // Salva automaticamente após adicionar
        $this->salvarDados();
        
        return true; // Retorna true se adicionado com sucesso
    }

    /**
     * Método para buscar um Pokémon pelo número
     * @param int $numero Número do Pokémon na Pokédex
     * @return Pokemon|null Retorna o Pokémon se encontrado, null caso contrário
     */
    public function buscarPorNumero(int $numero): ?Pokemon
    {
        // Verifica se existe um Pokémon com o número especificado
        return $this->pokemons[$numero] ?? null;
    }

    /**
     * Método para buscar Pokémon pelo nome
     * @param string $nome Nome do Pokémon
     * @return array Array com Pokémon encontrados (pode haver mais de um)
     */
    public function buscarPorNome(string $nome): array
    {
        $resultado = []; // Array para armazenar resultados
        
        // Percorre todos os Pokémon no array
        foreach ($this->pokemons as $pokemon) {
            // Verifica se o nome contém o termo buscado (busca parcial)
            if (stripos($pokemon->getNome(), $nome) !== false) {
                $resultado[] = $pokemon; // Adiciona ao array de resultados
            }
        }
        
        return $resultado; // Retorna array com resultados
    }

    /**
     * Método para buscar Pokémon por tipo
     * @param string $tipo Nome do tipo
     * @return array Array com Pokémon do tipo especificado
     */
    public function buscarPorTipo(string $tipo): array
    {
        $resultado = []; // Array para armazenar resultados
        
        // Percorre todos os Pokémon no array
        foreach ($this->pokemons as $pokemon) {
            // Verifica se o tipo primário corresponde ao tipo buscado
            if ($pokemon->getTipoPrimario()->getNome() === $tipo) {
                $resultado[] = $pokemon; // Adiciona ao array de resultados
            }
            // Verifica se o tipo secundário corresponde ao tipo buscado
            elseif ($pokemon->getTipoSecundario() !== null && $pokemon->getTipoSecundario()->getNome() === $tipo) {
                $resultado[] = $pokemon; // Adiciona ao array de resultados
            }
        }
        
        return $resultado; // Retorna array com resultados
    }

    /**
     * Método para listar todos os Pokémon cadastrados
     * @return array Array com todos os Pokémon
     */
    public function listarTodos(): array
    {
        return $this->pokemons; // Retorna o array completo
    }

    /**
     * Método para obter o total de Pokémon cadastrados
     * @return int Número total de Pokémon
     */
    public function getTotalPokemons(): int
    {
        return $this->totalPokemons; // Retorna o contador
    }

    /**
     * Método para verificar se a Pokédex está vazia
     * @return bool True se estiver vazia, false caso contrário
     */
    public function estaVazia(): bool
    {
        return empty($this->pokemons); // Verifica se o array está vazio
    }

    /**
     * Método para obter estatísticas da Pokédex
     * @return array Array com estatísticas (total, por tipo, etc.)
     */
    public function obterEstatisticas(): array
    {
        $estatisticas = [
            'total' => $this->totalPokemons,
            'por_tipo' => [],
            'mais_pesado' => null,
            'mais_alto' => null
        ];

        $pesoMaximo = 0;
        $alturaMaxima = 0;

        // Percorre todos os Pokémon para calcular estatísticas
        foreach ($this->pokemons as $pokemon) {
            // Conta Pokémon por tipo primário
            $tipoPrimario = $pokemon->getTipoPrimario()->getNome();
            if (!isset($estatisticas['por_tipo'][$tipoPrimario])) {
                $estatisticas['por_tipo'][$tipoPrimario] = 0;
            }
            $estatisticas['por_tipo'][$tipoPrimario]++;

            // Conta Pokémon por tipo secundário se existir
            if ($pokemon->getTipoSecundario() !== null) {
                $tipoSecundario = $pokemon->getTipoSecundario()->getNome();
                if (!isset($estatisticas['por_tipo'][$tipoSecundario])) {
                    $estatisticas['por_tipo'][$tipoSecundario] = 0;
                }
                $estatisticas['por_tipo'][$tipoSecundario]++;
            }

            // Encontra o Pokémon mais pesado
            if ($pokemon->getPeso() > $pesoMaximo) {
                $pesoMaximo = $pokemon->getPeso();
                $estatisticas['mais_pesado'] = $pokemon;
            }

            // Encontra o Pokémon mais alto
            if ($pokemon->getAltura() > $alturaMaxima) {
                $alturaMaxima = $pokemon->getAltura();
                $estatisticas['mais_alto'] = $pokemon;
            }
        }

        return $estatisticas; // Retorna array com estatísticas
    }

    /**
     * Método para exibir relatório completo da Pokédex
     * @return string String formatada com relatório
     */
    public function exibirRelatorio(): string
    {
        if ($this->estaVazia()) {
            return "A Pokédex está vazia!\n";
        }

        $relatorio = "=== RELATÓRIO DA POKÉDEX ===\n";
        $estatisticas = $this->obterEstatisticas();
        
        $relatorio .= "Total de Pokémon: {$estatisticas['total']}\n\n";
        
        $relatorio .= "Pokémon por tipo:\n";
        foreach ($estatisticas['por_tipo'] as $tipo => $quantidade) {
            $relatorio .= "- {$tipo}: {$quantidade}\n";
        }
        
        if ($estatisticas['mais_pesado']) {
            $relatorio .= "\nPokémon mais pesado: {$estatisticas['mais_pesado']->exibirResumo()} ({$estatisticas['mais_pesado']->getPeso()}kg)\n";
        }
        
        if ($estatisticas['mais_alto']) {
            $relatorio .= "Pokémon mais alto: {$estatisticas['mais_alto']->exibirResumo()} ({$estatisticas['mais_alto']->getAltura()}m)\n";
        }

        return $relatorio; // Retorna string formatada
    }

    /**
     * Método para carregar dados salvos do arquivo
     * @return bool True se carregou com sucesso, false caso contrário
     */
    public function carregarDados(): bool
    {
        try {
            $pokemonsCarregados = $this->persistencia->carregarPokemons();
            
            // Limpa dados atuais
            $this->pokemons = [];
            $this->totalPokemons = 0;
            
            // Adiciona Pokémon carregados
            foreach ($pokemonsCarregados as $pokemon) {
                $this->pokemons[$pokemon->getNumero()] = $pokemon;
                $this->totalPokemons++;
            }
            
            return true; // Retorna true se carregou com sucesso
            
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    /**
     * Método para salvar dados no arquivo
     * @return bool True se salvou com sucesso, false caso contrário
     */
    public function salvarDados(): bool
    {
        try {
            return $this->persistencia->salvarPokemons($this->pokemons);
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    /**
     * Método para fazer backup dos dados
     * @return bool True se backup foi criado, false caso contrário
     */
    public function fazerBackup(): bool
    {
        return $this->persistencia->fazerBackup();
    }

    /**
     * Método para obter informações sobre o arquivo de dados
     * @return array Array com informações do arquivo
     */
    public function obterInformacoesArquivo(): array
    {
        return $this->persistencia->obterInformacoesArquivo();
    }

    /**
     * Método para limpar todos os dados (deletar arquivo)
     * @return bool True se limpou com sucesso, false caso contrário
     */
    public function limparTodosDados(): bool
    {
        try {
            $resultado = $this->persistencia->limparDados();
            
            if ($resultado) {
                // Limpa dados em memória também
                $this->pokemons = [];
                $this->totalPokemons = 0;
            }
            
            return $resultado; // Retorna resultado da operação
            
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    /**
     * Método para verificar se há dados salvos
     * @return bool True se há dados salvos, false caso contrário
     */
    public function temDadosSalvos(): bool
    {
        return $this->persistencia->arquivoExiste();
    }
}
