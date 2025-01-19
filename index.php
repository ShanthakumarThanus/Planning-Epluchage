<?php

require 'vendor/autoload.php';

//$client = new MongoDB\Client("mongodb://localhost:27017");
$client = new MongoDB\Client("mongodb+srv://thanus:thanus@planning.17a75.mongodb.net/");
$database = $client->selectDatabase('Planning');
$collection = $database->selectCollection('utilisateurs');

$savedData = iterator_to_array($collection->find());

function getWeeks($year) {
  $startOfYear = new DateTime("$year-01-01");
  $endOfYear = new DateTime("$year-12-31");  
  $date = new DateTime();
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

$year = date('Y');
if (isset($_POST['year'])) {
    $year = intval($_POST['year']);
}

$weeks = getWeeks($year);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $updated = 0;
    foreach ($weeks as $index => $week) {
        $selectedUser = $_POST["week_$index"] ?? 'personne';

        $result = $collection->updateOne(
            ['week' => $week],
            ['$set' => ['user' => $selectedUser]],
            ['upsert' => true]
        );

        if ($result->getModifiedCount() > 0 || $result->getUpsertedCount() > 0) {
            $updated++;
        }
    }
    echo "<p>$updated changements enregistrés avec succès !</p>";
}

function getUserStatistics($collection) {
  $pipeline = [
      ['$group' => ['_id' => '$user', 'count' => ['$sum' => 1]]],
      ['$sort' => ['count' => 1]]
  ];

  $result = $collection->aggregate($pipeline);
  $userCount = [];

  foreach ($result as $doc) {
      $userCount[$doc->_id] = $doc->count;
  }

  return $userCount;
}

$userCount = getUserStatistics($collection);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
        .vincent {
            background-color: #FF9900;
        }
        .david {
            background-color: #00CCFF;
        }
        .thomas {
            background-color: #00FF33;
        }
        .christophe {
            background-color: #FFFF00;
        }
        .personne {
            background-color: #FF0000;
        }
        .container {
            width: 950px;
            margin: 0 auto;
        }
        .annee {
            text-align: center;
        }
    </style>
    <title>Planning</title>
</head>
<body>

<div class="container">
  <p>Voici un calendrier annuel des corvées hebdomadaire d'épluchage des patates. </p>
  <h1> Planning des corvées d'épluchage</h1>
    <form action="#" method="post" name="form1" id="form1">
        <p class="annee">
          <label for="year">Année :
            <select name="year" id="year" onchange="this.form.submit()">
                <?php for ($i = 2020; $i <= 2030; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php if ($i == $year) echo 'selected'; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
          </label>
        </p>
    </form>

    <form action="" method="post">
        <table border="1" align="center">
            <?php foreach ($weeks as $index => $week): ?>
                <?php if ($index % 4 == 0) echo '<tr>'; ?>

                <?php
                // Initialiser $selectedUser avec la valeur par défaut
                $selectedUser = 'personne';
                foreach ($savedData as $data) {
                    if ($data['week'] === $week) {
                        $selectedUser = $data['user'];
                        break;
                    }
                }
                ?>

                <td>
                    <?php echo htmlspecialchars($week); ?>
                    <select name="week_<?php echo $index; ?>" class="<?php echo htmlspecialchars($selectedUser); ?>">
                        <option value="personne" <?php if ($selectedUser == 'personne') echo 'selected'; ?>>personne</option>
                        <option value="vincent" <?php if ($selectedUser == 'vincent') echo 'selected'; ?>>vincent</option>
                        <option value="david" <?php if ($selectedUser == 'david') echo 'selected'; ?>>david</option>
                        <option value="thomas" <?php if ($selectedUser == 'thomas') echo 'selected'; ?>>thomas</option>
                        <option value="christophe" <?php if ($selectedUser == 'christophe') echo 'selected'; ?>>christophe</option>
                    </select>
                </td>

                <?php if ($index % 4 == 3) echo '</tr>'; ?>
            <?php endforeach; ?>
        </table>
        <div align="center">
  	      <p>
            <input type="submit" name="save">
          </p>
        </div>
        <h2>Statistiques par ordre croissant</h2>
        <ol> 
          <?php foreach ($userCount as $user => $count): ?> 
            <li><?php echo ucfirst($user) . " : " . $count; ?></li>
          <?php endforeach; ?> </ol>
        <p>&nbsp;</p>
    </form>
</div>

</body>
</html>
