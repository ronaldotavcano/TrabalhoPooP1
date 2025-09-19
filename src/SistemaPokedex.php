<?php

namespace Pokemon;

use Pokemon\Tipos\PokemonFogo;
use Pokemon\Tipos\PokemonAgua;
use Pokemon\Tipos\PokemonGrama;
use Pokemon\Tipos\PokemonEletrico;
use Pokemon\Tipos\PokemonGelo;

/**
 * Classe principal do sistema de Pokédex
 * Gerencia a interface CLI e coordena todas as operações
 * Aplica o princípio de abstração ao trabalhar com objetos Pokemon e Pokedex
 */
class SistemaPokedex
{
    // Propriedades privadas da classe
    private Pokedex $pokedex; // Objeto Pokedex para gerenciar Pokémon
    private bool $sistemaAtivo; // Flag para controlar se o sistema está ativo

    /**
     * Construtor da classe SistemaPokedex
     * Inicializa a Pokédex e define o sistema como ativo
     */
    public function __construct()
    {
        $this->pokedex = new Pokedex(); // Cria nova instância da Pokedex
        $this->sistemaAtivo = true; // Define sistema como ativo
    }

    /**
     * Método principal que inicia o sistema
     * Exibe boas-vindas e inicia o loop do menu
     */
    public function iniciar(): void
    {
        $this->exibirBoasVindas(); // Exibe mensagem de boas-vindas
        
        // Loop principal do sistema
        while ($this->sistemaAtivo) {
            $this->exibirMenu(); // Exibe o menu de opções
            $opcao = $this->lerOpcao(); // Lê a opção do usuário
            $this->processarOpcao($opcao); // Processa a opção escolhida
        }
        
        $this->exibirDespedida(); // Exibe mensagem de despedida
    }

    /**
     * Método para exibir mensagem de boas-vindas
     */
    private function exibirBoasVindas(): void
    {
        echo "\n";
        echo "========================================\n";
        echo "    🎮 SISTEMA DE POKÉDEX 🎮\n";
        echo "========================================\n";
        echo "Bem-vindo ao sistema de gerenciamento de Pokémon!\n";
        echo "Aqui você pode cadastrar, buscar e gerenciar seus Pokémon.\n";
        echo "========================================\n\n";
    }

    /**
     * Método para exibir o menu principal
     */
    private function exibirMenu(): void
    {
        echo "\n--- MENU PRINCIPAL ---\n";
        echo "1. Cadastrar novo Pokémon\n";
        echo "2. Buscar Pokémon por número\n";
        echo "3. Buscar Pokémon por nome\n";
        echo "4. Buscar Pokémon por tipo\n";
        echo "5. Listar todos os Pokémon\n";
        echo "6. Exibir estatísticas da Pokédex\n";
        echo "7. Cadastrar Pokémon de exemplo\n";
        echo "8. Gerenciar dados salvos\n";
        echo "0. Sair do sistema\n";
        echo "----------------------\n";
    }

    /**
     * Método para ler a opção do usuário
     * @return int Opção escolhida pelo usuário
     */
    private function lerOpcao(): int
    {
        $opcao = readline("Digite sua opção: "); // Lê entrada do usuário
        return (int) $opcao; // Converte para inteiro (type casting)
    }

    /**
     * Método para processar a opção escolhida pelo usuário
     * @param int $opcao Opção escolhida
     */
    private function processarOpcao(int $opcao): void
    {
        switch ($opcao) {
            case 1:
                $this->cadastrarPokemon(); // Chama método para cadastrar Pokémon
                break;
            case 2:
                $this->buscarPorNumero(); // Chama método para buscar por número
                break;
            case 3:
                $this->buscarPorNome(); // Chama método para buscar por nome
                break;
            case 4:
                $this->buscarPorTipo(); // Chama método para buscar por tipo
                break;
            case 5:
                $this->listarTodos(); // Chama método para listar todos
                break;
            case 6:
                $this->exibirEstatisticas(); // Chama método para exibir estatísticas
                break;
            case 7:
                $this->cadastrarPokemonExemplo(); // Chama método para cadastrar exemplos
                break;
            case 8:
                $this->gerenciarDadosSalvos(); // Chama método para gerenciar dados
                break;
            case 0:
                $this->sairDoSistema(); // Chama método para sair
                break;
            default:
                echo "❌ Opção inválida! Tente novamente.\n"; // Mensagem de erro
        }
    }

    /**
     * Método para cadastrar um novo Pokémon
     */
    private function cadastrarPokemon(): void
    {
        echo "\n--- CADASTRAR NOVO POKÉMON ---\n";
        
        // Lê dados do Pokémon
        $nome = readline("Nome do Pokémon: ");
        $descricao = readline("Descrição: ");
        $numero = (int) readline("Número na Pokédex: "); // Type casting para inteiro
        $altura = (float) readline("Altura (metros): "); // Type casting para float
        $peso = (float) readline("Peso (kg): "); // Type casting para float
        
        // Menu para escolher o tipo
        echo "\nTipos disponíveis:\n";
        echo "1. Fogo\n";
        echo "2. Água\n";
        echo "3. Grama\n";
        echo "4. Elétrico\n";
        echo "5. Gelo\n";
        
        $tipoOpcao = (int) readline("Escolha o tipo (1-5): "); // Type casting para inteiro
        
        // Cria Pokémon baseado no tipo escolhido
        $pokemon = $this->criarPokemonPorTipo($tipoOpcao, $nome, $descricao, $numero, $altura, $peso);
        
        if ($pokemon === null) {
            echo "❌ Tipo inválido!\n";
            return;
        }
        
        // Tenta adicionar à Pokédex
        if ($this->pokedex->adicionarPokemon($pokemon)) {
            echo "✅ Pokémon cadastrado com sucesso!\n";
        } else {
            echo "❌ Erro: Já existe um Pokémon com este número!\n";
        }
    }

    /**
     * Método para criar Pokémon baseado no tipo escolhido
     * @param int $tipoOpcao Opção do tipo
     * @param string $nome Nome do Pokémon
     * @param string $descricao Descrição do Pokémon
     * @param int $numero Número na Pokédex
     * @param float $altura Altura em metros
     * @param float $peso Peso em quilogramas
     * @return Pokemon|null Pokémon criado ou null se tipo inválido
     */
    private function criarPokemonPorTipo(int $tipoOpcao, string $nome, string $descricao, int $numero, float $altura, float $peso): ?Pokemon
    {
        // Pergunta se quer tipo secundário
        $temTipoSecundario = readline("Deseja adicionar um tipo secundário? (s/n): ");
        $tipoSecundario = null;
        
        if (strtolower($temTipoSecundario) === 's') {
            $tipoSecundario = $this->escolherTipoSecundario();
        }

        switch ($tipoOpcao) {
            case 1: // Fogo
                return new PokemonFogo($nome, $descricao, $numero, $altura, $peso, $tipoSecundario);
            case 2: // Água
                return new PokemonAgua($nome, $descricao, $numero, $altura, $peso, $tipoSecundario);
            case 3: // Grama
                return new PokemonGrama($nome, $descricao, $numero, $altura, $peso, $tipoSecundario);
            case 4: // Elétrico
                return new PokemonEletrico($nome, $descricao, $numero, $altura, $peso, $tipoSecundario);
            case 5: // Gelo
                return new PokemonGelo($nome, $descricao, $numero, $altura, $peso, $tipoSecundario);
            default:
                return null; // Tipo inválido
        }
    }

    /**
     * Método para escolher tipo secundário
     * @return Tipo|null Tipo secundário escolhido ou null
     */
    private function escolherTipoSecundario(): ?Tipo
    {
        echo "\nTipos disponíveis para tipo secundário:\n";
        echo "1. Fogo\n";
        echo "2. Água\n";
        echo "3. Grama\n";
        echo "4. Elétrico\n";
        echo "5. Gelo\n";
        
        $tipoOpcao = (int) readline("Escolha o tipo secundário (1-5): ");
        
        switch ($tipoOpcao) {
            case 1: // Fogo
                return new Tipo("Fogo", "Vermelho", ["Água", "Terra"], ["Grama", "Gelo", "Aço"]);
            case 2: // Água
                return new Tipo("Água", "Azul", ["Grama", "Elétrico"], ["Fogo", "Terra", "Pedra"]);
            case 3: // Grama
                return new Tipo("Grama", "Verde", ["Fogo", "Gelo", "Venenoso", "Voador", "Inseto"], ["Água", "Terra", "Pedra", "Elétrico"]);
            case 4: // Elétrico
                return new Tipo("Elétrico", "Amarelo", ["Terra"], ["Voador", "Água", "Aço"]);
            case 5: // Gelo
                return new Tipo("Gelo", "Azul Claro", ["Fogo", "Lutador", "Pedra", "Aço"], ["Grama", "Terra", "Voador", "Dragão"]);
            default:
                return null; // Tipo inválido
        }
    }

    /**
     * Método para buscar Pokémon por número
     */
    private function buscarPorNumero(): void
    {
        echo "\n--- BUSCAR POR NÚMERO ---\n";
        $numero = (int) readline("Digite o número do Pokémon: "); // Type casting para inteiro
        
        $pokemon = $this->pokedex->buscarPorNumero($numero);
        
        if ($pokemon !== null) {
            echo "\n" . $pokemon->exibirInformacoes() . "\n";
        } else {
            echo "❌ Pokémon não encontrado!\n";
        }
    }

    /**
     * Método para buscar Pokémon por nome
     */
    private function buscarPorNome(): void
    {
        echo "\n--- BUSCAR POR NOME ---\n";
        $nome = readline("Digite o nome do Pokémon: ");
        
        $pokemons = $this->pokedex->buscarPorNome($nome);
        
        if (!empty($pokemons)) {
            echo "\nPokémon encontrados:\n";
            foreach ($pokemons as $pokemon) {
                echo "- " . $pokemon->exibirResumo() . "\n";
            }
        } else {
            echo "❌ Nenhum Pokémon encontrado!\n";
        }
    }

    /**
     * Método para buscar Pokémon por tipo
     */
    private function buscarPorTipo(): void
    {
        echo "\n--- BUSCAR POR TIPO ---\n";
        echo "Tipos disponíveis: Fogo, Água, Grama, Elétrico, Gelo\n";
        $tipo = readline("Digite o tipo: ");
        
        $pokemons = $this->pokedex->buscarPorTipo($tipo);
        
        if (!empty($pokemons)) {
            echo "\nPokémon do tipo {$tipo}:\n";
            foreach ($pokemons as $pokemon) {
                echo "- " . $pokemon->exibirResumo() . "\n";
            }
        } else {
            echo "❌ Nenhum Pokémon do tipo {$tipo} encontrado!\n";
        }
    }

    /**
     * Método para listar todos os Pokémon
     */
    private function listarTodos(): void
    {
        echo "\n--- TODOS OS POKÉMON ---\n";
        
        if ($this->pokedex->estaVazia()) {
            echo "A Pokédex está vazia!\n";
            return;
        }
        
        $pokemons = $this->pokedex->listarTodos();
        
        foreach ($pokemons as $pokemon) {
            echo $pokemon->exibirResumo() . "\n";
        }
    }

    /**
     * Método para exibir estatísticas da Pokédex
     */
    private function exibirEstatisticas(): void
    {
        echo "\n" . $this->pokedex->exibirRelatorio() . "\n";
    }

    /**
     * Método para cadastrar Pokémon de exemplo
     */
    private function cadastrarPokemonExemplo(): void
    {
        echo "\n--- CADASTRANDO POKÉMON DE EXEMPLO ---\n";
        
        // Cria Pokémon de exemplo para cada tipo (alguns com tipos duplos)
        $exemplos = [
            new PokemonFogo("Charmander", "Um Pokémon de fogo com chama na cauda", 4, 0.6, 8.5),
            new PokemonAgua("Squirtle", "Um Pokémon de água com casco resistente", 7, 0.5, 9.0),
            new PokemonGrama("Bulbasaur", "Um Pokémon de grama com semente nas costas", 1, 0.7, 6.9),
            new PokemonEletrico("Pikachu", "Um Pokémon elétrico amarelo e fofo", 25, 0.4, 6.0),
            new PokemonGelo("Jynx", "Um Pokémon de gelo com poderes psíquicos", 124, 1.4, 40.6),
            // Exemplos com tipos duplos
            new PokemonFogo("Charizard", "Um dragão de fogo voador", 6, 1.7, 90.5, new Tipo("Voador", "Azul", ["Elétrico", "Gelo", "Pedra"], ["Grama", "Lutador", "Inseto"])),
            new PokemonAgua("Blastoise", "Uma tartaruga de água com canhões", 9, 1.6, 85.5, new Tipo("Aço", "Cinza", ["Fogo", "Lutador", "Terra"], ["Grama", "Gelo", "Voador", "Psíquico", "Inseto", "Pedra", "Dragão", "Aço", "Fada"]))
        ];
        
        $cadastrados = 0;
        foreach ($exemplos as $pokemon) {
            if ($this->pokedex->adicionarPokemon($pokemon)) {
                $cadastrados++;
            }
        }
        
        echo "✅ {$cadastrados} Pokémon de exemplo cadastrados com sucesso!\n";
    }

    /**
     * Método para sair do sistema
     */
    private function sairDoSistema(): void
    {
        $this->sistemaAtivo = false; // Define sistema como inativo
    }

    /**
     * Método para gerenciar dados salvos
     */
    private function gerenciarDadosSalvos(): void
    {
        echo "\n--- GERENCIAR DADOS SALVOS ---\n";
        echo "1. Exibir informações do arquivo\n";
        echo "2. Fazer backup dos dados\n";
        echo "3. Recarregar dados do arquivo\n";
        echo "4. Limpar todos os dados\n";
        echo "0. Voltar ao menu principal\n";
        echo "-----------------------------\n";
        
        $opcao = (int) readline("Escolha uma opção: ");
        
        switch ($opcao) {
            case 1:
                $this->exibirInformacoesArquivo();
                break;
            case 2:
                $this->fazerBackup();
                break;
            case 3:
                $this->recarregarDados();
                break;
            case 4:
                $this->limparDados();
                break;
            case 0:
                return; // Volta ao menu principal
            default:
                echo "❌ Opção inválida!\n";
        }
    }

    /**
     * Método para exibir informações do arquivo de dados
     */
    private function exibirInformacoesArquivo(): void
    {
        $info = $this->pokedex->obterInformacoesArquivo();
        
        echo "\n--- INFORMAÇÕES DO ARQUIVO ---\n";
        echo "Arquivo existe: " . ($info['existe'] ? 'Sim' : 'Não') . "\n";
        echo "Caminho: {$info['caminho']}\n";
        
        if ($info['existe']) {
            echo "Tamanho: " . number_format($info['tamanho'] / 1024, 2) . " KB\n";
            echo "Última modificação: {$info['modificado']}\n";
        }
        echo "-----------------------------\n";
    }

    /**
     * Método para fazer backup dos dados
     */
    private function fazerBackup(): void
    {
        if ($this->pokedex->fazerBackup()) {
            echo "✅ Backup criado com sucesso!\n";
        } else {
            echo "❌ Erro ao criar backup!\n";
        }
    }

    /**
     * Método para recarregar dados do arquivo
     */
    private function recarregarDados(): void
    {
        if ($this->pokedex->carregarDados()) {
            echo "✅ Dados recarregados com sucesso!\n";
        } else {
            echo "❌ Erro ao recarregar dados!\n";
        }
    }

    /**
     * Método para limpar todos os dados
     */
    private function limparDados(): void
    {
        echo "⚠️  ATENÇÃO: Esta ação irá deletar TODOS os dados salvos!\n";
        $confirmacao = readline("Digite 'CONFIRMAR' para continuar: ");
        
        if ($confirmacao === 'CONFIRMAR') {
            if ($this->pokedex->limparTodosDados()) {
                echo "✅ Todos os dados foram removidos!\n";
            } else {
                echo "❌ Erro ao limpar dados!\n";
            }
        } else {
            echo "❌ Operação cancelada.\n";
        }
    }

    /**
     * Método para exibir mensagem de despedida
     */
    private function exibirDespedida(): void
    {
        echo "\n========================================\n";
        echo "    👋 OBRIGADO POR USAR A POKÉDEX! 👋\n";
        echo "========================================\n";
        echo "Até a próxima, Treinador Pokémon!\n";
        echo "========================================\n\n";
    }
}
