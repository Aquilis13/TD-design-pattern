<?php

namespace App;

class MusicBand implements \SplSubject
{
    private $observers;

    // Hors exercice mais notable:
    // Promotion du constructeur: https://www.php.net/manual/fr/language.oop5.decon.php#language.oop5.decon.constructor.promotion
    public function __construct(
        private string $name,
        private array $concerts = []
    ) {
        $this->observers = new \SplObjectStorage();
    }


    public function addNewConcertDate(string $date, string $location):void
    {
        $this->concert = [
            'date' =>  $date,
            'location' => $location
        ];
        $this->notify(); 
    }

    public function attach(\SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() { 
        foreach ($this->observers as $observer) { 
            $observer->update($this); 
        }
    }
}