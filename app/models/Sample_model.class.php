<?php
class Sample_model extends Common
{
    public $field01;
    public $field02;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    
    public $rel;
    
    function __construct($params=NULL)
    {
        $this->constructor($params);
        $dao = new DAO();
        $this->rel = $dao->get_related($this);
        return $this;
    }
}
?>
