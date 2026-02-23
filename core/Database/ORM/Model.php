<?php

namespace Core\Database\ORM;

use Core\Database\Traits\HasAttributes;
use Core\Database\Traits\HasCRUD;
use Core\Database\Traits\HasQueryBuilder;
Abstract class Model
{
    use HasQueryBuilder,HasAttributes,HasCRUD;
    protected $table= '';

    protected $fillable = [];

    protected $hidden = [];

    protected $casts = [];

    protected $primaryKey = 'id';

    protected $createdAt = 'created_at';

    protected $updatedAt = 'updated_at';

    protected $deletedAt = null;

    protected $collection = [];

    protected $attributes = [];


    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

}