<?php

try{ 
    
include "../conexion.php";
include "includes/components.php";

if (empty($_SESSION['active'])) {
    header('Location: ../');
}else{

$id_user = $_SESSION['idUser'];

}






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
   <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Farmacia 1</title>
    <link href="../assets/css/material-dashboard.css" rel="stylesheet" />
    

    
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    
    
<link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

   

   
    <link href="../assets/css/buttons.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />

    <link href="../assets/css/style.css" rel="stylesheet" />
    
    

</head>



<body>
    <div class="wrapper ">
        <div class="sidebar" data-color="blue"  >
            <div class="logo "><a href="./" class="simple-text logo-normal">
                    Farmacia 1
                </a></div>
            <div class="sidebar-wrapper">
            <ul class="nav">
                  <?php
                    $sql = mysqli_query($conexion, "SELECT * FROM vipermisos  WHERE id_usuario = $id_user ");
                    while ($opcion = mysqli_fetch_assoc($sql)) {

                   ?>
                      <li class="nav-item">
                        <a class="nav-link d-flex" href=<?php echo $opcion['archivo'].".php"  ?>>
                            <i class="<?php echo $opcion['logo_opcion']  ?>"></i>
                            <p> <?php echo $opcion['nombre_op']  ?></p>
                        </a>
                      </li>

                   
                    <?php
                        }

                     ?>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:;"></a>
                        <b style="font-weight:bold; margin-right:10px;">Usuario:</b> <span style="font-size:25px;"><?php echo "".$_SESSION['user']?></span>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    
                    <div class="navbar-nav " >


                        
                            <div class="nav-item dropdown" >
                               
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                        <?php echo "".$_SESSION['user']?> <i class="fas fa-user"></i> 
                                            
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right text-right">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#nuevo_pass">Perfil</a></li>
                                        <li> <a class="dropdown-item" href="salir.php">Cerrar Sesión</a></li>
                                    
                                        </ul>
                                    
                                    </div>
                            </div>
                        

                         


                    </div>
                    
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content bg">
                <div class="container-fluid">

                <?php   
                }catch(Exception $e){

                echo "Error: ".$e->getMessage();
                }

                
                ?>