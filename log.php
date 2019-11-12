<?php
// Start the session
session_start();
if (isset($_GET['Message'])) {
    print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script scr="login.js" ></script>
    <link rel="stylesheet" href="login.css"
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body style="background-color:#17a2b8">
    <?php
      $param = $_SESSION["username"];
    ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $param; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a href="changePassword.php" class="nav-link" href="#">Cambiar contraseña <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a href="enterprises.php" class="nav-link" href="#">Empresas<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a href="log.php" class="nav-link" href="#">Log<span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <div class="container justify-content-left align-items-left">
      <br />
      <div class="row">
        <div class="col">
          <table class="table table-striped table-dark">
            <thead >
              <tr>
                  <th>Usuario</th>
                  <th>Acción</th>
                  <th>Fecha y Hora</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'dbConnection.php';

              $dbConnection = new dbConnection();
              $dbConnection->connect();
              $data = $dbConnection->getLogs();
              foreach($data as $row){
                
                $user = $row['user'];
                $action = $row['action'];
                $creationTime = $row['creationTime'];

                echo '<tr>
                        <td>'.$row['user'].'</td>'.
                        '<td>'.$row['action'].'</td>'.
                        '<td>'.$row['creationTime'].'</td>'.
                      '</tr>' ;
              }
              ?>
            </tbody>
      </table>
    </div>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
