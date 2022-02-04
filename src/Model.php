<?php

namespace Core;

use Core\exceptions\ModelException;
use DateTime;

abstract class Model
{
    static protected string|null $name = null;
    static protected array $fields = [];
    static protected array $iterators = [];

    protected array $values;

    public function __construct(array $data)
    {
        //append autoincrements
        $autoincrements = array_filter(static::$fields, function($el){
            return array_key_exists('autoincrement', $el);
        });
        foreach ($autoincrements as $name => $field){
            if(!array_key_exists($name, static::$iterators)) static::$iterators[$name] = 0;
            $data[$name] = ++static::$iterators[$name];
        };

        //append created_at
        if(array_key_exists('created_at', static::$fields)){
            $date = new DateTime();
            $data['created_at'] = $date->getTimestamp();
        }

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