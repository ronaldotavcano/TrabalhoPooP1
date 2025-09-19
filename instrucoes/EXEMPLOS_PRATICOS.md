# 🎮 Exemplos Práticos - Sistema de Pokédex

## 📋 Guia de Uso Passo a Passo

Este documento apresenta exemplos práticos de como usar o sistema de Pokédex, com cenários reais e saídas esperadas.

## 🚀 Primeira Execução

### 1. Instalação e Execução
```bash
# Instalar dependências
composer install

# Executar o sistema
php index.php
```

### 2. Tela de Boas-vindas
```
========================================
    🎮 SISTEMA DE POKÉDEX 🎮
========================================
Bem-vindo ao sistema de gerenciamento de Pokémon!
Aqui você pode cadastrar, buscar e gerenciar seus Pokémon.
========================================
```

## 📝 Exemplo 1: Cadastrando Pokémon de Exemplo

### Passo 1: Escolher opção 7
```
--- MENU PRINCIPAL ---
1. Cadastrar novo Pokémon
2. Buscar Pokémon por número
3. Buscar Pokémon por nome
4. Buscar Pokémon por tipo
5. Listar todos os Pokémon
6. Exibir estatísticas da Pokédex
7. Cadastrar Pokémon de exemplo
0. Sair do sistema
----------------------
Digite sua opção: 7
```

### Passo 2: Resultado
```
--- CADASTRANDO POKÉMON DE EXEMPLO ---
✅ 5 Pokémon de exemplo cadastrados com sucesso!
```

### Pokémon Cadastrados:
- **Charmander** (#4) - Tipo Fogo
- **Squirtle** (#7) - Tipo Água  
- **Bulbasaur** (#1) - Tipo Grama
- **Pikachu** (#25) - Tipo Elétrico
- **Jynx** (#124) - Tipo Gelo

## 🔍 Exemplo 2: Listando Todos os Pokémon

### Passo 1: Escolher opção 5
```
Digite sua opção: 5
```

### Passo 2: Resultado
```
--- TODOS OS POKÉMON ---
#1 - Bulbasaur (Grama)
#4 - Charmander (Fogo)
#7 - Squirtle (Água)
#25 - Pikachu (Elétrico)
#124 - Jynx (Gelo)
```

## 🔎 Exemplo 3: Buscando por Número

### Passo 1: Escolher opção 2
```
Digite sua opção: 2
```

### Passo 2: Inserir número
```
--- BUSCAR POR NÚMERO ---
Digite o número do Pokémon: 25
```

### Passo 3: Resultado
```
=== POKÉMON ===
Nome: Pikachu
Número: #25
Tipo: Elétrico
Descrição: Um Pokémon elétrico amarelo e fofo
Altura: 0.4m
Peso: 6kg
IMC: 37.50
Habilidades: Choque do trovão
Som: ⚡ Pikachu faz um som de eletricidade! Zzzzap! ⚡
Habilidade Especial: Pikachu libera uma descarga elétrica de 5000V! Raios e trovões!
Voltagem: 5000V
Potência: 50000.00W
⚡ ATENÇÃO: Este Pokémon é de alta voltagem!
⚠️  Pode causar choques perigosos!
```

## 🔍 Exemplo 4: Buscando por Nome

### Passo 1: Escolher opção 3
```
Digite sua opção: 3
```

### Passo 2: Inserir nome
```
--- BUSCAR POR NOME ---
Digite o nome do Pokémon: Char
```

### Passo 3: Resultado
```
Pokémon encontrados:
- #4 - Charmander (Fogo)
```

## 🔍 Exemplo 5: Buscando por Tipo

### Passo 1: Escolher opção 4
```
Digite sua opção: 4
```

### Passo 2: Inserir tipo
```
--- BUSCAR POR TIPO ---
Tipos disponíveis: Fogo, Água, Grama, Elétrico, Gelo
Digite o tipo: Fogo
```

### Passo 3: Resultado
```
Pokémon do tipo Fogo:
- #4 - Charmander (Fogo)
```

## 📊 Exemplo 6: Exibindo Estatísticas

### Passo 1: Escolher opção 6
```
Digite sua opção: 6
```

### Passo 2: Resultado
```
=== RELATÓRIO DA POKÉDEX ===
Total de Pokémon: 5

Pokémon por tipo:
- Fogo: 1
- Água: 1
- Grama: 1
- Elétrico: 1
- Gelo: 1

Pokémon mais pesado: #124 - Jynx (Gelo) (40.6kg)
Pokémon mais alto: #124 - Jynx (Gelo) (1.4m)
```

## ✨ Exemplo 7: Cadastrando Novo Pokémon

### Passo 1: Escolher opção 1
```
Digite sua opção: 1
```

### Passo 2: Inserir dados básicos
```
--- CADASTRAR NOVO POKÉMON ---
Nome do Pokémon: Vulpix
Descrição: Um Pokémon de fogo com seis caudas
Número na Pokédex: 37
Altura (metros): 0.6
Peso (kg): 9.9
```

### Passo 3: Escolher tipo
```
Tipos disponíveis:
1. Fogo
2. Água
3. Grama
4. Elétrico
5. Gelo
Escolha o tipo (1-5): 1
```

### Passo 4: Inserir dados específicos
```
Temperatura corporal (°C): 100
```

### Passo 5: Resultado
```
✅ Pokémon cadastrado com sucesso!
```

## 🎯 Exemplo 8: Testando Habilidades Especiais

### Buscando Charmander e testando habilidades:
```
--- BUSCAR POR NÚMERO ---
Digite o número do Pokémon: 4

=== POKÉMON ===
Nome: Charmander
Número: #4
Tipo: Fogo
Descrição: Um Pokémon de fogo com chama na cauda
Altura: 0.6m
Peso: 8.5kg
IMC: 23.61
Habilidades: Lança-chamas
Som: 🔥 Charmander faz um rugido flamejante! Fwoooosh! 🔥
Habilidade Especial: Charmander lança uma rajada de fogo intensa! A temperatura sobe para 120°C!
Temperatura Corporal: 120°C
```

## 🔄 Exemplo 9: Fluxo Completo de Uso

### Cenário: Treinador cadastrando sua equipe

1. **Cadastrar Pokémon de exemplo** (opção 7)
2. **Listar todos** (opção 5) - Ver o que foi cadastrado
3. **Cadastrar novo Pokémon** (opção 1) - Adicionar à equipe
4. **Buscar por tipo** (opção 4) - Ver Pokémon de fogo
5. **Exibir estatísticas** (opção 6) - Ver resumo da equipe
6. **Sair** (opção 0)

## 🎮 Exemplo 10: Interações Específicas por Tipo

### Pokémon de Fogo (Charmander):
- **Som**: Rugido flamejante
- **Habilidade**: Rajada de fogo
- **Especial**: Temperatura corporal alta

### Pokémon de Água (Squirtle):
- **Som**: Som de ondas
- **Habilidade**: Tsunami
- **Especial**: Pode mergulhar profundamente

### Pokémon de Grama (Bulbasaur):
- **Som**: Sussurro de folhas
- **Habilidade**: Fotossíntese
- **Especial**: Cura e fortalece

### Pokémon Elétrico (Pikachu):
- **Som**: Eletricidade
- **Habilidade**: Descarga elétrica
- **Especial**: Alta voltagem

### Pokémon de Gelo (Jynx):
- **Som**: Cristalino
- **Habilidade**: Tempestade de gelo
- **Especial**: Temperatura muito baixa

## 🚨 Exemplo 11: Tratamento de Erros

### Tentativa de cadastrar Pokémon com número duplicado:
```
--- CADASTRAR NOVO POKÉMON ---
Nome do Pokémon: Charmander2
Descrição: Outro Charmander
Número na Pokédex: 4
...
❌ Erro: Já existe um Pokémon com este número!
```

### Busca por Pokémon inexistente:
```
--- BUSCAR POR NÚMERO ---
Digite o número do Pokémon: 999
❌ Pokémon não encontrado!
```

### Busca por tipo inexistente:
```
--- BUSCAR POR TIPO ---
Digite o tipo: Dragão
❌ Nenhum Pokémon do tipo Dragão encontrado!
```

## 🎯 Dicas de Uso

### 1. **Comece com Pokémon de Exemplo**
- Use a opção 7 para ter dados de teste
- Explore as funcionalidades com dados prontos

### 2. **Use Busca Inteligente**
- Busque por nome parcial (ex: "Char" encontra "Charmander")
- Use tipos para filtrar Pokémon específicos

### 3. **Monitore Estatísticas**
- Use a opção 6 para ver resumos da sua coleção
- Identifique Pokémon mais pesados/altos

### 4. **Experimente Diferentes Tipos**
- Cada tipo tem características únicas
- Teste temperaturas, voltagens e profundidades

### 5. **Organize por Número**
- Use números sequenciais para organização
- Evite números duplicados

## 🔧 Comandos Úteis

### Executar com script do Composer:
```bash
composer start
```

### Verificar se Composer está funcionando:
```bash
composer --version
```

### Reinstalar dependências:
```bash
composer install --no-cache
```

## 📱 Saída de Exemplo Completa

```
========================================
    🎮 SISTEMA DE POKÉDEX 🎮
========================================
Bem-vindo ao sistema de gerenciamento de Pokémon!
Aqui você pode cadastrar, buscar e gerenciar seus Pokémon.
========================================

--- MENU PRINCIPAL ---
1. Cadastrar novo Pokémon
2. Buscar Pokémon por número
3. Buscar Pokémon por nome
4. Buscar Pokémon por tipo
5. Listar todos os Pokémon
6. Exibir estatísticas da Pokédex
7. Cadastrar Pokémon de exemplo
0. Sair do sistema
----------------------
Digite sua opção: 7

--- CADASTRANDO POKÉMON DE EXEMPLO ---
✅ 5 Pokémon de exemplo cadastrados com sucesso!

--- MENU PRINCIPAL ---
...
Digite sua opção: 5

--- TODOS OS POKÉMON ---
#1 - Bulbasaur (Grama)
#4 - Charmander (Fogo)
#7 - Squirtle (Água)
#25 - Pikachu (Elétrico)
#124 - Jynx (Gelo)

--- MENU PRINCIPAL ---
...
Digite sua opção: 0

========================================
    👋 OBRIGADO POR USAR A POKÉDEX! 👋
========================================
Até a próxima, Treinador Pokémon!
========================================
```

Este sistema oferece uma experiência completa de gerenciamento de Pokémon, demonstrando conceitos fundamentais de programação orientada a objetos de forma prática e divertida!
