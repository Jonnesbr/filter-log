<?php

class LibBase {

    public function estados()
    {
        return array(
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AM' => 'Amazonas',
            'AP' => 'Amapá',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RO' => 'Rondônia',
            'RS' => 'Rio Grande do Sul',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SE' => 'Sergipe',
            'SP' => 'São Paulo',
            'TO' => 'Tocantins'
        );
    }

    public function meses()
    {
        return array(
            1  => 'Janeiro',
            2  => 'Fevereiro',
            3  => 'Março',
            4  => 'Abril',
            5  => 'Maio',
            6  => 'Junho',
            7  => 'Julho',
            8  => 'Agosto',
            9  => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        );
    }

    function diasSemana()
    {
        return array(
            'Domingo',
            'Segunda-Feira',
            'Terça-Feira',
            'Quarta-Feira',
            'Quinta-Feira',
            'Sexta-Feira',
            'Sábado'
        );
    }

    function generos()
    {
        return array(
            '1' => 'Masculino',
            '2' => 'Feminino'
        );
    }

    function diaDaSemana($data){
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);

        $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));

        switch($diasemana) {
            case"0": return "Domingo"; break;
            case"1": return "Segunda-Feira"; break;
            case"2": return "Terça-Feira"; break;
            case"3": return "Quarta-Feira"; break;
            case"4": return "Quinta-Feira"; break;
            case"5": return "Sexta-Feira"; break;
            case"6": return "Sábado"; break;
        }

        return false;
    }

    function mes($mes)
    {
        switch ($mes) {
            case "1":
                return "Janeiro";
                break;
            case "2":
                return "Fevereiro";
                break;
            case "3":
                return "Março";
                break;
            case "4":
                return "Abril";
                break;
            case "5":
                return "Maio";
                break;
            case "6":
                return "Junho";
                break;
            case "7":
                return "Julho";
                break;
            case "8":
                return "Agosto";
                break;
            case "9":
                return "Setembro";
                break;
            case "10":
                return "Outubro";
                break;
            case "11":
                return "Novembro";
                break;
            case "12":
                return "Dezembro";
                break;
        }
        return false;
    }

}
?>