<?php

namespace App\Factory;

use App\Entity\Bicycle;
use App\Entity\Car;
use App\Entity\Truck;

class VehiculeFactory {

    public static function create($typeVehicule) {
        switch($typeVehicule){
            case 'Bicycle' :
                return new Bicycle();
                break;
            case 'Car' :
                return new Car();
                break;
            case 'Truck' :
                return new Truck();
                break;
            default :
                throw new Exception(`Type de véhicule '$typeVehicule' inconnu.`);
        }
    }

    public static function create($distanceEnKm, $poidsTransporter) {
        // Si la distance parcouru est inférieur à 20km 
        // et que le poids transporté est inférieur à 20kg
        // on renvoie un vélo
        if($distanceEnKm < 20 && $poidsTransporter < 20){
            return new Bicycle();
        }

        // Si le poids transporté est supérieur à 200kg on renvoie un camion
        if($poidsTransporter > 200){
            return new Truck();
        }

        // Par défaut on renvoie une voiture
        return new Car();
    }
}
