<?php

namespace Core\Database\Traits;

use Core\Database\DBConnection\DBConnection;

trait HasQueryBuilder{
    private $sql = '';
    private $where = [];
    private $orderBy = [];
    private $limit = [];
    private $values = [];
    private $bindingValues = [];

    public function setValues($attribute, $value)
    {
        $this->values[$attribute] = $value;
        array_push($this->bindingValues, $value);
    }

    public function resetValues(){
        $this->values = [];
        $this->bindingValues = [];
    }

    public function getValues()
    {
        return $this->values;
    }

    protected function getSql()
    {
        return $this->sql;
    }

    protected function getWhere()
    {
        return $this->where;
    }

    protected function setWhere($operator, $condition)
    {
        array_push($this->where,["operator"=>$operator,"condition"=>$condition]);
    }

    protected function resetWhere()
    {
        $this->where = [];
    }

    protected function getOrderBy()
    {
        return $this->orderBy;
    }

    protected function setOrderBy($key,$expression)
    {
        array_push($this->orderBy,$key.' '.$expression);
    }

    protected function resetOrderBy()
    {
        $this->orderBy = [];
    }

    protected function getLimit()
    {
        return $this->limit;
    }

    protected function setLimit($offset,$number)
    {
        $this->limit['offset'] = (int) $offset;
        $this->limit['number'] = (int) $number;
    }

    protected function resetLimit()
    {
        unset($this->limit['offset']);
        unset($this->limit['number']);
    }

    protected function setSql($sql)
    {
        $this->sql = $sql;
    }

    protected function resetSql()
    {
        $this->sql = '';
    }

    protected function resetQuery(){
        $this->resetSql();
        $this->resetValues();
        $this->resetWhere();
        $this->resetOrderBy();
        $this->resetLimit();
    }

    protected function executeQuery(){
        $query = "";
        $query .= $this->sql;

        if(!empty($this->where)){
            $whereQuery = "";
            foreach($this->where as $where){
                $whereQuery == "" ? $whereQuery .= $where["condition"] : $whereQuery .= " ".$where["operator"]." ".$where["condition"]; ;
            }
            $query .= " WHERE ".$whereQuery;
        }

        if(!empty($this->orderBy)){
            $query .= " ORDER BY ".implode(", ",$this->orderBy);
        }

        if(!empty($this->limit)){
            $query .= " LIMIT ".$this->limit['number']." OFFSET ".$this->limit['offset'];
        }

        $query .= " ;";

        $pdoInstance = DBConnection::getDBConnectionInstance();
        $statement = $pdoInstance->prepare($query);

        if (sizeof($this->bindingValues) > 0) {
            $statement->execute($this->bindingValues);
        } else {
            $statement->execute();
        }
        return $statement;
    }
}