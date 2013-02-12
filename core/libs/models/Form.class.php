<?php
/* 
Author: Cicero Monteiro

Description:
	Defines methods that generates HTML forms
*/
class Form extends DAO
{
	/* Default definitions */
    private $Form = "<form";
    private $Attr = array('name'=>'default_form','action'=>'#','method'=>'post','enctype'=>'multipart/form-data');
	/* Default constructor */
    function __construct($params=array())
    {
        if (is_array($params) && count($params))
        {
            $count = count($params);
            $keys = array_keys($params);
            $attr_keys = array_keys($this->Attr);
            $attr_count = count($this->Attr);
            $already = array();
            for ($i=0;$i<$count;$i++)
            {
                $this->Form .= " ".$keys[$i]."=\"".$params[$keys[$i]]."\"";
                if (array_key_exists($keys[$i], $this->Attr))
                {
                    unset($this->Attr[$keys[$i]]);
                }
            }
            $attr_count = count($this->Attr);
            $attr_keys = array_keys($this->Attr);
            for ($i=0;$i<$attr_count;$i++)
            {
                $this->Form .= " ".$attr_keys[$i]."=\"".$this->Attr[$attr_keys[$i]]."\"";
            }
        }
        else
        {
            $attr_count = count($this->Attr);
            $attr_keys = array_keys($this->Attr);
            for ($i=0;$i<$attr_count;$i++)
            {
                $this->Form .= " ".$attr_keys[$i]."=\"".$this->Attr[$attr_keys[$i]]."\"";
            }
        }
        $this->Form .= ">";
        return $this;
    }
	/* Begins the form */
    function Start()
    {
        echo $this->Form;
        return FALSE;
    }
	/* Ends the form */
    function End()
    {
        echo "</form>";
        return FALSE;
    }
	/* Generates input[text,checkbox,file,etc...] fields */
    function Input($params=array(), $model=FALSE, $view=FALSE, $required=FALSE)
    {
        if (is_array($params) && count($params))
        {
            $id = FALSE;
            $Input = "<input";
            $count = count($params);
            $keys = array_keys($params);
            for ($i=0;$i<$count;$i++)
            {
                $Input .= " ".$keys[$i]."=\"".$params[$keys[$i]]."\"";
                $id = $keys[$i] == 'id' ? true : false;
                $name = $keys[$i] == 'name' ? true : false;
            }
            if (!$name && $model && $view)
            {
                $Input .= " name=\"data[".ucwords($model)."][".$view."]"."\"";
                if ($params['type'] != "password" && !array_search('value', $keys))
                {
                    $Input .= " value=\"".@$_POST['data'][ucwords($model)][$view]."\"";
                }
            }
            if (!$id && $model && $view)
            {
                $Input .= " id=\"".ucwords($model)."_".ucwords($view)."\"";
            }
            $Input .= " />";
            if ($required)
            {
                $Input .= "<span class=\"mdt\">&nbsp;*</span>";
            }
            echo $Input;
        }
        return FALSE;
    }
    /* Generates select fields */
    function Select($collection, $params=array(), $model=FALSE, $view=FALSE, $inner_html=FALSE, $check_vlw=FALSE, $mdt=TRUE, $vlw='id')
    {
        $Select = "<select";
        if ($sizeof = sizeof($params))
        {
            foreach ($params as $k=>$v)
            {
            	$Select .= " ".$k."=\"".$v."\"";
            }
        }
        if (!isset($params['name']) && $model && $view)
        {
            $Select .= " name=\"data[".ucwords($model)."][".$view."]\"";
        }
        $Select .= ">";
        $chk = $_POST ? "" : " selected=\"selected\"";
        $Select .= $mdt ? "" : "<option value=\"\"$chk></option>";
        if (is_array($collection))
        {
            $aux = 0;
            $keys = array_keys($collection);
            foreach ($collection as $c)
            {
                $check_vlw = $check_vlw ? $check_vlw : @$_POST['data'][ucwords($model)][$view];
                if (is_object($c))// array de objetos
                {
                    $select = ($check_vlw == $c->get($vlw)) && $c->get($vlw) ? " selected=\"selected\"" : "";
                    $Select .= "<option value=\"".$c->get($vlw)."\"$select>".$c->get($inner_html)."</option>\n";
                }
                else
                {
                    $select = ($check_vlw == $keys[$aux]) && $keys[$aux]  ? " selected=\"selected\"" : "";
                    $Select .= "<option value=\"".$keys[$aux]."\"$select>".$c."</option>\n";
                    $aux++;
                }
            }
        }
        $Select .= "</select>";
        echo $Select;
        return FALSE;
    }
    /* Generates textarea fields */
    function Textarea($params, $model, $attr, $innerHTML=false)
    {
        if (is_array($params))
        {
            $Textarea = "<textarea name=\"data[".ucwords($model)."][".$attr."]\" id=\"".ucwords($model)."_".ucwords($attr)."\"";
            foreach ($params as $k=>$v)
            {
                $Textarea .= " ".$k."=\"".$v."\"";
            }
			if ($_POST || !$innerHTML)
			{
				$innerHTML = @$_POST['data'][ucwords($model)][$attr];
			}
            $Textarea .= ">$innerHTML</textarea>";
            echo $Textarea;
        }
        return FALSE;
    }
}
?>