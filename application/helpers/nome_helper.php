<?php

if ( ! function_exists('abrevia_nome'))
{
    function abrevia_nome($nome)
    {
        $nomeCompleto = explode(" ", $nome);
        $retorno = "";

        foreach ($nomeCompleto as $nome) {
            if (!$retorno) {
                $retorno .= $nome;
            } else {
                $retorno .= " " . substr($nome, 0, 1) . ".";
            }
        }

        return $retorno;
    }
}