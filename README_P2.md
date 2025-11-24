## Aplicações de POO (Pilar por Pilar)

Este documento lista 16 aplicações práticas de POO neste projeto (4 por pilar).

### Abstração (4)
- Definição da classe base `Src\Pokemon` como tipo genérico para todos os Pokémon (oculta detalhes de cada tipo e expõe uma interface comum: getters, `showInfos`, `showSummary`).
- Classe `Src\Tipo` abstrai características de um tipo (nome, fraquezas, resistências) separando regras de domínio dos Pokémon.
- Classe `Src\Pokedex` abstrai as operações de coleção (adicionar, buscar, listar, relatório) e oculta armazenamento/estrutura interna.
- Classe `Src\SalvamentoDeDados` abstrai persistência (JSON) de forma independente da lógica de negócio.

### Herança (4)
- Tipos específicos de Pokémon (ex.: `Src\Tipos\PokemonFogo`, `PokemonAgua`, etc.) herdam de `Src\Pokemon` reutilizando atributos e comportamento comum.
- Possibilidade de sobrescrever comportamentos nos filhos mantendo a mesma interface pública da classe base.
- Construtores das subclasses delegam para o construtor da classe base, evitando duplicação de código.
- Método utilitário estático `fromArray` nas subclasses (quando existente) padroniza a reconstrução a partir da persistência.

### Encapsulamento (4) — por que protected/private/public
- `Src\Pokemon`
  - **protected (name, primaryType, secondaryType, description, number, height, weight)**: permite que subclasses utilizem diretamente dados essenciais sem expor o estado para fora da hierarquia. Protege invariantes (ex.: número não deve mudar arbitrariamente) e reduz acoplamento externo.
  - **public getters (getName, getNumber, getPrimaryType, getSecondaryType, getHeight, getWeight)**: fornecem leitura controlada para o “mundo externo” sem permitir mutações indevidas. Se regras mudarem (ex.: formatação, validação), alteramos internamente sem quebrar clientes.
  - **public methods (showInfos, showSummary, pokemonToArray)**: representam a interface estável de uso; detalhes de formatação/serialização ficam escondidos.
- `Src\Tipo`
  - **private (name, weakness, resistance)**: proíbe alteração direta de coleções sensíveis; garante consistência (nenhuma classe externa injeta valores inválidos). 
  - **public getters e verificadores (getName, getWeakness, getResistance, isWeakAgainst, isResistanceAgainst)**: fornecem a informação necessária e operações de domínio sem expor a estrutura interna.
- `Src\Pokedex`
  - **private (pokemons, totalPokemons, persistencia)**: impede manipular diretamente a coleção/contador/camada de IO, evitando estados inválidos (ex.: duplicatas, desserialização parcial).
  - **public API (addPokemon, searchByNumber, searchByName, listAll, isEmpty, getTotalPokemons, getStatistics, showRecord, loadData, saveData, hasDataSaved)**: define o contrato de uso da coleção. Regras (ex.: evitar duplicar número) vivem aqui, não espalhadas.
- `Src\SalvamentoDeDados`
  - **private (dataFiles)**: caminho do arquivo é detalhe interno. Evita que outras classes alterem fonte de dados sem passar por validações.
  - **public (savePokemons, loadPokemons, fileExists)**: operações atômicas e seguras de IO; o chamador não acessa filesystem diretamente.
- `Src\SistemaPokedex`
  - **private (pokedex, systemOn, métodos de fluxo e UI)**: previne scripts externos de mudarem o ciclo de vida do sistema; a interação é feita via o método público `start()`.
  - **public (start)**: ponto único e controlado para operar o sistema.

Em resumo: usamos private para proteger estado interno e invariantes, protected para compartilhar dados entre a classe base e subclasses sem vazamento externo, e public apenas para a interface necessária ao uso do domínio (métodos de consulta/ação). Isso reduz acoplamento, previne estados inválidos e facilita evoluções futuras sem quebrar código cliente.

### Polimorfismo (4)
- `Src\Pokemon` define a interface de exibição (`showInfos`, `showSummary`) que funciona para qualquer subclasse de Pokémon.
- `SalvamentoDeDados::createPokemonsArray` usa polimorfismo para instanciar a subclasse correta a partir do campo `classe` e depois trata todos como `Pokemon`.
- Em `Pokedex::showRecord`, os itens mais alto/pesado são tratados de forma uniforme via interface comum (`showSummary`, `getHeight`, `getWeight`).
- Possibilidade de cada subclasse de Pokémon customizar comportamento de exibição ou estatísticas sem alterar o código cliente.

---

## Ajustes de código realizados nesta etapa

1. Renomeação da camada de persistência para refletir o requisito ("salvamento de dados"):
   - Arquivo e classe `PersistenciaPokemon` -> `SalvamentoDeDados`.
   - `Pokedex` atualizado para usar `SalvamentoDeDados`.

2. Alinhamento de nomes (consistência e clareza):
   - Métodos públicos em inglês descritivo em `Pokedex`/`Pokemon`/`Tipo` (ex.: `searchByNumber`, `getPrimaryType`, `showRecord`, etc.).
   - `SistemaPokedex` atualizado para o novo menu sem as opções 4, 7 e 8 antigas e com rótulos sequenciais.

3. Redução de duplicações:
   - Centralização de serialização/deserialização em `pokemonToArray` (na base) e `fromArray` (nas subclasses), evitando lógica repetida.
   - Persistência JSON em uma única classe (`SalvamentoDeDados`).

4. Encapsulamento reforçado:
   - Propriedades privadas/protegidas e acesso por getters, sem exposição direta de estado interno.

5. Polimorfismo preservado e preparado:
   - Padrão de fábrica simples na leitura (`createPokemonsArray`) e uso de interface comum de `Pokemon` em toda a aplicação.

Estas mudanças deixam o código mais coeso, com responsabilidades separadas, menos acoplamento e pronto para extensão de novos tipos sem alterar o código cliente.


