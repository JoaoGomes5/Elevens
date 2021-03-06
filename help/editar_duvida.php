<?php 
session_start();

$id_duvida=$_GET['id'];
if(!isset($_SESSION['userId'])){

  header("Location: ../autenticar.php?acesso=negado");
  exit();
}
require '../includes/db.inc.php';

$id_duvida = $_GET['id'];

$sql = "SELECT * FROM duvidas WHERE  id_duvida = $id_duvida";
    $result = mysqli_query( $conn, $sql);
    $resultCheck = mysqli_num_rows($result);


?>


<html>
  <head>
    <meta charset="utf-8" />
    <title>Editar Dúvida</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-abrir-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>

  <?php include_once "navbar.php" ?>

    <div class="container">    
      <div class="row">

        <div class="card-abrir-chamado">
          <div class="card">
            <div class="card-header">
            
                    <h1>Edição de dúvida <span class="badge badge-danger">!</span></h1>
                  
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                <?php foreach($result as $row) : ?>
                  <form action="../includes/update_data_duvidas.php?id=<?php echo $id_duvida?>" method="post">
                    <div class="form-group" >
                      <label>Título</label>
                      <input name="titulo" type="text" class="form-control" value="<?php echo $row['titulo']?>" placeholder="Título">
                    </div>
                    
                    <div class="form-group">
                      <label>Categoria</label>
                      <select name="categoria" class="form-control" selected="<?php echo $row['categoria']?>">
                        <option>Horários</option>
                        <option>Menus</option>
                        <option>Atendimento</option>
                        <option>Eventos</option>
                        <option>Outro</option>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>Dúvida</label>
                      <input name="descricao" class="form-control" rows="3" value="<?php echo $row['descricao']?>"></input>
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" name="confirmBox" id="confirmBox">
                      <label class="form-check-label" for="confirmBox">Marque para confirmar</label>
                    </div>
                    <div class="row mt-5">
                      <div class="col-6">
                        <a class="btn btn-lg btn-success btn-block" href="menu_duvidas.php">Voltar</a>
                      </div>
  
                      <div class="col-6">
                        <button  class="btn btn-lg btn-outline-info btn-block" name="edit-duvida-submit" type="submit">Editar</button>
                      </div>
                    </div>
                  </form>
                  <?php endforeach ?>

                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>