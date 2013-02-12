<?php
class Comment extends Common
{
    public $id;
    public $product_id;
    public $titulo;
    public $conteudo;
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
