<?php

class Animal {
    // уникальные id для каждого типа животных
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}

class Cow extends Animal {
    public function collect(): int
    {
        return rand(8, 12);
    }
}

class Chicken extends Animal {
    public function collect() : int
    {
        return rand(0, 1);
    }
}


class Farm {
    private $animals = [];

    // метод добавления животного на ферму
    public function addAnimal(Animal $animal)
    {
        $this->animals[] = $animal;
    }

    // метод подсчета всех животных на ферме
    public function collectAnimal()
    {

        $classNames = array_map(function($object) {
            return get_class($object);
        }, $this->animals);

        $countAnimals= array_count_values($classNames);
        $result = [];
        foreach ($countAnimals as $index => $value)
            $result[] = "Количество " . $index . " на ферме: " . $value;

        foreach ($result as $value)
            echo "\n" . $value;
    }

    // метод подсчета продукции за N раз
    public function collectProduce($n)
    {
        $result = [];

        for ($i = 1; $i <= $n; $i++)
        {
            foreach ($this->animals as $animal)
            {
                $result[get_class($animal)] = isset($result[get_class($animal)]) ?
                    $result[get_class($animal)] + $animal->collect() : $animal->collect();
            }
        }

        foreach ($result as $index => $value)
            echo "\nУ " . $index . " собрано: " . $value . " продукции";
    }
}


// функция для добавления коров на ферму
function cow($count)
{
    global $id_cow;
    global $farm;

    // добавляем коров
    for ($i = 1; $i <= $count; $i++) {
        $farm->addAnimal(new Cow($id_cow));
        $id_cow++;
    }

}

// функция для добавления кур на ферму
function chicken($count)
{
    global $id_chicken;
    global $farm;
    // добавляем кур
    for ($i = 1; $i <= $count; $i++) {
        $farm->addAnimal(new Chicken($id_chicken));
        $id_chicken++;
    }
}


// начальные id коров и кур (при дальнейшем добавлении животных их id будут увеличиваться, тоесть будут уникальными)
$id_cow = 1;
$id_chicken = 1;

// создаем ферму
$farm = new Farm();

// добавляем 10 коров и 20 кур
cow(10);
chicken(20);
$farm->collectAnimal();


// сбор продукции 7 раз
$farm->collectProduce(7);

// добавляем еще 5 кур и 1 корову
cow(1);
chicken(5);

// выводим обновленное кол-во животных
$farm->collectAnimal();

// сбор продукции 7 раз
$farm->collectProduce(7);
