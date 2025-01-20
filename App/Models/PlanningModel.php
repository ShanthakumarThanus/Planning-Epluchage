<?php

namespace App\Models;

use MongoDB\Client;

class PlanningModel {
    private $collection;

    public function __construct() {
        $client = new Client("mongodb+srv://thanus:thanus@planning.17a75.mongodb.net/");
        $database = $client->selectDatabase('Planning');
        $this->collection = $database->selectCollection('utilisateurs');
    }

    public function getWeeks($year) {
        $startOfYear = new \DateTime("$year-01-01");
        $endOfYear = new \DateTime("$year-12-31");
        $date = new \DateTime();
        $date->setISODate($year, 1);
        $weeks = [];

        while ($date <= $endOfYear) {
            if ($date >= $startOfYear) {
                $weeks[] = $date->format("d/m/Y");
            }
            $date->modify('+1 week');
        }
        return $weeks;
    }

    public function getSavedData() {
        return iterator_to_array($this->collection->find());
    }

    public function getUserStatistics() {
        $pipeline = [
            ['$group' => ['_id' => '$user', 'count' => ['$sum' => 1]]],
            ['$sort' => ['count' => 1]]
        ];
        $result = $this->collection->aggregate($pipeline);
        $userCount = [];

        foreach ($result as $doc) {
            $userCount[$doc->_id] = $doc->count;
        }

        return $userCount;
    }
}
