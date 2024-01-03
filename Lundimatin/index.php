<?php
include('services/service.php');

$allClients = $apiClient->getClients(null, array(
  'sort' => 'nom',
  'fields' => 'nom,adresse,ville,code_postal,tel',
));


?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/style.css" />
</head>

<body class="bg-surface-secondary">
  <nav class="navbar navbar-dark">
    <div class="container">
      <h1 class="navbar-brand">Rechercher un contact</h1>
    </div>
  </nav>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">Recherche d'une fiche contact</h2>
      </div>
    </div>
  </div>

  <div class="container mt-2">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <h2 class="card-title small">Renseigner un nom ou une dénomination</h2>
        <form action="search.php" method="get">
          <div class="input-group mb-3">
            <input type="text" name="query" class="form-control" placeholder="Nom ou dénomination" />
            <button id="editButton" class="btn btn-warning float-end" type="submit">Rechercher</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <table class=" card-body table mt-4">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Nom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Ville</th>
            <th scope="col">Téléphone</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php if ($allClients) : ?>
            <?php foreach ($allClients as $client) : ?>
              <tr>
                <td>
                  <div class="logo-circle">
                    <?php
                    $initials = "";
                    $nameParts = explode(' ', $client['nom']);
                    foreach ($nameParts as $part) {
                      $initials .= strtoupper($part[0]);
                    }
                    echo $initials;
                    ?>
                  </div>
                </td>
                <td><?= $client['nom']; ?></td>
                <td><?= $client['adresse']; ?></td>
                <td><?= $client['code_postal']; ?> - <?= $client['ville']; ?></td>
                <td><?= $client['tel']; ?></td>
                <td>
                  <a href="client.php?id=<?= $client['id']; ?>" class="badge bg-soft-primary text-primary">
                    <i class="fa fa-search"></i> Voir
                  </a>
                </td>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">Aucun client trouvé</td>
              </tr>
            <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="assets/script.js"></script>
</body>

</html>