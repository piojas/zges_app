<?php

namespace App\DataFixtures;

use App\Entity\Task;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $tasks = [
        1 => [
            'title' => 'Formularz w Symfony', 
            'description' => 'Przy wykorzystaniu frameworka Symfony stwórz formularz, w którym będzie możliwość dodawania dynamicznych pól formularza z możliwością edycji.
                Należy wykorzystać CollectionType Field. Do zapisywania wartości z pól formularza wykorzystaj bazę danych do wyboru: MySQL, MariaDB, SQLite. Pola formularza mają być typu "text".
                Do dodawania pól formularza wykorzystaj jQuery. Na stronie ma znajdować się przycisk "Dodaj nowe pole", który doda nowe pole formularza.
                Poniżej link do dokumentacji:
                https://symfony.com/doc/current/reference/forms/types/collection.html',
            'start' => '2023-09-15 14:00:00',
            'stop' => '2023-09-18 15:00:00',
            ],
        2 => [
            'title' => 'REST API (w php) technologia dowolna', 
            'description' => 'Napisz aplikację komunikującą się z przykładowym REST API: https://petstore.swagger.io/
                Umożliw dodawanie, pobieranie, edycję i usuwanie elementów w zasobie /pet. Od strony użytkownika zrób prosty interfejs z formularzami. Obsłuż błędy.',
            'start' => '2023-09-18 15:00:00',
            'stop' => '2023-09-19 17:00:00',
            ],
        3 => [
            'title' => 'Generowanie kodu kreskowego(PHP), dowolna technologia i biblioteka', 
            'description' => 'Stwórz aplikację, która przyjmuje dowolny tekst i na jego podstawie generuje i zapisuje kod kreskowy w formacie WebP.',
            'start' => '2023-09-18 17:00:00',
            'stop' => '2023-09-19 22:00:00',
            ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->tasks as $task) {
            $item = (new Task())
                ->setTitle($task['title'])
                ->setDescription($task['description'])
                ->setStart(new \DateTimeImmutable($task['start']))
                ->setStop(new \DateTimeImmutable($task['stop']))
            ;

            $manager->persist($item);
        }

        $manager->flush();
    }
}
