# Documentação Completa do Projeto - Prova 2 de POO

## Índice
1. [Visão Geral](#visão-geral)
2. [Estrutura do Projeto](#estrutura-do-projeto)
3. [Classes e Encapsulamento](#classes-e-encapsulamento)
4. [Aplicações dos 4 Pilares da POO](#aplicações-dos-4-pilares-da-poo)
5. [Melhorias Implementadas](#melhorias-implementadas)
6. [Funções Nativas do PHP Utilizadas](#funções-nativas-do-php-utilizadas)

---

## Visão Geral

Este projeto implementa um sistema de gerenciamento de Pokédex em PHP, aplicando os quatro pilares da Programação Orientada a Objetos (POO): **Abstração**, **Herança**, **Encapsulamento** e **Polimorfismo**. O sistema permite cadastrar, buscar, editar e excluir Pokémon e Treinadores, com persistência em arquivos JSON.

---

## Estrutura do Projeto

```
ProjetoPoo/
├── src/
│   ├── Pokemon.php                    # Classe abstrata base
│   ├── Tipo.php                       # Classe para tipos de Pokémon
│   ├── Pokedex.php                    # Gerenciador de coleção de Pokémon
│   ├── Treinador.php                  # Classe para treinadores
│   ├── GerenciadorTreinadores.php    # Gerenciador de treinadores
│   ├── SalvamentoDeDados.php         # Camada de persistência
│   ├── SistemaPokedex.php            # Interface CLI principal
│   └── tipos/                         # 15 subclasses de Pokémon
├── data/
│   ├── pokemons.json                  # Dados persistidos de Pokémon
│   └── treinadores.json               # Dados persistidos de Treinadores
└── index.php                          # Ponto de entrada
```

---

## Classes e Encapsulamento

### 1. Classe `Pokemon` (Abstrata)

**Encapsulamento:**
- **`protected`** (`$name`, `$primaryType`, `$secondaryType`, `$description`, `$number`, `$height`, `$weight`): 
  - **Por quê `protected`?** Permite que subclasses acessem diretamente os atributos sem expor para classes externas. Isso mantém o controle sobre o estado interno enquanto permite especialização nas subclasses.
  
- **`public` getters** (`getName()`, `getNumber()`, `getPrimaryType()`, `getSecondaryType()`, `getHeight()`, `getWeight()`, `getDescription()`):
  - **Por quê `public`?** Fornecem acesso controlado de leitura ao estado. Se futuramente precisarmos adicionar validação ou formatação, fazemos internamente sem quebrar código cliente.

- **`public` métodos de interface** (`showInfos()`, `showSummary()`, `pokemonToArray()`):
  - **Por quê `public`?** Representam a interface estável que o mundo externo deve usar. Detalhes de formatação e serialização ficam encapsulados dentro da classe.

**Exemplo de uso:**
```php
$pokemon = new PokemonFogo("Charmander", "Um Pokémon de fogo", 4, 0.6, 8.5);
echo $pokemon->getName(); // ✅ Acesso via getter público
// $pokemon->name; // ❌ Erro! Atributo protegido não acessível externamente
```

---

### 2. Classe `Tipo`

**Encapsulamento:**
- **`private`** (`$name`, `$weakeness`, `$resistance`):
  - **Por quê `private`?** Previne alteração direta de dados sensíveis (fraquezas e resistências). Garante que apenas a própria classe pode modificar esses valores, mantendo consistência.

- **`public` getters e verificadores** (`getName()`, `getWeakness()`, `getResistance()`, `isWeakAgainst()`, `isResistanceAgainst()`):
  - **Por quê `public`?** Fornecem informações necessárias e operações de domínio sem expor a estrutura interna dos arrays.

**Exemplo:**
```php
$tipo = new Tipo("Fogo", ["Água"], ["Planta"]);
$tipo->isWeakAgainst("Água"); // ✅ true - método público
// $tipo->weakeness = []; // ❌ Erro! Atributo privado
```

---

### 3. Classe `Pokedex`

**Encapsulamento:**
- **`private`** (`$pokemons`, `$totalPokemons`, `$persistencia`):
  - **Por quê `private`?** Impede manipulação direta da coleção, contador e camada de IO. Isso evita estados inválidos (ex.: duplicatas, contador desincronizado, desserialização parcial).

- **`public` API** (`addPokemon()`, `searchByNumber()`, `searchByName()`, `listAll()`, `isEmpty()`, `getTotalPokemons()`, `getStatistics()`, `showRecord()`, `loadData()`, `saveData()`, `hasDataSaved()`):
  - **Por quê `public`?** Define o contrato de uso da coleção. Regras de negócio (ex.: evitar duplicar número) vivem aqui, não espalhadas pelo código.

**Exemplo:**
```php
$pokedex = new Pokedex();
$pokedex->addPokemon($pokemon); // ✅ Método público controlado
// $pokedex->pokemons[] = $pokemon; // ❌ Erro! Atributo privado
```

**Melhoria com função nativa:**
```php
// ANTES (linha 57):
public function isEmpty(): bool{
    return empty($this->pokemons); // ✅ Usa função nativa empty()
}

// ANTES (linha 35-45):
public function searchByName(string $name): array{
    $result = [];
    foreach ($this->pokemons as $pokemon) {
        if (stripos($pokemon->getName(), $name) !== false) {
            $result[] = $pokemon;
        }
    }
    return $result;
}
// ✅ Usa stripos() nativa para busca case-insensitive
```

---

### 4. Classe `Treinador`

**Encapsulamento:**
- **`private`** (`$nome`, `$idade`, `$pokemons`):
  - **Por quê `private`?** Protege dados pessoais e a coleção de Pokémon. Impede alteração direta que poderia quebrar invariantes (ex.: idade negativa).

- **`public` getters e setters** (`getNome()`, `getIdade()`, `getPokemons()`, `setNome()`, `setIdade()`):
  - **Por quê `public`?** Permitem acesso controlado com possibilidade de validação futura nos setters.

- **`public` métodos de gerenciamento** (`adicionarPokemon()`, `removerPokemon()`, `buscarPokemon()`, `getTotalPokemons()`):
  - **Por quê `public`?** Interface para manipular a coleção de Pokémon do treinador de forma segura.

**Exemplo:**
```php
$treinador = new Treinador("Ash", 10);
$treinador->adicionarPokemon($pokemon); // ✅ Método público
// $treinador->pokemons[] = $pokemon; // ❌ Erro! Atributo privado
```

**Melhoria com função nativa:**
```php
// Linha 50-52:
public function removerPokemon(int $numero): bool{
    foreach ($this->pokemons as $key => $pokemon) {
        if ($pokemon->getNumber() === $numero) {
            unset($this->pokemons[$key]);
            $this->pokemons = array_values($this->pokemons); // ✅ array_values() reindexa
            return true;
        }
    }
    return false;
}
```

---

### 5. Classe `GerenciadorTreinadores`

**Encapsulamento:**
- **`private`** (`$treinadores`, `$persistencia`, `$pokedex`):
  - **Por quê `private`?** Mantém a coleção e dependências internas. Evita acesso direto que poderia causar inconsistências.

- **`public` métodos CRUD** (`adicionarTreinador()`, `buscarTreinador()`, `removerTreinador()`, `atualizarTreinador()`, `listarTodos()`):
  - **Por quê `public`?** Interface completa para operações CRUD, garantindo que todas as alterações passem por validação e persistência.

- **`private` métodos de persistência** (`salvarTreinadores()`, `loadTrainers()`):
  - **Por quê `private`?** Detalhes de IO não devem ser expostos. A persistência acontece automaticamente após operações públicas.

**Melhoria com função nativa:**
```php
// Linha 30:
public function buscarTreinador(string $nome): ?Treinador{
    foreach ($this->treinadores as $treinador) {
        if (stripos($treinador->getNome(), $nome) !== false) { // ✅ stripos() nativa
            return $treinador;
        }
    }
    return null;
}

// Linha 50:
public function getTotalTreinadores(): int{
    return count($this->treinadores); // ✅ count() nativa
}
```

---

### 6. Classe `SalvamentoDeDados`

**Encapsulamento:**
- **`private`** (`$dataFiles`):
  - **Por quê `private`?** Caminho do arquivo é detalhe interno. Evita que outras classes alterem a fonte de dados sem passar por validações.

- **`private`** (`creatDirectoryIfNecessary()`):
  - **Por quê `private`?** Operação interna de setup não deve ser chamada externamente.

- **`public`** (`savePokemons()`, `loadPokemons()`, `fileExists()`):
  - **Por quê `public`?** Operações atômicas e seguras de IO. O chamador não precisa acessar filesystem diretamente.

**Melhorias com funções nativas:**
```php
// Linha 29-34:
private function creatDirectoryIfNecessary(): void{
    $directory = dirname($this->dataFiles); // ✅ dirname() nativa
    if (!is_dir($directory)) { // ✅ is_dir() nativa
        mkdir($directory, 0755, true); // ✅ mkdir() nativa
    }
}

// Linha 44:
$json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // ✅ json_encode() nativa

// Linha 49:
return file_put_contents($this->dataFiles, $json) !== false; // ✅ file_put_contents() nativa
```

---

### 7. Classe `SistemaPokedex`

**Encapsulamento:**
- **`private`** (`$pokedex`, `$gerenciadorTreinadores`, `$systemOn`, todos os métodos de fluxo):
  - **Por quê `private`?** Previne que scripts externos mudem o ciclo de vida do sistema ou acessem componentes internos diretamente.

- **`public`** (`start()`):
  - **Por quê `public`?** Ponto único e controlado para operar o sistema. Toda interação passa por este método.

- **`private const TIPOS_POKEMON`**:
  - **Por quê `private const`?** Dados constantes centralizados, evitando duplicação. Acessível apenas dentro da classe.

**Melhorias implementadas:**
1. **Remoção de duplicação:** Menu de tipos centralizado em `showTypesMenu()` e criação de tipos em `createTipoByNumber()`
2. **Uso de array de classes:** Substituição do switch gigante por array associativo de classes
3. **Funções nativas:** `strtolower()`, `trim()`, `array_values()`, etc.

---

## Aplicações dos 4 Pilares da POO

### 1. Abstração (4 exemplos)

1. **Classe `Pokemon` (Abstrata)**: Define interface comum para todos os Pokémon, ocultando detalhes de implementação específicos de cada tipo.
2. **Classe `Tipo`**: Abstrai características de um tipo (nome, fraquezas, resistências) separando regras de domínio dos Pokémon.
3. **Classe `Pokedex`**: Abstrai operações de coleção (adicionar, buscar, listar, relatório) ocultando armazenamento interno.
4. **Classe `SalvamentoDeDados`**: Abstrai persistência (JSON) de forma independente da lógica de negócio.

### 2. Herança (4 exemplos)

1. **15 Subclasses de Pokémon**: Todas herdam de `Pokemon`, reutilizando atributos e comportamento comum.
2. **Sobrescrita de métodos**: Subclasses podem sobrescrever `pokemonToArray()` para adicionar campo `classe`.
3. **Construtores delegados**: Subclasses chamam `parent::__construct()` evitando duplicação.
4. **Método estático `fromArray()`**: Padroniza reconstrução a partir da persistência em cada subclasse.

### 3. Encapsulamento (4 exemplos - detalhado acima)

1. **`Pokemon`**: `protected` para subclasses, `public` getters para externo.
2. **`Tipo`**: `private` para arrays sensíveis, `public` para consultas.
3. **`Pokedex`**: `private` para coleção/contador, `public` para operações controladas.
4. **`SalvamentoDeDados`**: `private` para caminho/IO, `public` para operações atômicas.

### 4. Polimorfismo (4 exemplos)

1. **Interface comum `Pokemon`**: Métodos `showInfos()`, `showSummary()` funcionam para qualquer subclasse.
2. **Fábrica polimórfica**: `SalvamentoDeDados::createPokemonsArray()` instancia subclasse correta e trata como `Pokemon`.
3. **Estatísticas uniformes**: `Pokedex::showRecord()` trata todos os Pokémon de forma uniforme via interface comum.
4. **Extensibilidade**: Novos tipos de Pokémon podem ser adicionados sem alterar código cliente.

---

## Melhorias Implementadas

### 1. Remoção de Duplicação de Código

**Problema identificado:**
- Menu de tipos duplicado nas linhas 99-114 e 186-240 do `SistemaPokedex.php`
- Switch gigante com 15 cases duplicando lógica de criação de tipos

**Solução:**
```php
// ANTES: Duplicação
private function registerPokemon(): void{
    echo "1. Fogo\n";
    echo "2. Água\n";
    // ... 15 linhas duplicadas
}

private function chooseSecondaryType(): ?Tipo{
    echo "1) Fogo\n";
    echo "2) Água\n";
    // ... 15 linhas duplicadas
    switch ($optionType) {
        case 1: return new Tipo("Fogo", ...);
        // ... 15 cases duplicados
    }
}

// DEPOIS: Centralizado
private const TIPOS_POKEMON = [
    1 => ['nome' => 'Fogo', 'fraquezas' => [...], 'resistencia' => [...]],
    // ... todos os tipos em um único lugar
];

private function showTypesMenu(): void{
    foreach (self::TIPOS_POKEMON as $numero => $tipo) {
        echo "{$numero}) {$tipo['nome']}\n";
    }
}

private function createTipoByNumber(int $numero): ?Tipo{
    if (!isset(self::TIPOS_POKEMON[$numero])) return null;
    $tipoData = self::TIPOS_POKEMON[$numero];
    return new Tipo($tipoData['nome'], $tipoData['fraquezas'], $tipoData['resistencia']);
}
```

**Benefícios:**
- Código mais limpo e manutenível
- Alterações em tipos feitas em um único lugar
- Redução de ~100 linhas duplicadas

### 2. Uso de Array de Classes

**Antes:**
```php
switch ($optionType){
    case 1: return new PokemonFogo(...);
    case 2: return new PokemonAgua(...);
    // ... 15 cases
}
```

**Depois:**
```php
$pokemonClasses = [
    1 => PokemonFogo::class,
    2 => PokemonAgua::class,
    // ...
];
$className = $pokemonClasses[$optionType];
return new $className(...);
```

**Benefícios:**
- Mais conciso e fácil de manter
- Facilita adição de novos tipos

### 3. Classe Treinador Implementada

- Nova classe `Treinador` com nome, idade e array de Pokémon
- Persistência em JSON (`treinadores.json`)
- Funcionalidades CRUD completas (cadastrar, editar, excluir, listar, buscar)

---

## Funções Nativas do PHP Utilizadas

### 1. **`empty()`** - Verificação de arrays vazios
```php
// Pokedex.php linha 57
public function isEmpty(): bool{
    return empty($this->pokemons); // ✅ Mais eficiente que count() === 0
}
```

### 2. **`stripos()`** - Busca case-insensitive
```php
// Pokedex.php linha 41
if (stripos($pokemon->getName(), $name) !== false) {
    // ✅ Busca sem diferenciar maiúsculas/minúsculas
}
```

### 3. **`strtolower()`** - Normalização de strings
```php
// SistemaPokedex.php linha 141
if (strtolower(trim($hasSecondaryType)) === 's') {
    // ✅ Normaliza entrada do usuário
}
```

### 4. **`trim()`** - Remoção de espaços
```php
// SistemaPokedex.php linha 141
strtolower(trim($hasSecondaryType))
// ✅ Remove espaços antes/depois
```

### 5. **`array_values()`** - Reindexação de arrays
```php
// Treinador.php linha 52
$this->pokemons = array_values($this->pokemons);
// ✅ Reindexa array após unset()
```

### 6. **`count()`** - Contagem de elementos
```php
// Treinador.php linha 60
return count($this->pokemons);
// ✅ Conta elementos do array
```

### 7. **`dirname()`** - Caminho do diretório
```php
// SalvamentoDeDados.php linha 30
$directory = dirname($this->dataFiles);
// ✅ Extrai diretório do caminho do arquivo
```

### 8. **`is_dir()`** - Verificação de diretório
```php
// SalvamentoDeDados.php linha 32
if (!is_dir($directory)) {
    // ✅ Verifica se diretório existe
}
```

### 9. **`mkdir()`** - Criação de diretório
```php
// SalvamentoDeDados.php linha 33
mkdir($directory, 0755, true);
// ✅ Cria diretório recursivamente
```

### 10. **`json_encode()`** - Serialização JSON
```php
// SalvamentoDeDados.php linha 44
$json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
// ✅ Converte array para JSON formatado
```

### 11. **`json_decode()`** - Desserialização JSON
```php
// SalvamentoDeDados.php linha 66
$data = json_decode($fileContents, true);
// ✅ Converte JSON para array associativo
```

### 12. **`file_put_contents()`** - Escrita de arquivo
```php
// SalvamentoDeDados.php linha 49
file_put_contents($this->dataFiles, $json);
// ✅ Escreve conteúdo em arquivo atomicamente
```

### 13. **`file_get_contents()`** - Leitura de arquivo
```php
// SalvamentoDeDados.php linha 61
$fileContents = file_get_contents($this->dataFiles);
// ✅ Lê conteúdo completo do arquivo
```

### 14. **`file_exists()`** - Verificação de arquivo
```php
// SalvamentoDeDados.php linha 58
if (!file_exists($this->dataFiles)) {
    // ✅ Verifica se arquivo existe
}
```

---

## Conclusão

Este projeto demonstra aplicação prática e completa dos quatro pilares da POO, com código limpo, bem encapsulado e sem duplicações. As melhorias implementadas tornam o código mais manutenível, extensível e alinhado com boas práticas de desenvolvimento.

**Total de classes:** 7+ (Pokemon, Tipo, Pokedex, Treinador, GerenciadorTreinadores, SalvamentoDeDados, SistemaPokedex + 15 subclasses de Pokémon)

**Funcionalidades CRUD:** ✅ Implementadas para Pokémon e Treinadores

**Persistência:** ✅ JSON para ambos

**Boas práticas:** ✅ Encapsulamento rigoroso, sem duplicação, uso de funções nativas

