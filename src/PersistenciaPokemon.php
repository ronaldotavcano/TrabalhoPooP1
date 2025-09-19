<?php

namespace Pokemon;

use Pokemon\Tipos\PokemonFogo;
use Pokemon\Tipos\PokemonAgua;
use Pokemon\Tipos\PokemonGrama;
use Pokemon\Tipos\PokemonEletrico;
use Pokemon\Tipos\PokemonGelo;

/**
 * Classe responsável pela persistência de dados dos Pokémon
 * Gerencia o salvamento e carregamento de Pokémon em arquivo JSON
 * Aplica o princípio de responsabilidade única
 */
class PersistenciaPokemon
{
    // Propriedade privada com o caminho do arquivo de dados
    private string $arquivoDados; // Caminho para o arquivo JSON de persistência

    /**
     * Construtor da classe PersistenciaPokemon
     * @param string $arquivoDados Caminho para o arquivo de dados (opcional)
     */
    public function __construct(string $arquivoDados = 'data/pokemons.json')
    {
        $this->arquivoDados = $arquivoDados;
        $this->criarDiretorioSeNecessario(); // Cria diretório se não existir
    }

    /**
     * Método para criar o diretório de dados se não existir
     */
    private function criarDiretorioSeNecessario(): void
    {
        $diretorio = dirname($this->arquivoDados); // Obtém diretório do arquivo
        
        // Verifica se o diretório não existe
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true); // Cria diretório com permissões adequadas
        }
    }

    /**
     * Método para salvar Pokémon no arquivo JSON
     * @param array $pokemons Array de Pokémon para salvar
     * @return bool True se salvou com sucesso, false caso contrário
     */
    public function salvarPokemons(array $pokemons): bool
    {
        try {
            // Converte Pokémon para arrays
            $dadosParaSalvar = [];
            foreach ($pokemons as $pokemon) {
                $dadosParaSalvar[] = $pokemon->toArray(); // Usa método toArray() de cada Pokémon
            }

            // Converte array para JSON com formatação
            $json = json_encode($dadosParaSalvar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            // Verifica se a conversão foi bem-sucedida
            if ($json === false) {
                return false; // Retorna false se houve erro na conversão
            }

            // Salva no arquivo
            $resultado = file_put_contents($this->arquivoDados, $json);
            
            // Retorna true se salvou com sucesso (resultado > 0)
            return $resultado !== false;
            
        } catch (Exception $e) {
            // Em caso de erro, retorna false
            return false;
        }
    }

    /**
     * Método para carregar Pokémon do arquivo JSON
     * @return array Array de Pokémon carregados
     */
    public function carregarPokemons(): array
    {
        try {
            // Verifica se o arquivo existe
            if (!file_exists($this->arquivoDados)) {
                return []; // Retorna array vazio se arquivo não existe
            }

            // Lê o conteúdo do arquivo
            $conteudo = file_get_contents($this->arquivoDados);
            
            // Verifica se conseguiu ler o arquivo
            if ($conteudo === false) {
                return []; // Retorna array vazio se não conseguiu ler
            }

            // Decodifica o JSON
            $dados = json_decode($conteudo, true);
            
            // Verifica se a decodificação foi bem-sucedida
            if ($dados === null) {
                return []; // Retorna array vazio se JSON inválido
            }

            // Converte arrays para objetos Pokémon
            $pokemons = [];
            foreach ($dados as $dadosPokemon) {
                $pokemon = $this->criarPokemonDeArray($dadosPokemon);
                if ($pokemon !== null) {
                    $pokemons[] = $pokemon; // Adiciona Pokémon válido ao array
                }
            }

            return $pokemons; // Retorna array de Pokémon
            
        } catch (Exception $e) {
            // Em caso de erro, retorna array vazio
            return [];
        }
    }

    /**
     * Método para criar um Pokémon a partir de array de dados
     * @param array $dados Dados do Pokémon
     * @return Pokemon|null Pokémon criado ou null se erro
     */
    private function criarPokemonDeArray(array $dados): ?Pokemon
    {
        try {
            // Verifica se tem a classe especificada
            if (!isset($dados['classe'])) {
                return null; // Retorna null se não tem classe
            }

            // Cria Pokémon baseado na classe
            switch ($dados['classe']) {
                case 'PokemonFogo':
                    return PokemonFogo::fromArray($dados);
                case 'PokemonAgua':
                    return PokemonAgua::fromArray($dados);
                case 'PokemonGrama':
                    return PokemonGrama::fromArray($dados);
                case 'PokemonEletrico':
                    return PokemonEletrico::fromArray($dados);
                case 'PokemonGelo':
                    return PokemonGelo::fromArray($dados);
                default:
                    return null; // Retorna null se classe desconhecida
            }
            
        } catch (Exception $e) {
            // Em caso de erro, retorna null
            return null;
        }
    }

    /**
     * Método para verificar se o arquivo de dados existe
     * @return bool True se existe, false caso contrário
     */
    public function arquivoExiste(): bool
    {
        return file_exists($this->arquivoDados);
    }

    /**
     * Método para obter o caminho do arquivo de dados
     * @return string Caminho do arquivo
     */
    public function getArquivoDados(): string
    {
        return $this->arquivoDados;
    }

    /**
     * Método para obter informações sobre o arquivo de dados
     * @return array Array com informações do arquivo
     */
    public function obterInformacoesArquivo(): array
    {
        $info = [
            'existe' => $this->arquivoExiste(),
            'caminho' => $this->arquivoDados,
            'tamanho' => 0,
            'modificado' => null
        ];

        // Se arquivo existe, obtém informações adicionais
        if ($info['existe']) {
            $info['tamanho'] = filesize($this->arquivoDados);
            $info['modificado'] = date('d/m/Y H:i:s', filemtime($this->arquivoDados));
        }

        return $info; // Retorna array com informações
    }

    /**
     * Método para fazer backup do arquivo de dados
     * @return bool True se backup foi criado, false caso contrário
     */
    public function fazerBackup(): bool
    {
        try {
            // Verifica se arquivo existe
            if (!$this->arquivoExiste()) {
                return false; // Não pode fazer backup se arquivo não existe
            }

            // Cria nome do arquivo de backup com timestamp
            $timestamp = date('Y-m-d_H-i-s');
            $arquivoBackup = dirname($this->arquivoDados) . "/backup_pokemons_{$timestamp}.json";

            // Copia arquivo para backup
            return copy($this->arquivoDados, $arquivoBackup);
            
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }

    /**
     * Método para limpar arquivo de dados (deletar)
     * @return bool True se deletou com sucesso, false caso contrário
     */
    public function limparDados(): bool
    {
        try {
            // Verifica se arquivo existe
            if (!$this->arquivoExiste()) {
                return true; // Considera sucesso se arquivo já não existe
            }

            // Deleta o arquivo
            return unlink($this->arquivoDados);
            
        } catch (Exception $e) {
            return false; // Retorna false em caso de erro
        }
    }
}
