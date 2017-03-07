<?php

namespace Analogue\ORM;

class ValueMap
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $embeddables = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var boolean
     */
    protected $disablePrefixes = false;

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getEmbeddables()
    {
        return $this->embeddables;
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (isset($this->name)) {
            return $this->name;
        } else {
            return class_basename($this);
        }
    }

    public function usePrefixes()
    {
        return $this->disablePrefixes ? false : true;
    }

    /**
     * Maps the names of the column names to the appropriate attributes
     * of an entity if the $attributes property of an EntityMap is an
     * associative array.
     *
     * @param array $array
     * @return array
     */
    public function getAttributeNamesFromColumns($array)
    {
        $attributes = $this->getAttributes();

        if (is_asociative_array($attributes)) {
            $newArray = [];

            foreach ($array as $key => $value) {
                $attributeName = isset($attributes[$key]) ? $attributes[$key] : $key;
                $newArray[$attributeName] = $value;
            }

            return $newArray;
        }

        return $array;
    }

    /**
     * Gets the entity attribute name of a given column in a table
     *
     * @param string $column_name
     * @return string
     */
    public function getAttributeNameForColumn($column_name)
    {
        $attributes = $this->getAttributes();

        if (is_asociative_array($attributes)) {
            if (isset($attributes[$column_name])) {
                return $attributes[$column_name];
            }
        }

        return $column_name;
    }

    /**
     * Gets the column name of a given entity attribute
     *
     * @param string $column_name
     * @return string
     */
    public function getColumnNameForAttribute($attribute_name)
    {
        $attributes = $this->getAttributes();

        if (is_asociative_array($attributes)) {
            $flipped = array_flip($attributes);
            if (isset($flipped[$attribute_name])) {
                return $flipped[$attribute_name];
            }
        }

        return $attribute_name;
    }

    /**
     * Maps the attribute names of an entity to the appropriate
     * column names in the database if the $attributes property of
     * an EntityMap is an associative array.
     *
     * @param array $array
     * @return array
     */
    public function getColumnNamesFromAttributes($array)
    {
        $attributes = $this->getAttributes();

        if (is_asociative_array($attributes)) {
            $flipped = array_flip($attributes);

            foreach ($array as $key => $value) {
                $attributeName = isset($flipped[$key]) ? $flipped[$key] : $key;
                $newArray[$attributeName] = $value;
            }

            return $newArray;
        }

        return $array;
    }

    public function hasAttribute($attribute)
    {
        $attributes = $this->getAttributes();

        if (is_asociative_array($attributes)) {
            return in_array($attribute, array_values($attributes));
        }

        return in_array($attribute, $attributes);
    }
}
