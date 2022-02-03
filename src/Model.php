<?php

namespace Core;

use Core\exceptions\ModelException;

abstract class Model
{
    private static array $fields = [];
    private array $values;
    private string $name;

    public function __construct(array $data)
    {
        $keyDiff = array_diff_key(self::$fields, $data);
        if(count($keyDiff)===0){
            throw new ModelException('wrong fields');
        }
        /*for($data as $title => $value){
            if(gettype($value) !== self::$fields[$title]){
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