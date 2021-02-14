<?php

class RepositoryFactory
{
    public static function build($type, $repository)
    {
        $typeRepository = ucfirst($type).'Repository';
        if (class_exists($typeRepository)) 
        {
            return new $typeRepository($repository);
        }
        else 
        {
            throw new Exeption($type. ' not exist');
        }
    }
}