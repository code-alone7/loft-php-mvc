<?php

namespace Core;

use Core\DB;
use Core\exceptions\ModelException;
use DateTime;

abstract class Model
{
    static protected string|null $name = null;
    static protected array $fields = [];
    static protected array $iterators = [];

    protected array $values = [];

    public function __construct(array $data)
    {
        // генерация автоинкреметнов (зачем я это сделал?)
        /*$autoincrements = array_filter(static::$fields, function($el){
            return array_key_exists('autoincrement', $el);
        });
        foreach ($autoincrements as $name => $field){
            if(!array_key_exists($name, static::$iterators)) static::$iterators[$name] = 0;
            $data[$name] = ++static::$iterators[$name];
        };*/

        $this->values = $data;
    }

    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->values);
    }

    public function __get(string $name)
    {
        if(array_key_exists($name, $this->values)){
            return $this->values[$name];
        }
        return null;
    }
    public function __set(string $name, $value): void
    {
        if(array_key_exists($name, static::$fields)){
            $this->values[$name] = $value;
        }
    }



    public static function getById($id): static|null
    {
        $name = explode('\\', static::class);
        $name = end($name).'s';
        $name = static::$name ?? strtolower($name);

        $db = DB::getInstance();
        $select = "SELECT * FROM $name WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if (!$data) {
            return null;
        }

        return new static($data);
    }

    public function save(): static|false
    {
        // добавление даты создания
        if(array_key_exists('created_at', static::$fields)){
            $dateTime = new DateTime();
            $this->values['created_at'] = $dateTime->getTimestamp();
        }

        // проверка на соответствие с полями
        $filteredFields = array_filter(static::$fields, function($el){
            $isPrimary = array_key_exists('primary_key', $el) && $el['primary_key'];
            $isNotRequired = array_key_exists('is_not_required', $el) && $el['is_not_required'];

            return !($isPrimary || $isNotRequired);
        });

        $diff
            = count(array_diff_key($this->values, static::$fields))
            + count(array_diff_key($filteredFields, $this->values));

        if($diff!==0){
            throw new ModelException('wrong fields');
        }

        // проверка на соответствие с типами данных (не реализованно)
        /*for($data as $title => $value){
            if(gettype($value) !== static::$fields[$title]){
                return false;
            }
        }*/

        // составление запроса
        $db = DB::getInstance();

        $name = explode('\\', static::class);
        $name = end($name).'s';
        $name = static::$name ?? strtolower($name);

        $fields = array_map(function($el){ return "`$el`"; }, array_keys($this->values));
        $fields = implode(', ', $fields);

        $values = array_map(function($el){ return "'$el'"; }, $this->values);
        $values = implode(', ', $values);


        $queryStr = "INSERT INTO {$name} ({$fields}) VALUES ({$values});";
        $db->exec($queryStr, __METHOD__);

        $id = $db->lastInsertId();
        $this->id = $id;

        return $this;
    }

    public function update()
    {
        // что мне делать?
    }

    public function delete()
    {
        if(!$this->id) throw new ModelException('model is not event inserted');

        $db = DB::getInstance();

        $explode = explode('\\', static::class);
        $name = $name ?? end($explode).'s';
        $name = strtolower($name);

        $id = $this->id;

        $queryStr = "DELETE FROM $name WHERE id=:id";

        $db->exec($queryStr, __METHOD__, [
            ':id' => $this->id
        ]);
    }
}