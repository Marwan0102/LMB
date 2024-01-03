<?php
include('services/service.php');
if (!isset($_GET['id']) || empty($_GET['id'])) {
  header('Location: index.php');
  exit;
}

$clientId = "";
$clientDetails = array();

if (isset($_GET['id'])) {
  $clientId = $_GET['id'];
  $clientDetails = $apiClient->getClient($clientId);
}

if (isset($_POST['send'])) {
  $data = array(
    'nom' => $_POST['nom'],
    'telephone' => $_POST['tel'],
    'email' => $_POST['email'],
    'adresse' => $_POST['adresse'],
    'code_postal' => $_POST['code_postal'],
    'ville' => $_POST['ville'],
    'tel' => $_POST['tel'],
  );
  $updateResult = $apiClient->updateClient($clientId, $data);

  header("Location: client.php?id=" . $clientId);
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container">
      <h1 class="navbar-brand">Rechercher un contact</h1>
    </div>
  </nav>

 

  <div class="container mt-5">
    <div class="card">
      <div class="card-body d-flex justify-content-between">
        <h2 class="card-title"><?= $clientDetails['nom']; ?></h2>
        <div class="button-container">
          <button class="btn btn-lightblue btn-back"><a href="index.php">Retour</a></button>
          <button id="editButton" class="btn btn-warning float-end">
            <i class="bi bi-gear"></i> Editer
          </button>
        </div>
      </div>
    </div>

    <div id="infos" class="card mt-4">
      <div class="card-body">
        <h4 class="card-title">Informations</h4>
        <hr />
        <table class="text-center centered-table">
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><strong>Prénom & NOM</strong></td>
            <td style="padding-left: 10px;"><?= $clientDetails['nom']; ?></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><strong>Téléphone</strong></td>
            <td style="padding-left: 10x;"><?= $clientDetails['tel']; ?></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><strong>Email</strong></td>
            <td style="padding-left: 10px;"><?= $clientDetails['email']; ?></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><strong>Adresse</strong></td>
            <td style="padding-left: 10px;"><?= $clientDetails['adresse']; ?></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><strong>Code Postal</strong></td>
            <td style="padding-left: 10px;"><?= $clientDetails['code_postal'] . ' - ' . $clientDetails['ville']; ?></td>
          </tr>
        </table>
      </div>
    </div>

    <form action="?id=<?= $clientId ?>" method="POST" id="editForm" class="card mt-4 d-none">
      <div class="card-body">
        <h4 class="card-title">Modifier les informations</h4>
        <hr />
        <table class="text-center centered-table">
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><label for="nom"><strong>Prénom & NOM</strong></label></td>
            <td style="padding-left: 10px;"><input id="nom" name="nom" type="text" class="form-control mb-3" placeholder="Prénom & NOM" value="<?= $clientDetails['nom']; ?>" /></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><label for="tel"><strong>Téléphone</strong></label></td>
            <td style="padding-left: 10px;"><input id="tel" name="tel" type="text" class="form-control mb-3" placeholder="Téléphone" value="<?= $clientDetails['tel']; ?>" /></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><label for="email"><strong>Email</strong></label></td>
            <td style="padding-left: 10px;"><input id="email" name="email" type="text" class="form-control mb-3" placeholder="Email" value="<?= $clientDetails['email']; ?>" /></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><label for="adresse"><strong>Adresse</strong></label></td>
            <td style="padding-left: 10px;"><input id="adresse" name="adresse" type="text" class="form-control mb-3" placeholder="Adresse" value="<?= $clientDetails['adresse']; ?>" /></td>
          </tr>
          <tr>
            <td style="border-right: 1px solid #000; padding-right: 10px;"><label for="code_postal"><strong>Code Postal</strong></label></td>
            <td style="padding-left: 10px;"><input id="code_postal" name="code_postal" type="text" class="form-control mb-3" placeholder="Code Postal" value="<?= $clientDetails['code_postal']; ?>" /></td>
          </tr>
          <tr>
            <td class="border-control" style="border-right: 1px solid #000; padding-right: 10px;"><label for="ville"><strong>Ville</strong></label></td>
            <td style="padding-left: 10px;"><input id="ville" name="ville" type="text" class="form-control mb-3" placeholder="Ville" value="<?= $clientDetails['ville']; ?>" /></td>
          </tr>
        </table>

        <div class="text-right">
          <button type="submit" name="send" class="btn btn-light-green">Enregistrer</button>
          <button id="cancelButton" class="btn btn-outline-secondary">Annuler</button>
        </div>
      </div>
    </form>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="assets/script.js"></script>
</body>

</html>