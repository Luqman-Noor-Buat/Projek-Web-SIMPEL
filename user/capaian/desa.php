<?php
	
    include "../../koneksi.php";
    $id_kec = $_POST['id_kec'];

    $sql = mysqli_query($conn, "SELECT * FROM desa WHERE ID_KEC='$id_kec'");
    while($row = mysqli_fetch_array($sql)){
        echo '<option value="'.$row['DESA'].'">'.$row['DESA'].'</option>';
    }

?>