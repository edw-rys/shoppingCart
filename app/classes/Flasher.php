<?php 
class Flasher{
    private $valida_types = ['primary','secondary','success','danger','warning','info','light','dark'];
    private $default = 'primary';
    private $type;
    private $msg;
    /**
    * Método para guardar una notificación flash
    *
    * @param string array $msg
    * @param string $type
    * @return void
    */
    public static function new($msg , $type = null){
        $self = new self();
        // Setear el tipo de notificación 
        if($type == null)
            $self->type = $self->default;

        $self->type = in_array($type , $self->valida_types)?$type : $self->default;
        
        // Guardar la notificación
        if(is_array($msg)){
            foreach($msg as $m)
                $_SESSION[$self->type][]=$msg;
            return true;
        }
        $_SESSION[$self->type][]=$msg;
        return true;
    }
    /**
    * Renderiza las notificaciones a nuestro usuario
    *
    * @return void
    */
    public function flash(){
        $self = new self();
        $output = '';
        if(isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
            foreach ($_SESSION[$type] as $m) {
                $output .= '<div class="alert alert-'.$type.' alert-dismissible show fade" role="alert">';
                $output .= $m;
                $output .= '<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">'.
                            '<span aria-hidden="true">&times;</span></button>';
                $output .= '</div>';
            }
    
            unset($_SESSION[$type]);
        }
        return $output;

    }
}
