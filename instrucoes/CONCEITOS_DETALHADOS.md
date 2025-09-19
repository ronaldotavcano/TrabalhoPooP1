# 📚 Conceitos Detalhados - Sistema de Pokédex

## 🎯 Visão Geral dos Conceitos

Este documento explica detalhadamente todos os conceitos de programação utilizados no sistema de Pokédex, organizados por categoria e com exemplos práticos do código.

## 🏗️ Conceitos de Orientação a Objetos

### 1. **Abstração (Abstraction)**

A abstração é o princípio que permite definir características comuns sem implementar detalhes específicos.

#### Exemplo no Código:
```php
// Classe abstrata Pokemon
abstract class Pokemon
{
    // Propriedades comuns a todos os Pokémon
    protected string $nome;
    protected Tipo $tipo;
    
    // Método abstrato - deve ser implementado pelas subclasses
    abstract public function emitirSom(): string;
    abstract public function usarHabilidadeEspecial(): string;
}
```

**Por que usar abstração?**
- Define um contrato comum para todas as subclasses
- Garante que métodos importantes sejam implementados
- Evita instanciação direta da classe base

### 2. **Herança (Inheritance)**

A herança permite que uma classe herde características de outra classe.

#### Exemplo no Código:
```php
// Classe filha herda da classe pai
class PokemonFogo extends Pokemon
{
    // Propriedade específica da classe filha
    private int $temperaturaCorporal;
    
    // Implementa método abstrato da classe pai
    public function emitirSom(): string
    {
        return "🔥 {$this->nome} faz um rugido flamejante!";
    }
}
```

**Benefícios da herança:**
- Reutilização de código
- Extensão de funcionalidades
- Polimorfismo

### 3. **Encapsulamento (Encapsulation)**

O encapsulamento controla o acesso às propriedades e métodos.

#### Exemplo no Código:
```php
class Tipo
{
    // Propriedades privadas - só acessíveis dentro da classe
    private string $nome;
    private string $cor;
    
    // Métodos públicos - acessíveis de qualquer lugar
    public function getNome(): string
    {
        return $this->nome;
    }
    
    // Métodos protegidos - acessíveis pela classe e subclasses
    protected function validarTipo(): bool
    {
        return !empty($this->nome);
    }
}
```

**Níveis de acesso:**
- `private` - Só dentro da própria classe
- `protected` - Dentro da classe e subclasses
- `public` - Em qualquer lugar

### 4. **Polimorfismo (Polymorphism)**

O polimorfismo permite que objetos de diferentes classes sejam tratados de forma uniforme.

#### Exemplo no Código:
```php
// Array de Pokémon de tipos diferentes
$pokemons = [
    new PokemonFogo("Charmander", ...),
    new PokemonAgua("Squirtle", ...),
    new PokemonGrama("Bulbasaur", ...)
];

// Todos respondem ao mesmo método, mas com comportamentos diferentes
foreach ($pokemons as $pokemon) {
    echo $pokemon->emitirSom(); // Cada um emite som diferente
}
```

## 📊 Estruturas de Dados

### 1. **Arrays**

Arrays são estruturas fundamentais para armazenar múltiplos valores.

#### Array Indexado:
```php
// Array com índices numéricos
$habilidades = ["Lança-chamas", "Jato d'água", "Chicote de vinha"];
echo $habilidades[0]; // "Lança-chamas"
```

#### Array Associativo:
```php
// Array com chaves personalizadas
$pokemons = [
    4 => $charmander,    // Chave: número da Pokédex
    7 => $squirtle,      // Valor: objeto Pokémon
    1 => $bulbasaur
];
```

#### Array Multidimensional:
```php
// Array dentro de array
$estatisticas = [
    'total' => 5,
    'por_tipo' => [
        'Fogo' => 2,
        'Água' => 1,
        'Grama' => 1
    ]
];
```

### 2. **Manipulação de Arrays**

#### Adicionar elementos:
```php
$this->pokemons[$numero] = $pokemon; // Adiciona com chave específica
$this->habilidades[] = $habilidade;  // Adiciona no final
```

#### Buscar em arrays:
```php
// Verifica se existe
if (isset($this->pokemons[$numero])) {
    return $this->pokemons[$numero];
}

// Busca por valor
$resultado = array_filter($this->pokemons, function($pokemon) {
    return $pokemon->getTipo()->getNome() === 'Fogo';
});
```

## 🔄 Type Casting (Conversão de Tipos)

Type casting converte um valor de um tipo para outro.

### Exemplos no Código:

#### Conversão para Inteiro:
```php
$numero = (int) readline("Digite o número: ");
// Se usuário digitar "123", vira inteiro 123
// Se digitar "abc", vira 0
```

#### Conversão para Float:
```php
$altura = (float) readline("Digite a altura: ");
// Se usuário digitar "1.5", vira float 1.5
// Se digitar "1,5", vira 1.0 (vírgula não é reconhecida)
```

#### Conversão para String:
```php
$nome = (string) $variavel;
// Converte qualquer tipo para string
```

### Por que usar Type Casting?
- **Segurança**: Garante que dados estejam no tipo correto
- **Validação**: Evita erros de tipo
- **Consistência**: Mantém tipos uniformes

## ⌨️ Função readline()

A função `readline()` captura entrada do usuário via teclado.

### Sintaxe:
```php
$entrada = readline("Prompt para o usuário: ");
```

### Exemplos no Código:
```php
// Captura nome
$nome = readline("Nome do Pokémon: ");

// Captura número com type casting
$numero = (int) readline("Número na Pokédex: ");

// Captura float com type casting
$altura = (float) readline("Altura (metros): ");
```

### Características:
- **Síncrona**: Aguarda entrada do usuário
- **String**: Sempre retorna string
- **Interativa**: Permite interação em tempo real

## 🎮 Interface CLI (Command-Line Interface)

### Estrutura do Menu:
```php
private function exibirMenu(): void
{
    echo "\n--- MENU PRINCIPAL ---\n";
    echo "1. Cadastrar novo Pokémon\n";
    echo "2. Buscar Pokémon por número\n";
    // ... mais opções
}
```

### Loop Principal:
```php
while ($this->sistemaAtivo) {
    $this->exibirMenu();           // Mostra opções
    $opcao = $this->lerOpcao();    // Lê escolha
    $this->processarOpcao($opcao); // Executa ação
}
```

### Vantagens do CLI:
- **Simplicidade**: Interface simples e direta
- **Performance**: Menos recursos que interface gráfica
- **Automação**: Pode ser executado via scripts
- **Acessibilidade**: Funciona em qualquer terminal

## 🔧 Composer e Autoloading

### composer.json:
```json
{
    "autoload": {
        "psr-4": {
            "Pokemon\\": "src/"
        }
    }
}
```

### Autoloading:
```php
// No index.php
require_once 'vendor/autoload.php';

// Agora pode usar classes sem require manual
use Pokemon\SistemaPokedex;
$sistema = new SistemaPokedex();
```

### Benefícios:
- **Organização**: Classes organizadas em namespaces
- **Automação**: Carregamento automático de classes
- **Padrão**: Segue padrão PSR-4 da comunidade PHP

## 🎯 Padrões de Código

### 1. **Nomenclatura em Português**
```php
// Variáveis e métodos em português
private string $nomePokemon;
public function cadastrarPokemon(): void
```

### 2. **Documentação com Comentários**
```php
/**
 * Método para adicionar um Pokémon à Pokédex
 * @param Pokemon $pokemon Objeto Pokémon a ser adicionado
 * @return bool True se adicionado com sucesso
 */
public function adicionarPokemon(Pokemon $pokemon): bool
```

### 3. **Tratamento de Erros**
```php
try {
    $sistema = new SistemaPokedex();
    $sistema->iniciar();
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
```

## 🧮 Exemplos Práticos

### Exemplo 1: Cadastro de Pokémon
```php
// 1. Captura dados do usuário
$nome = readline("Nome: ");
$numero = (int) readline("Número: ");

// 2. Cria objeto Pokémon
$pokemon = new PokemonFogo($nome, $descricao, $numero, ...);

// 3. Adiciona à Pokédex
$pokedex->adicionarPokemon($pokemon);
```

### Exemplo 2: Busca por Tipo
```php
// 1. Captura tipo
$tipo = readline("Digite o tipo: ");

// 2. Busca Pokémon do tipo
$pokemons = $pokedex->buscarPorTipo($tipo);

// 3. Exibe resultados
foreach ($pokemons as $pokemon) {
    echo $pokemon->exibirResumo() . "\n";
}
```

### Exemplo 3: Estatísticas
```php
// 1. Obtém estatísticas
$stats = $pokedex->obterEstatisticas();

// 2. Exibe informações
echo "Total: {$stats['total']}\n";
foreach ($stats['por_tipo'] as $tipo => $quantidade) {
    echo "{$tipo}: {$quantidade}\n";
}
```

## 🎓 Conceitos Educacionais

### Para Estudantes:

1. **Pensamento Orientado a Objetos**: Como modelar o mundo real
2. **Reutilização de Código**: Evitar duplicação
3. **Manutenibilidade**: Código fácil de modificar
4. **Escalabilidade**: Fácil adicionar novos tipos
5. **Testabilidade**: Código organizado é mais fácil de testar

### Boas Práticas Demonstradas:

- ✅ Comentários em português
- ✅ Nomes descritivos
- ✅ Métodos pequenos e focados
- ✅ Separação de responsabilidades
- ✅ Tratamento de erros
- ✅ Documentação clara

## 🔍 Análise de Complexidade

### Classes por Responsabilidade:
- **Tipo**: Gerencia informações de tipo
- **Pokemon**: Define estrutura base
- **Pokedex**: Gerencia coleção
- **SistemaPokedex**: Interface do usuário
- **Classes Específicas**: Implementam comportamentos únicos

### Métodos por Funcionalidade:
- **Getters/Setters**: Acesso controlado
- **Métodos de Negócio**: Lógica específica
- **Métodos de Interface**: Interação com usuário
- **Métodos Utilitários**: Funções auxiliares

Este sistema demonstra como aplicar conceitos fundamentais de programação orientada a objetos de forma prática e educativa!
