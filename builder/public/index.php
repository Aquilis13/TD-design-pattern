<?php
require('../vendor/autoload.php');


# TODO: Creer un QueryBuilder
# Ecrire une requête en chainant des methodes
# Afficher la requête

try {
    $queryBuilder = new MySQLQueryBuilder();

    // Test SELECT
    $queryBuilder->select('column1, column2')->from('table')->where('column1 = 1');
    $selectQuery = $queryBuilder->getRequete();
    echo "SELECT query: \n$selectQuery\n";

    // Test DELETE
    $queryBuilder->delete()->from('table')->where('column1 = 1');
    $deleteQuery = $queryBuilder->getRequete();
    echo "DELETE query: \n$deleteQuery\n";

    // Test UPDATE
    $queryBuilder->update('table')->set('column1', 'value')->where('column2 = 2');
    $updateQuery = $queryBuilder->getRequete();
    echo "UPDATE query: \n$updateQuery\n";
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}