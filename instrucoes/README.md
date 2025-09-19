# 🎮 Sistema de Pokédex - Manual de Instruções

## 📋 Sobre o Projeto

Este é um sistema de gerenciamento de Pokémon desenvolvido em PHP puro, utilizando orientação a objetos com foco nos princípios de **abstração** e **herança**. O sistema é uma aplicação CLI (Command-Line Interface) que permite cadastrar, buscar e gerenciar Pokémon de diferentes tipos.

## 🚀 Como Executar o Projeto

### Pré-requisitos
- PHP 7.4 ou superior
- Composer instalado

### Passos para Execução

1. **Instalar dependências do Composer:**
   ```bash
   composer install
   ```

2. **Executar o sistema:**
   ```bash
   php index.php
   ```
   
   Ou usando o script do Composer:
   ```bash
   composer start
   ```

3. **Seguir o menu interativo** que aparecerá no terminal

## 🎯 Funcionalidades do Sistema

### Menu Principal
- **1.** Cadastrar novo Pokémon
- **2.** Buscar Pokémon por número
- **3.** Buscar Pokémon por nome
- **4.** Buscar Pokémon por tipo
- **5.** Listar todos os Pokémon
- **6.** Exibir estatísticas da Pokédex
- **7.** Cadastrar Pokémon de exemplo
- **8.** Gerenciar dados salvos
- **0.** Sair do sistema

### Menu de Gerenciamento de Dados
- **1.** Exibir informações do arquivo
- **2.** Fazer backup dos dados
- **3.** Recarregar dados do arquivo
- **4.** Limpar todos os dados
- **0.** Voltar ao menu principal

### Tipos de Pokémon Suportados
- 🔥 **Fogo** - Tipo primário de fogo
- 💧 **Água** - Tipo primário de água
- 🌱 **Grama** - Tipo primário de grama
- ⚡ **Elétrico** - Tipo primário elétrico
- ❄️ **Gelo** - Tipo primário de gelo

### Sistema de Tipos Duplos
- **Tipos Primários**: Cada Pokémon tem um tipo principal
- **Tipos Secundários**: Pokémon podem ter um tipo secundário adicional
- **Combinações**: Permite criar Pokémon com combinações como Fogo/Voador, Água/Aço, etc.
- **Busca Inteligente**: Busca por tipo encontra Pokémon com o tipo em qualquer posição

## 💾 Sistema de Persistência

### Salvamento Automático
- **Todos os Pokémon são salvos automaticamente** quando cadastrados
- **Dados são carregados automaticamente** ao iniciar o sistema
- **Arquivo JSON** em `data/pokemons.json` para armazenamento

### Funcionalidades de Persistência
- **Backup automático** com timestamp
- **Recarregamento** de dados do arquivo
- **Informações do arquivo** (tamanho, data de modificação)
- **Limpeza segura** com confirmação

### Vantagens
- **Não perde dados** ao fechar o sistema
- **Backup automático** para segurança
- **Formato JSON** legível e portável
- **Gerenciamento completo** via interface

## 📚 Conceitos de Programação Utilizados

### Princípios de Orientação a Objetos

#### 1. **Abstração**
- Classe abstrata `Pokemon` define características comuns
- Métodos abstratos `emitirSom()` e `usarHabilidadeEspecial()`
- Interface comum para todos os tipos de Pokémon

#### 2. **Herança**
- Classes específicas herdam de `Pokemon`:
  - `PokemonFogo extends Pokemon`
  - `PokemonAgua extends Pokemon`
  - `PokemonGrama extends Pokemon`
  - `PokemonEletrico extends Pokemon`
  - `PokemonGelo extends Pokemon`

### Estruturas de Dados

#### **Arrays**
- `$pokemons` - Array principal da Pokédex
- `$habilidades` - Array de habilidades de cada Pokémon
- `$fraquezas` e `$resistencia` - Arrays de tipos no objeto Tipo

#### **Type Casting**
- `(int) readline()` - Converte entrada para inteiro
- `(float) readline()` - Converte entrada para float
- `(string) $variavel` - Converte para string

### Funções Específicas

#### **readline()**
- Função para capturar entrada do usuário via teclado
- Usada em todos os inputs do sistema
- Exemplo: `$nome = readline("Digite o nome: ");`

## 🏗️ Arquitetura do Sistema

### Classes Principais

1. **`Tipo`** - Representa um tipo de Pokémon
2. **`Pokemon`** - Classe abstrata base
3. **`Pokedex`** - Gerencia coleção de Pokémon
4. **`SistemaPokedex`** - Interface CLI principal
5. **Classes Específicas** - 5 tipos de Pokémon

### Fluxo de Execução

```
index.php → SistemaPokedex → Pokedex → Pokemon (e subclasses)
```

## 💡 Exemplos de Uso

### Cadastrando um Pokémon de Fogo
```
Nome do Pokémon: Charmander
Descrição: Um Pokémon de fogo com chama na cauda
Número na Pokédex: 4
Altura (metros): 0.6
Peso (kg): 8.5
Temperatura corporal (°C): 120
```

### Buscando Pokémon
- Por número: Digite `4` para encontrar Charmander
- Por nome: Digite `Char` para encontrar Pokémon com "Char" no nome
- Por tipo: Digite `Fogo` para listar todos os Pokémon de fogo

## 🔧 Estrutura de Arquivos

```
ProjetoPoo/
├── composer.json          # Configuração do Composer
├── index.php             # Arquivo principal
├── data/                 # Dados salvos (criado automaticamente)
│   └── pokemons.json     # Arquivo de persistência dos Pokémon
├── src/                  # Código fonte
│   ├── Tipo.php          # Classe Tipo
│   ├── Pokemon.php       # Classe abstrata Pokemon
│   ├── Pokedex.php       # Classe Pokedex
│   ├── SistemaPokedex.php # Sistema principal CLI
│   ├── PersistenciaPokemon.php # Sistema de persistência
│   └── tipos/            # Classes de tipos específicos
│       ├── PokemonFogo.php   # Pokémon de fogo
│       ├── PokemonAgua.php   # Pokémon de água
│       ├── PokemonGrama.php  # Pokémon de grama
│       ├── PokemonEletrico.php # Pokémon elétrico
│       └── PokemonGelo.php   # Pokémon de gelo
└── instrucoes/           # Documentação
    └── README.md         # Este arquivo
```

## 🎓 Conceitos Educacionais

### Para Estudantes de Programação

Este projeto demonstra:
- **Encapsulamento** - Propriedades privadas/protegidas
- **Polimorfismo** - Métodos com comportamentos diferentes
- **Composição** - Pokemon contém Tipo
- **Interface CLI** - Interação via terminal
- **Tratamento de Dados** - Type casting e validação
- **Estruturas de Dados** - Arrays associativos e indexados

### Padrões de Código
- **PSR-4** - Autoloading de classes
- **Composer** - Gerenciamento de dependências
- **Documentação** - Comentários em português
- **Nomenclatura** - Variáveis e métodos em português

## 🐛 Solução de Problemas

### Erro: "Class not found"
```bash
composer install
```

### Erro: "readline not available"
- Instale extensão readline do PHP
- No Windows: descomente `extension=readline` no php.ini

### Erro de permissão
```bash
chmod +x index.php
```

## 📞 Suporte

Este projeto foi desenvolvido como trabalho acadêmico para demonstrar conceitos de Programação Orientada a Objetos em PHP.

**Desenvolvido com ❤️ para estudantes de Ciência da Computação**
