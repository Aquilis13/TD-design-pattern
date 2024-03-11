<?php

# TODO: Créer une classe QueryBuilder en utilisant le design pattern Builder

namespace App;

interface QueryBuilderInterface
{
    public function select(string $colonnes);
    public function delete();
    public function update(string $table);
    public function from(string $table);
    public function where(string $condition);
    public function set(string $attributAModifier, string $nouvelleValeur);
}