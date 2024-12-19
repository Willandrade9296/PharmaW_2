<?php

session_start();
include_once "includes/header.php";


if (!empty($_SESSION['idUser'])){ 

    if (empty($existe) && $id_user != 1) {

        // header('Location: permisos.php');
        include "permisos.php";
     }else{
?>

<div class="card shadow-lg">

                               <div class="card-header card-header-primary ">
									<h4 class="card-title">Reportes</h4>
									
								</div>

                                <div class="card-body" >
                               
                                <div class="row">
                                   <div class="col-md-6 col-sm-12 col-xs-12">
                                   
                                                <div class="list-group" style="max-height: 250px; overflow:scroll; -webkit-overflow-scrolling: touch;" >
                                                <button type="button" class="list-group-item list-group-item-action">
                                                    Cras justo odio
                                                </button>
                                                <button type="button" class="list-group-item list-group-item-action">Dapibus ac facilisis in</button>
                                                <button type="button" class="list-group-item list-group-item-action">Morbi leo risus</button>
                                                <button type="button" class="list-group-item list-group-item-action">Porta ac consectetur ac</button>
                                                <button type="button" class="list-group-item list-group-item-action" >Vestibulum at eros</button>
                                                <button type="button" class="list-group-item list-group-item-action" >Vestibulum at eros</button>
                                                </div>
                                     
                                    </div>

                                </div>
                                  
                                </div>




     </div>
<?php

 }
}else{

    header("Location: ../index.php");
}

include_once "includes/footer.php";

?>




