<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/AppBase/LibCrud.php';

class LibMonitoramento extends LibCrud
{


    public function verificarSyslog()
    {
        $data = '2016-11-15 00:00:00';
        $querySQL = "
                     select * 
                     from systemevents 
                     where message like '%Updating bind%@10.2.1.11:5060' and devicereportedtime >= '{$data}'
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

    public function gerarRegistro()
    {
        if ($result = $this->verificarSyslog()) {
            
        }
    }
}