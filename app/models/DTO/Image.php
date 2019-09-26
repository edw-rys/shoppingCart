<?php
class Image{
    public static function getDirImg($_name){
        if($_FILES[$_name]['size']>2*1000*1000){
            return "err_size";
        }
        if(!self::validateExt($_FILES[$_name]['name'])){
            return "err_ext";
        }
        opendir(ROUTEFILES);
        $parts = explode(".",$_FILES[$_name]['name']);
        // con el final del explode que sería la extensión de la imagen
        $origen=  $_FILES[$_name]['tmp_name'];
        $destino= self::generateDirFile($parts );//ends obtiene el último valor del arreglo
        move_uploaded_file($origen, $destino);
        // $_FILES[$_name]['type']; tipo de archivo
        return  $destino;
    }
    public static function generateDirFile($parts ){
        $name_file="";
        do{
            $name_file=ROUTEFILES.self::generateRandomString(7). '.'.end($parts);
        }while(file_exists($name_file));
        return $name_file;
    }
    //generar nombre random
    private static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 
    // validar extención del archivo
    private static function validateExt( $nombre){
        $patron = "%\.(gif|jpe?g|png|svg)$%i"; 
        return preg_match($patron, $nombre) ;
    }
}