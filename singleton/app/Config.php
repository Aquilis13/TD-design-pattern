<?php

# TODO: Créer une classe Config en Singleton

namespace App;

class Config {
    private static $_instance;
    private $settings;

    /**
     * Récupère les paramètres du fichier config.php dans le répertoire config
     * 
     */
    private function __construct(){
        $this->settings = include('../config/config.php');
    }

    /**
     * Retourne l'instance de la classe Config. 
     * Si elle n'existe pas on la crée.
     * 
     */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    /**
     * Retourne une clé passer en paramètre dans le fichier config
     * 
     */
    public function get($key){
        if($key == "debug" || $key == "apiKey"){
            return $this->settings[$key];
        }else{
            return $this->settings['db'][$key];
        }        
    }
} 
