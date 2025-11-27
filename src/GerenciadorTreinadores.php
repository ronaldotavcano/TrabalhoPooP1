<?php

namespace Src;

class GerenciadorTreinadores{
    private array $trainers;
    private string $file;
    private Pokedex $pokedex;

    public function __construct(Pokedex $pokedex, string $file = 'data/treinadores.json'){
        $this->trainers = [];
        $this->file = $file;
        $this->pokedex = $pokedex;
        $this->loadTrainers();
    }

    public function addTrainer(Treinador $trainer): bool{
        // Verifica se já existe treinador no array de treinadores (com o mesmo nome), se existir retorna falso
        foreach ($this->trainers as $t) {
            if (strtolower($t->getName()) === strtolower($trainer->getName())) {
                return false;
            }
        }
        
        $this->trainers[] = $trainer;
        $this->saveTrainers();
        return true;
    }

    public function findTrainer(string $name): ?Treinador{
        // percorre o array de treinadores
        foreach ($this->trainers as $trainer) {
            // função stripos busca a string e compara com a string de busca, se for verdadeiro retorna o treinador, se não nulo
            if (stripos($trainer->getName(), $name) !== false) {
                return $trainer;
            }
        }
        return null;
    }

    public function findTrainerById(int $id): ?Treinador{
        // procura pelo Id, se nn achar retorna nulo
        return $this->trainers[$id] ?? null;
    }

    public function listAllTrainers(): array{
        // retorna o array de treinadores
        return $this->trainers;
    }

    public function removeTrainer(string $name): bool{
            //percorre os treinadores com sua chave e indice
        foreach ($this->trainers as $key => $trainer) {
             // transformo tudo em minuscula e comparo
            if (strtolower($trainer->getName()) === strtolower($name)) {
                // unset -> remove variavel ou elemento de array
                unset($this->trainers[$key]);
                // array_values -> reorganiza o array a partir do 0
                $this->trainers = array_values($this->trainers);
                $this->saveTrainers();
                return true;
            }
        }
        return false;
    }
   
    // parametros = null (são opcionais)
    public function updateTrainer(string $name, string $newName = null, int $newAge = null): bool{
        // procura o treinador pelo nome
        $trainer = $this->findTrainer($name);
        if ($trainer === null) {
            return false;
        }
        
        if ($newName !== null) {
            // atualiza o nome
            $trainer->setName($newName);
        }
        if ($newAge !== null) {
            // atualiza a idade
            $trainer->setAge($newAge);
        }
        
        $this->saveTrainers();
        return true;
    }

    public function getTotalTrainers(): int{
        // count -> conta o numero de indices do array, ou seja, retorna o total de itens
        return count($this->trainers);
    }

    public function isTrainersEmpty(): bool{
        // verifica se o array de treinadores está vazio
        return empty($this->trainers);
    }

    private function loadTrainers(): void{
        
        // se file nn existe ele sai
        if (!file_exists($this->file)) {
            return;
        }
        // se o arquivo nn tem conteudo ele sai
        $fileContents = file_get_contents($this->file);
        if ($fileContents === false) {
            return;
        }
        
        // se os dados ou se dados nn for um array ele sai
        $data = json_decode($fileContents, true);
        if ($data === null || !is_array($data)) {
            return;
        }
        
        // percorre o array de dados de treinadores e acrescenta o treinador com seus dados
        foreach ($data as $trainerData) {
            // ( :: => acessa metodos ou atributodos estáticos que pertencem a classe e não ao objeto em si )
            $trainer = Treinador::fromArray($trainerData, $this->pokedex);
            $this->trainers[] = $trainer;
        }
    }

    public function saveTrainers(): bool{
        $dataToSave = [];
        // percorre o array de treinadores e adiciona o treinador transformado em array aos dados para serem salvos
        foreach ($this->trainers as $trainer) {
            $dataToSave[] = $trainer->trainerToArray();
        }
        

        $json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // se mm for json, retorna falso
        if ($json === false) {
            return false;
        }
        
        // se nn for falso, retorna o conteudo do arquivo
        return file_put_contents($this->file, $json) !== false;
    }
}