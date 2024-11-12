<?php

function mostrarMensaje($mensaje,$tipo){

 switch ($tipo){

   case 'i':
                        return  ( '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                        .$mensaje.
                        ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>' );
   break;

   case 'w':
                        return    ( '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                                .$mensaje.
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>' );
    break;
    case 'e':
                        return   ( '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                                .$mensaje.
                              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
    
     break;
    default:

                            return   ( '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                            .$mensaje.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>' );

     break;

 }

}
               



