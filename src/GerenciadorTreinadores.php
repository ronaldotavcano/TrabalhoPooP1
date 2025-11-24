<?php

namespace Src;

class GerenciadorTreinadores{
    private array $treinadores;
    private string $arquivo;
    private Pokedex $pokedex;

    public function __construct(Pokedex $pokedex, string $arquivo = 'data/treinadores.json'){
        $this->treinadores = [];
        $this->arquivo = $arquivo;
        $this->pokedex = $pokedex;
        $this->carregarTreinadores();
    }

    public function adicionarTreinador(Treinador $treinador): bool{
        // Verifica se já existe treinador com o mesmo nome
        foreach ($this->treinadores as $t) {
            if (strtolower($t->getNome()) === strtolower($treinador->getNome())) {
                return false;
            }
        }
        
        $this->treinadores[] = $treinador;
        $this->salvarTreinadores();
        return true;
    }

    public function buscarTreinador(string $nome): ?Treinador{
        foreach ($this->treinadores as $treinador) {
            if (stripos($treinador->getNome(), $nome) !== false) {
                return $treinador;
            }
        }
        return null;
    }

    public function buscarTreinadorPorIndice(int $indice): ?Treinador{
        return $this->treinadores[$indice] ?? null;
    }

    public function listarTodos(): array{
        return $this->treinadores;
    }

    public function removerTreinador(string $nome): bool{
        foreach ($this->treinadores as $key => $treinador) {
            if (strtolower($treinador->getNome()) === strtolower($nome)) {
                unset($this->treinadores[$key]);
                $this->treinadores = array_values($this->treinadores);
                $this->salvarTreinadores();
                return true;
            }
        }
        return false;
    }

    public function atualizarTreinador(string $nome, string $novoNome = null, int $novaIdade = null): bool{
        $treinador = $this->buscarTreinador($nome);
        if ($treinador === null) {
            return false;
        }
        
        if ($novoNome !== null) {
            $treinador->setNome($novoNome);
        }
        if ($novaIdade !== null) {
            $treinador->setIdade($novaIdade);
        }
        
        $this->salvarTreinadores();
        return true;
    }

    public function getTotalTreinadores(): int{
        return count($this->treinadores);
    }

    public function estaVazia(): bool{
        return empty($this->treinadores);
    }

    private function salvarTreinadores(): bool{
        $dataToSave = [];
        foreach ($this->treinadores as $treinador) {
            $dataToSave[] = $treinador->treinadorToArray();
        }
        
        $json = json_encode($dataToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return false;
        }
        
        return file_put_contents($this->arquivo, $json) !== false;
    }

    private function carregarTreinadores(): void{
        if (!file_exists($this->arquivo)) {
            return;
        }
        
        $fileContents = file_get_contents($this->arquivo);
        if ($fileContents === false) {
            return;
        }
        
        $data = json_decode($fileContents, true);
        if ($data === null || !is_array($data)) {
            return;
        }
        
        foreach ($data as $treinadorData) {
            $treinador = Treinador::fromArray($treinadorData, $this->pokedex);
            $this->treinadores[] = $treinador;
        }
    }
}

