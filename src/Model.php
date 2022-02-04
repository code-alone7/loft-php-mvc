<?php

namespace Core;

use Core\exceptions\ModelException;

abstract class Model
{
    static protected string|null $name = null;
    static protected array $fields = [];
    protected array $values;

    public function __construct(array $data)
    {
        $diff = count(array_diff_key($data, static::$fields)) + count(array_diff_key(static::$fields, $data));
        if($diff!==0){
            throw new ModelException('wrong fields');
        }
        /*for($data as $title => $value){
            if(gettype($value) !== static::$fields[$title]){
                return false;
            }
        }*/
        $this->values = $data;
    }

    public function __get(string $name)
    {
        if(array_key_exists($name, $this->values)){
            return $this->values[$name];
        }
        return null;
    }

    public function save()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}