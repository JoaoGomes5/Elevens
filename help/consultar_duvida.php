


<?php

session_start();

if(!isset($_SESSION['userId'])){

  header("Location: ../autenticar.php?acesso=negado");
  exit();
}
 

?>

<html>
  <head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-consultar-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>

  <?php include_once "navbar.php" ?>
  <?php include "../includes/see_data_duvidas.php"?>

  <?php if( isset($_GET['registo']) && isset($_GET['registo']) == 'success' ) : ?>

<div class="alert alert-success" role="alert">

  Duvida colocada com sucesso     

</div>
<div class="alert alert-info" role="alert">

  Iremos Responder logo que possamos     

</div>
<?php endif ?>
  <?php if( isset($_GET['update']) && isset($_GET['update']) == 'success' ) : ?>

<div class="alert alert-success" role="alert">

  Duvida Eliminada com Sucesso    

</div>


<?php endif ?>

    <!-- <?php if(  isset($_GET['noConfirmBox']) ) : ?> -->

<div class="container emp-profile">

    <div class="alert alert-danger d-flex justify-content-center"r role="alert">
        
    <h3>Confirme a sua edição marcado a opção "Marque para confirmar" no formulario de edição<span class="badge badge-secondary bg-danger">!</span></h3>
        
    </div>

</div>


<!-- <?php endif ?> -->

    <div class="container">    
      <div class="row">

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header">
              
              <?php 
              if(isset($_SESSION['fname'])){

            if($_SESSION['userStatus'] == 'admin'){

              echo '<h1>Consulta de todas as duvidas<span class="badge badge-danger">!</span></h1>' ;

            }else{

              echo '<h1>Consultar as minhas duvidas<span class="badge badge-danger">!</span></h1>' ;
            }

            }
            ?>
            
            
            </div>
            
            <div class="card-body">
                    <?php foreach($result as $row) : ?>
                        
                  <div class="card mb-3 bg-light">
                    <div class="card-header">
                    <h5> <?php echo $row['username']?> <span class="badge badge-primary"><?php echo $row['id_user']?></span></h6>

                  </div>
                  <div class="card-body">
                    
                    <h6 class="card-title"><?php echo $row['titulo']?></h5>
                    <h7 class="card-subtitle mb-2 text-muted"><?php echo $row['categoria']?></h7>
                    <p class="card-text"><?php echo $row['descricao']?></p>
                    
                  </div>
                  <?php if($row['id_user'] ==  $_SESSION['userId']) :?>
      
                  <a type="button" id="editar" class="btn btn-warning text-white" href="editar_duvida.php?id=<?php echo $row['id_duvida'] ?>"> Editar</a>
                  <?php endif ?>
                  <?php if($_SESSION['userStatus'] ==  'admin' || $row['id_user'] ==  $_SESSION['userId']) :?>
      
                    <a type="button" id="delete-duvida-btn" name="delete-duvida-btn" class="btn btn-danger text-white" href="../includes/delete_data_duvidas.php?delete=sim&id=<?php echo $row['id_duvida'] ?>"> Eliminar</a>
        
                 
                    <?php endif ?>
                    <?php if($row['duvida_status'] == 'pendente' && $_SESSION['userStatus'] ==  'admin') : ?>
                       <td> <a type="button" id="despromover-user-btn" name="despromover-user-btn" class="btn btn-primary text-white" href="../admin/responderDuvida.php?id_user=<?= $row['id_user']?>&id_duvida=<?= $row['id_duvida']?>">Responder</a></td>
                    <?php endif ?>

                    <?php if($row['duvida_status'] !== 'pendente') : ?>
                       <td> <a type="button" id="despromover-user-btn" name="despromover-user-btn" class="btn btn-success text-white" href=""><?= $row['duvida_status']?></a></td>
                    <?php endif ?>
                  </div>

                      <?php endforeach ?>

           


              <div class="row mt-5">
                <div class="col-6">
                <a class="btn btn-lg btn-success btn-block" href="menu_duvidas.php">Voltar</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </body>
</html>