<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/AppBase/LibCrud.php';

class LibMonitoramento extends LibCrud
{


    public function verificarSyslog($argData)
    {
        $data = '2016-11-16 00:00:00';
        $querySQL = "
                     select * 
                     from systemevents 
                     where message like '%Updating bind%@{$argData['ip']}:5060' and devicereportedtime >= '{$data}'
                     limit 30
                    ";

        $this->setModel('modelpgmonitoramento');

        $this->CI->{$this->model}->campos = $this->campos;
        $this->CI->{$this->model}->limit = $this->limit;
        $this->CI->{$this->model}->offset = $this->offSet;
        $this->CI->{$this->model}->order = $this->order;
        $this->CI->{$this->model}->where = $this->where;

        if ($this->CI->{$this->model}->order)
            $querySQL .= " ORDER BY {$this->CI->{$this->model}->order}";

        if ($this->CI->{$this->model}->limit)
            $querySQL .= " LIMIT {$this->CI->{$this->model}->limit}";

        if ($this->CI->{$this->model}->offset)
            $querySQL .= " OFFSET {$this->CI->{$this->model}->offset}";

        return $this->CI->{$this->model}->executeQuery($querySQL);
    }

    public function gerarRegistro($argData)
    {
        if ($result = $this->verificarSyslog($argData)) {
            $dados = array();
            $data1 = null;
            $primeiro = array();
            $registro = array();
            foreach ($result as $chave => $valor) {
                $dados[$chave]['syslog_id'] = $valor['id'];
                $dados[$chave]['data'] = $valor['devicereportedtime'];
                $dados[$chave]['cliente_ip'] = $valor['message'];

                if ($chave != 0) {
                    $data1 = new DateTime($data1);
                    $data2 = new DateTime(($valor['devicereportedtime']));
                    $diff = $data1->diff($data2);
                    $dados[$chave]['intervalo'] = $diff->format('%i:%s');
                    $diff->s = ($diff->s > 6) ? '0' . $diff->s : $diff->s;
                    $segundos = strlen( $diff->s ) < 2 ? '0'.$diff->s: $diff->s;
                    $diferenca = $diff->i .'.'.$segundos;
                    $diferenca = floatval($diferenca);

                    if ($diferenca <= INTERVALO_MINIMO) {

                        $registro['id1'] = $primeiro['id'];
                        $registro['id2'] = $valor['id'];
                        $registro['cliente_ip'] = $argData['ip'];
                        $registro['data_inicio'] = date_format($data1, 'Y-m-d H:i:s');
                        $registro['data_fim'] = date_format($data2, 'Y-m-d H:i:s');
                        $registro['duracao'] = $diff->i . ':' .$diff->s;
                        $registro['diff'] = $diff;
                        $registro['teste'] = $diff->format('%i:%s');

                        $this->registrarEvento($registro);
                    }

                    if ($diferenca >= INTERVALO_MAXIMO) {

                        $registro['id1'] = $primeiro['id'];
                        $registro['id2'] = $valor['id'];
                        $registro['cliente_ip'] = $argData['ip'];
                        $registro['data_inicio'] = date_format($data1, 'Y-m-d H:i:s');
                        $registro['data_fim'] = date_format($data2, 'Y-m-d H:i:s');
                        $registro['duracao'] = $diff->i . ':' .$diff->s;
                        $registro['diff'] = $diff;
                        $registro['teste'] = $diff->format('%i:%s');

                        $this->registrarEvento($registro);
                    }



                }

                $data1 = $valor['devicereportedtime'];
                $primeiro['id'] = $valor['id'];

            }

            echo "<pre>";
            echo "Eventos capturados com sucesso";
            echo "<br><br>";
            var_dump($dados);exit;
        }
    }

    public function registrarEvento($argData)
    {
        $dados = array(
            'syslog_id' => $argData['id1'],
            'cliente_ip' => $argData['cliente_ip'],
            'data_inicio' => $argData['data_inicio'],
            'data_fim' => $argData['data_fim'],
            'duracao' => $argData['duracao']
        );

        $this->setModel('modelmonitoramento');
        $this->inserir($dados);
        return true;
    }

    public function buscarEvento()
    {
        $this->CI->{$this->model}->where = $this->where;
        $this->CI->{$this->model}->campos = $this->campos;
        $this->CI->{$this->model}->limit = $this->limit;
        $this->CI->{$this->model}->order = $this->order;
        $this->CI->{$this->model}->offset = $this->offSet;
        $this->CI->{$this->model}->groupBy = $this->groupBy;
        $this->CI->{$this->model}->having = $this->having;
        return $this->CI->{$this->model}->buscarEvento();
    }
}