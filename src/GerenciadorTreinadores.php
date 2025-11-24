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
        // Verifica se já existe treinador com o mesmo nome
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
        foreach ($this->trainers as $trainer) {
            if (stripos($trainer->getName(), $name) !== false) {
                return $trainer;
            }
        }
        return null;
    }

    public function findTrainerById(int $id): ?Treinador{
        return $this->trainers[$id] ?? null;
    }

    public function listAll(): array{
        return $this->trainers;
    }

    public function removeTrainer(string $name): bool{
        foreach ($this->trainers as $key => $trainer) {
            if (strtolower($trainer->getName()) === strtolower($name)) {
                unset($this->trainers[$key]);
                $this->trainers = array_values($this->trainers);
                $this->saveTrainers();
                return true;
            }
        }
        return false;
    }

    public function updateTrainer(string $name, string $newName = null, int $newAge = null): bool{
        $trainer = $this->findTrainer($name);
        if ($trainer === null) {
            return false;
        }
        
        if ($newName !== null) {
            $trainer->setName($newName);
        }
        if ($newAge !== null) {
            $trainer->setAge($newAge);
        }
        
        $this->saveTrainers();
        return true;
    }

    public function getTotalTrainers(): int{
        return count($this->trainers);
    }

    public function isEmpty(): bool{
        return empty($this->trainers);
    }

    public function saveTrainers(): bool{
        $dataToSave = [];
        foreach ($this->trainers as $trainer) {
            $dataToSave[] = $trainer->trainerToArray();
        }
        
        $json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return false;
        }
        
        return file_put_contents($this->file, $json) !== false;
    }

    private function loadTrainers(): void{
        if (!file_exists($this->file)) {
            return;
        }
        
        $fileContents = file_get_contents($this->file);
        if ($fileContents === false) {
            return;
        }
        
        $data = json_decode($fileContents, true);
        if ($data === null || !is_array($data)) {
            return;
        }
        
        foreach ($data as $trainerData) {
            $trainer = Treinador::fromArray($trainerData, $this->pokedex);
            $this->trainers[] = $trainer;
        }
    }
}

