<?php
//это мир в котором будут жить наши звери
class World {
    //object instance
    protected static $instance;

    //Защищаем от создания через new Singleton
    private function __construct() { /* ... */ }

    //Защищаем от создания через клонирование
    private function __clone() { /* ... */ }

    //Защищаем от создания через unserialize
    private function __wakeup() { /* ... */ }

    //Возвращает единственный экземпляр класса
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

	private $population = array();

	public function populate(Animal $animal) {
		$this->population[] = $animal;
	}
	
	public function getPopulation() {
		return $this->population;
	}
}

//простое животное, ничего не умеет и рождаться тоже :)
abstract class Animal {
	
    //средний вес (кг)
	protected $avgWeight;
    
	//скорость (км/ч)
    protected $runSpeed;
    
    //коэффицент потери скорости
	protected $runSpeedDecrease;
    
	//время на передышку (ч)
    protected $timeToRest;
	
	protected $weight;

	protected function __construct($weight) {
		$this->weight = $weight;
	}
	public function getRunSpeed() {
		return $this->runSpeed;
	}
	
	public function getWeight() {
		return $this->weight;
	}

	public function run($distance) {
        if ($this->weight > $this->avgWeight) {
            $this->runSpeed -= ($this->weight - $this->avgWeight);
            $this->runSpeed *= $this->runSpeedDecrease;
        }
        return ($distance / $this->runSpeed);
	}
		
	public function runWithRest($distance, $stops) {
        if ($this->weight > $this->avgWeight) {
            $this->runSpeed -= ($this->weight - $this->avgWeight);
            $this->runSpeed *= $this->runSpeedDecrease;
        }
        return (($distance / $this->runSpeed) + ($stops * $this->timeToRest));
	}
}

//хищное животное, умеет охотиться
abstract class Carnivore extends Animal	{
	public abstract function hunt();
}

//среднестатистический кот в вакууме
class Cat extends Carnivore {
  
	public function __construct($weight) {
		parent::__construct($weight);
		
		$this->avgWeight = 3;
		$this->runSpeed = 20;
		$this->runSpeedDecrease = 0.8;
		$this->timeToRest = 0.5;
	}

	//будем охотиться
	public function hunt() {
	
		foreach (World::getInstance()->getPopulation() as $animal) {
            //на плотоядных охотиться не будем, ибо могут съесть
			if ($animal instanceof Carnivore) {
				continue;
			}
            
			//на особо крупных тоже охотиться не будем, вспомним слона и моську
			if ($animal->getWeight() / $this->getWeight() > 1.5) {
				continue;
			}
			
			//и на особо быстрых, не догоним
			if ($animal->getRunSpeed() > $this->getRunSpeed()) {
				continue;
			}
			
			//ура, нашли!			
			return $animal;
		}
		
		return null;
	}
}

class Zebra extends Animal {
	
	public function __construct($weight) {
		parent::__construct($weight);
		
		$this->avgWeight = 120;
		$this->runSpeed = 60;
		$this->runSpeedDecrease = 0.8;
		$this->timeToRest = 0.5; 	
	}
}

class Mouse extends Animal {
	
	public function __construct($weight) {
		parent::__construct($weight);
		
		$this->avgWeight = 0.1;
		$this->runSpeed = 10;
		$this->runSpeedDecrease = 0.8;
		$this->timeToRest = 0.25; 	
	}
}
?>