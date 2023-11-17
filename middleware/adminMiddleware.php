<?php
include_once '../functions/myfunctions.php';
if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] !=1)
     {
        redirect('../index.php', 'you are not authorized to this page', 'error');
    } 

} else {
    redirect('../login.php', 'you are not authorized to this page' , 'error');

}
