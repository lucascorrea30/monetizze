<?php

class Jogo {
    
    // Atributos
    private $qntDezenas;
    private $resultado;
    private $totalJogos;
    private $jogos;

    // GETs e SETs
    // Qnt de Dezenas
    public function getQntDezenas() { return $this->qntDezenas; }
    public function setQntDezenas($qntDezenas) { $this->qntDezenas = $qntDezenas; }
    // Resultado
    public function getResultado() { return $this->resultado; }
    public function setResultado($resultado) { $this->resultado = $resultado; }
    // Total de Jogos
    public function getTotalJogos() { return $this->totalJogos; }
    public function setTotalJogos($totalJogos) { $this->totalJogos = $totalJogos; }
    // Jogos
    // public function getJogos() { return $this->jogos; }
    public function getJogos($i = null) { return (is_null($i)) ? $this->jogos : $this->jogos[$i]; }
    public function setJogos($jogos) { $this->jogos = $jogos; }


    function __construct($qntDezenas, $totalJogos) {
        $this->setQntDezenas($qntDezenas);
        $this->setTotalJogos($totalJogos);
    }

    // Metodos
    private function gerarDezenas($qntDezenas) {
        $arr = array();
        for ($i=0; $i<$qntDezenas; $i++) {
            $arr[] = $this->getRandomInt(1,60,$arr);
        }
        sort($arr,SORT_NUMERIC);
        return $arr;
    }
    private function getRandomInt($min, $max, $except) {
        $rand;
        do {
            $rand = rand($min, $max);
        } while (in_array($rand, $except));
        return $rand;
    }
    private function imprimirArray($arr) {
        if (is_array($arr)) {
            $str = "[";
            for ($i=0; $i<count($arr);$i++) $str .= $arr[$i] .",";
            return substr($str, 0,-1) ."]";
        } else {
            return "Não é um array";
        }
    }
    private function verificarAcertos($resultado, $jogo) {
        $acertos = 0;

        if (!is_array($resultado) || !is_array($jogo)) return $acertos;

        $size = count($jogo);
        for ($i=0; $i<$size; $i++) {
            if (in_array($jogo[$i], $resultado)) $acertos++;
        }

        return $acertos;
    }

    public function gerarJogos() {
        $arrJogos = array();
        for ($i=0; $i<$this->getTotalJogos(); $i++) {
            $arrJogos[] = $this->gerarDezenas($this->getQntDezenas());
        }
        $this->setJogos($arrJogos);
    }
    public function sortear() {
        $this->setResultado($this->gerarDezenas(6));
    }

    public function resposta() {
        $html = "
        <table>
            <thead>
                <tr>
                    <th>Números sorteados:</th>
                    <th>". $this->imprimirArray($this->resultado) ."</th>
                </tr>
                <tr>
                    <th>Jogos</th>
                    <th>Acertos</th>
                </tr>
            </thead>
            <tbody>";

        for ($i=0; $i<$this->getTotalJogos(); $i++) {
            $html .= "
                <tr>
                    <td>". $this->imprimirArray($this->getJogos($i)) ."</td>
                    <td>". $this->verificarAcertos($this->resultado, $this->getJogos($i)) ."</td>
                </tr>";
        }

        $html .= "</tbody></table>";

		return $html;
    }

}
