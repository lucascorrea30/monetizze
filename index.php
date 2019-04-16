<?php

include('jogo.class.php');

$jogo = new Jogo(8, 15);
$jogo->gerarJogos();
$jogo->sortear();
echo $jogo->resposta();