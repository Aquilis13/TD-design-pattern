<?php

namespace App;

class MySQLQueryBuilder implements QueryBuilderInterface
{
    private $requete;
    private $typeRequete;

    /**
     * Retourne la requête actuelle
     * 
     * @return string La requête SQL actuelle
     */
    public getRequete() {
        return $this->requete + ";";
    }

    /**
     * Envoie la requête à la base de données et retourne le résultat
     * 
     * @return
     * @throws Exception S'il y a une erreur de configuration pour la connexion à la base de données
     * @throws Exception Si la requête est mal construite
     */
    public sendRequete() {
        $conf = parse_ini_file('./conf/db.conf.ini');

        try {
            $pdo = new \PDO("mysql:host=".$conf["host"].";dbname=".$conf["database"].";charset=utf8", $conf["user"], $conf["password"], 
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_STRINGIFY_FETCHES => false
                )
            );
        } catch(Exception $e) {
			throw new Exception("Erreur de configuration dans la connexion à la base de données");
		}

        try {
            $req = $pdo->prepare($this->getRequete());
            $req->execute();
            
            if($this->typeRequete == "select"){
                return $req->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(Exception $e) {
            throw new Exception("La requête est mal construite");
        }
    }
    
    /**
     * Définit le type de requête à SELECT et initialise la requête avec les colonnes spécifiées
     *
     * @param string $colonnes Les colonnes à sélectionner
     * @throws Exception Si une construction de requête est déjà en cours
     */
    public function select(string $colonnes) { 
        if($this->typeRequete == null) {
            $this->typeRequete = "select";
            $this->requete = `SELECT $colonnes`;
        } else {
            throw new Exception(`Vous êtes entrain de construire une requête de type $this->typeRequete. Vous ne pouvez pas construire une requête de type select. \nRequête actuelle : \n$this->requete`);
        } 
    }

    /**
     * Définit le type de requête à DELETE
     * 
     * @throws Exception Si une construction de requête est déjà en cours
     */
    public function delete() { 
        if($this->typeRequete == null) {
            $this->typeRequete = "delete";
            $this->requete = `DELETE`;
        } else {
            throw new Exception(`Vous êtes entrain de construire une requête de type $this->typeRequete. Vous ne pouvez pas construire une requête de type delete. \nRequête actuelle : \n$this->requete`);
        } 
    }

    /**
     * Définit le type de requête à UPDATE et initialise la requête avec la table spécifiée
     *
     * @param string $table La table à mettre à jour
     * @throws Exception Si une construction de requête est déjà en cours
     */
    public function update(string $table) { 
        if($this->typeRequete == null) { 
            $this->typeRequete = "update";
            $this->requete = `UPDATE $table`;
        } else {
            throw new Exception(`Vous êtes entrain de construire une requête de type $this->typeRequete. Vous ne pouvez pas construire une requête de type update. \nRequête actuelle : \n$this->requete`);
        } 
    }

    /**
     * Ajoute la clause FROM à la requête avec la table spécifiée
     *
     * @param string $table La table à sélectionner
     * @throws Exception Si le type de requête est UPDATE
     */
    public function from(string $table) { 
        if($this->typeRequete != null && $this->typeRequete != "update"){
            $this->requete = `$this->requete FROM $table`;
        } else {
            throw new Exception(`La requête ne peut pas implémenter l'attribut FROM. \nRequête actuelle : \n$this->requete`);
        }
    }

    /**
     * Ajoute la clause WHERE à la requête avec la condition spécifiée
     *
     * @param string $condition La condition à ajouter à la clause WHERE
     * @throws Exception Si le type de requête n'est pas défini
     */
    public function where(string $condition) { 
        if($this->typeRequete != null){
            if (strpos($this->requete, "WHERE") !== false) {
                $this->requete = `$this->requete WHERE $condition`;
            } else {
                if (strpos($this->requete, "AND") !== true
                    || strpos($this->requete, "OR") !== true
                    || strpos($this->requete, "XOR") !== true) 
                {
                    $this->requete = `$this->requete $condition`;
                } else {
                    throw new Exception(`La fonction where a déjà été appelée, veuillez préciser AND, OR ou XOR devant votre condition. \nRequête actuelle : \n$this->requete`);
                }
            }
            
        } else {
            throw new Exception(`La requête ne peut pas implémenter l'attribut WHERE. \nRequête actuelle : \n$this->requete`);
        }
    }

    /**
     * Ajoute la clause SET à la requête avec l'attribut et la nouvelle valeur spécifiés
     *
     * @param string $attributAModifier L'attribut à modifier
     * @param string $nouvelleValeur La nouvelle valeur de l'attribut
     * @throws Exception Si le type de requête n'est pas UPDATE
     */
    public function set(string $attributAModifier, string $nouvelleValeur) { 
        if($this->typeRequete != null && $this->typeRequete == "update"){
            $this->requete = `$this->requete SET $attributAModifier = $nouvelleValeur`;
        } else {
            throw new Exception(`La requête ne peut pas implémenter l'attribut SET. \nRequête actuelle : \n$this->requete`);
        }
    }
}
