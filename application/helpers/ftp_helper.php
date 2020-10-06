<?php 

function connect_ftpserver(){
    $ftp_server = "192.168.1.35";
    $ftp_user = "sigmu";
    $ftp_pass = "computos2020";
    // establecer una conexión
    $conn_id = ftp_connect($ftp_server); 
    // Luego creamos un login al mismo con nuestro usuario y contraseña
    $resultado = ftp_login($conn_id, $ftp_user, $ftp_pass);
    // Comprobamos que se creo el Id de conexión y se pudo hacer el login
    // Cambiamos a modo pasivo, esto es importante porque, de esta manera le decimos al 
    //servidor que seremos nosotros quienes comenzaremos la transmisión de datos.
    ftp_pasv ($conn_id, true);

    return $conn_id;
}

?>