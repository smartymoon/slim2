<?php
namespace models;
class ModelBase{
    protected $db = null;
    protected $table = null;

    public function __construct()
    {
        $this->db    = DB::getSingleton()->DB;
        $space_array = explode('\\',get_class($this));
        $this->table = strtolower( array_pop($space_array) );
    }

    public function first($columns = '*'){
          $res = $this->db->get($this->table,$columns);
          return  $res;
    }

    public function last($columns = '*'){
        $res = $this->db->get($this->table,$columns,array(
            'ORDER'=>array('id'=>"DESC"),
        ));
        return  $res;
    }

    public function find($id,$columns = '*'){
       $res = $this->db->get($this->table,$columns,array(
          'id'=>$id,
       ));
        return $res;
    }

    public function all(){
        return $this->select();
    }

    public function select($columns = '*' ,$options = array()){
       $res = $this->db->select($this->table,$columns,$options);
       return $res;
    }

    public function  save($where,$data){
         if(is_integer($where)){
             $map['id'] = $where;
         }else{
             $map       = $where;
         }
         $affects_numb = $this->db->update($this->table,$data,$map);
         return $affects_numb;
    }

    public function  add($data){
        $id = $this->db->insert($this->table,$data);
        return $id;
    }

    public function delete($where){
        if(is_integer($where)){
            $map['id']  = $where;
        }else{
            $map        = $where;
        }
        $affect_numb = $this->db->delete($this->table,$map);
        return $affect_numb;
    }

    //public function has(){
    //    //TODO

    //}

    public function _sql(){
        var_dump($this->db->last_query());
    }

    public function debug(){
        return $this->db->debug();
    }

    public function error(){
        var_dump($this->db->error());
    }


    //math connect TODO
}