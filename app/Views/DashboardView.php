<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
  <?php include 'Navbar.php' ?>
  <div class="container-fluid">
    <div class="text-center mt-5">
      <h1 class="mb-5">Tableau de bord</h1>
      <hr>
    </div>
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card text-center bg-primary text-light">
          <div class="card-body">
            <h5 class="card-title">Total logements</h5>
            <p class="display-4"><?= $totalApart ?? 0 ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center bg-success text-light">
          <div class="card-body">
            <h5 class="card-title">Vendus</h5>
            <p class="display-4"><?= $soldApart ?? 0 ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center bg-info text-light">
          <div class="card-body">
            <h5 class="card-title">Disponibles</h5>
            <p class="display-4"><?= $availableApart ?? 0 ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center bg-warning text-light">
          <div class="card-body">
            <h5 class="card-title">Ventes</h5>
            <p class="display-4"><?= $totalSales ?? 0 ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center bg-danger text-light">
          <div class="card-body">
            <h5 class="card-title">Chiffre d'affaires</h5>
            <p class="display-4"><?= number_format($revenue ?? 0) ?> Ar</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center bg-secondary text-light">
          <div class="card-body">
            <h5 class="card-title">Meilleur agent</h5>
            <p class="display-4"><?= isset($topOfficer) ? $topOfficer['OfficerName'] : '-' ?></p>
            <p><?= isset($topOfficer) ? $topOfficer['SaleNb'] . ' vente(s)' : '' ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
