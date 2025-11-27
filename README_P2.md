
# 🎮 Pokedex 🎮

## Sobre:

O projeto para a P2 foi a 

O projeto 2 classes: 
Pokemon.php (classe abstrata) -> 15 classes que herdam de Pokemon sendo as suas tipagens, ex: PokemonDragao (pokemon do tipo dragão).
PersistenciaPokemon -> relacionada ao salvamento de dados dos Pokemons.
Pokedex -> Classe com as funções que a pokedex tem.
SistemaPokedex -> Classe que exibirá as mensagens no terminal.
Tipos -> classe que define: nome do tipo, fraquezas e resistências.


### Funções extras estudadas e utilizadas:

Para o projeto pesquisamos inúmeras funções extras nativas do php, como : ?Tipo -> significa que a instância pode receber o valor nulo, .= -> para concatenar strings, na função pokemonToArray o => indica que terá uma 'chave' acompanhada de um valor, ?? (null coalescing) ele retorna o primeiro valor se existir e não for nulo. forEach -> usado para percorrer arrays, stripos -> para buscar strings dentro de strings, issets -> para verificar se uma variável não é nula, implode -> retorna uma string completa de um array. :: -> operador de resolução de escopo usado para acessar métodos.

Extras para salvamento -> is_dir -> verifica se o caminho já possui um diretório, mkdir -> para criar um novo repositório, json_encode -> transforma um array em json, file_put_contents -> escrever no arquivo .json, file_exists -> confere se o arquivo exist, file_get_content -> lê o conteúdo do arquivo e retorna uma string e entre outros.

## Como rodar

- 1º) Ao abrir o terminal do projeto ( ctrl + j)
- 2º) digitar composer install ou composer i
- 3º) Ainda no terminal digitar php index.php

## Participantes:

- Ronaldo T Cano, RA: 2051371
- Victor Freire do Carmo, RA: 2051790
- Matheus Silva Carneiro , RA: 2038093
- Victor Hugo Brahim Affonso, RA: 2042168 
