<?php

namespace Core\Database\Traits;

use Core\Database\DBConnection\DBConnection;
use PDO;

trait HasCRUD
{
    protected function setFillabels($array){
        $fillables = [];
        foreach($this->fillable as $attribute){
            array_push($fillables, $attribute." = ?");
            $this->setValues($attribute, $array[$attribute]);
        }
        return implode(', ' ,$fillables);
    }

    public function insert($array){
        $this->setSql("INSERT INTO {$this->table} SET ". $this->setFillabels($array)."," . $this->createdAt."=Now();");
        $this->executeQuery();
        $this->resetQuery();
        $object = $this->find(DBConnection::newInsertedId());
        $defaultVariables = get_class_vars(get_called_class());
        $allVariables = get_object_vars($object);
        //        // فقط کلیدهایی را نگه می‌داریم که:
//        // در آبجکت دیتابیس هستند
//        // ولی جزو پراپرتی‌های پیش‌فرض کلاس نیستند
//        // یعنی: فقط ستون‌های واقعی جدول
        $differentVariables = array_diff(array_keys($allVariables),array_keys($defaultVariables));
        foreach ($differentVariables as $attribute){
            $this->$attribute = $object->$attribute;
        }
        $this->resetQuery();
        return $this;

    }

    public function update($array){
        $this->setSql("UPDATE ".$this->table." SET ".$this->setFillabels($array).", ".$this->updatedAt."=Now()");
        $this->setWhere("AND " , $this->primaryKey." = ?");
        $this->setValues($this->primaryKey, $this->{$this->primaryKey});
        $this->executeQuery();
        $this->resetQuery();
        return $this;
    }

    public function find($id){
        $this->setSql("SELECT * FROM ". $this->table);
        $this->setWhere("AND ",$this->primaryKey." = ?");
        $this->setValues($this->primaryKey,$id);
        $statement = $this->executeQuery();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data){
            return $this->setAttribute($data);
        }else{
            return null;
        }
    }

    public function get(){
        $this->setSql(" SELECT * FROM ". $this->table);
        $statement = $this->executeQuery();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data){
            return $this->setObject($data);
        }else{
            return [];
        }
    }

    public function delete($id){
        $object = $this;
        $this->resetQuery();
        if ($id){
            $object = $this->find($id);
            $this->resetQuery();
        }
        $object->setSql("DELETE FROM ". $object->table);
        $object->setWhere("AND ",$object->primaryKey." = ?");
        $object->setValues($this->primaryKey,$id);
        return $object->executeQuery();
    }

    public function where($attribute,$operation,$value){
        // ->where('viewed','=>' , 1000);
        $condition = $attribute.' '.$operation.' ?';
        $this->setValues($attribute,$value);
        $operator = " AND ";
        $this->setWhere($operator,$condition);
        return $this;
    }

    public function OrderBy($attribute,$expression)
    {
        $this->setOrderBy($attribute,$expression);
        return $this;
    }

    public function limit($limit,$offset){
        $this->setLimit($limit,$offset);
        return $this;
    }
}