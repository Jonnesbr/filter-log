<?php 
abstract class model extends CI_Model {

	protected $table; // Nome da tabela padrão que irá ser manipulada pela Model
	private $primaryKey = 'id'; // Chave primária da tabela
	private $CI;
	public $where = null;
	public $campos = null;
	public $order = null;
	public $limit = null;
	public $offset = null;
	public $groupBy = null;
	public $having = null;

	public function __construct()
	{
		parent::__construct();
	}

	protected function setTable($argTable)
	{
		$this->table = $argTable;
	}
	
	public function getTable()
	{
		return $this->table;
	}

	protected function setPrimaryKey($argPrimaryKey)
	{
		$this->primaryKey = $argPrimaryKey;
	}
	
	public function insert($argCampoValor)
	{
		// Limpa indices com valores vazios
		$this->db->insert($this->table, array_filter($argCampoValor, create_function('$v', 'return $v!==NULL;')) );
		return $this->db->insert_id();
	}

    public function insertBatch($argData)
    {
        return $this->db->insert_batch($this->table, $argData);
    }

	public function update($argCamposVals,$argWhere)
	{
		if (!isset($argWhere))
			return 0;
		// Limpa indices com valores vazios
		$this->db->where($argWhere);
//		$this->db->update($this->table,array_filter($argCamposVals, create_function('$v', 'return $v!==NULL;')));
		$this->db->update($this->table, $argCamposVals);
		return $this->db->affected_rows();
	}

	public function delete($argId)
	{
		if (!isset($this->primaryKey) || empty($this->primaryKey))
			return 0;
		$this->db->where($this->primaryKey,$argId);
		return $this->db->delete($this->table);
	}

	protected function setSelect($argCampos)
	{
		// Monta lista de campos a ser selecionado ou seleciona com base na string...
		if (is_array($argCampos) && count($argCampos))
			$this->db->select(implode(',',$argCampos));
		elseif (is_string($argCampos))
			$this->db->select($argCampos);
	}
	
	protected function setLimit($argLimit,$argOffset='')
	{
		if (($argLimit)&&($argOffset))
			$this->db->limit($argLimit,$argOffset);
		else if ($argLimit)
			$this->db->limit($argLimit);
	}

	protected function setWhere($argWhere)
	{
		if (is_array($argWhere)) {
			foreach ($argWhere as $campo=>$valor){
				if (is_null($valor))
					$this->db->where($campo,null,false);
				else
					$this->db->where($campo,$valor);
			}
		}else if (isset($argWhere) && !empty($argWhere)){
			$this->db->where($argWhere,null,false);
		}
	}

	protected function setOrderBy($argOrderBy)
	{
		if(isset($argOrderBy))
			$this->db->order_by($argOrderBy);
	}

	protected function setGroupBy($argGroupBy)
	{
		if(isset($argGroupBy))
			$this->db->group_by($argGroupBy);
	}

	public function find()
	{
		if (isset($this->where)) $this->setWhere($this->where);
		if (isset($this->campos) && !empty($this->campos) ) $this->setSelect($this->campos);
		if (isset($this->order) && !empty($this->order)) $this->db->order_by($this->order);
		if (isset($this->limit) && !empty($this->limit) ) $this->setLimit($this->limit,$this->offset);
		return $this->resultArray();
	}

	public function findLike()
	{
		if (!is_array($this->where) || count($this->where) == 0 ) return false;
		$this->db->like($this->where,'', 'after');
		if (isset($this->campos) && !empty($this->campos) ) $this->setSelect($this->campos);
		if (isset($this->order) && !empty($this->order)) $this->db->order_by($this->order);
		if (isset($this->limit) && !empty($this->limit) ) $this->setLimit($this->limit,$this->offset);
		return $this->resultArray();
	}

	protected function resultArray()
	{
		$dados = $this->db->get($this->table)->result_array();
		$this->where = null;
		$this->campos = null;
		$this->limit = null;
		$this->offset = null;
		$this->groupBy = null;
		$this->having = null;
		$this->order = null;
		
		return $dados;
	}

	protected function setArguments($argWhere = null, $argCampos = null, $argOrder = null, $argLimit=null, $argOffset=null)
	{
		$this->setLimit($argLimit,$argOffset);
		$this->setSelect($argCampos);
		$this->setWhere($argWhere);
		if (isset($argOrder) && !empty($argOrder))
			$this->db->order_by($argOrder);
	}
}