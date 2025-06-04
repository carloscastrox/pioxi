<?php
if (isset($_POST['iduser'])) {
    $delete = $conn->prepare('DELETE FROM user WHERE iduser = ?');
    $delete->bindParam(1, $_POST['iduser']);
    $delete->execute();

    if ($delete->rowCount() > 0) {
        $delmsg = array('Usuario eliminado correctamente', 'success');
    } else {
        $delmsg = array('No se pudo eliminar el usuario', 'danger');
    }
}
?>
<link rel="stylesheet" href="../assets/DataTables/datatables.min.css">

<!--Section alerts-->
<?php if (isset($delmsg)) { ?>
    <div class="alert alert-<?php echo $delmsg[1] ?> alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Alerta!</strong> <?php echo $delmsg[0] ?>.
    </div>
<?php } ?>
<!--Section alerts-->

<h2>Tabla de datos de usuarios</h2>
<table class="table table-striped table-bordered table-hover" id="tuser">
    <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Operaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $conn->prepare('SELECT * FROM user');
        $data->execute();
        //while($row = $data->fetch(PDO::FETCH_ASSOC)){ 

        foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['rol']; ?></td>
                <td>
                    <form action="" method="post">
                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i></button>
                    </form>
                    <form action="" method="post">
                        <input type="hidden" name="iduser" value="<?php echo $row['iduser']; ?>">
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script src="../assets/DataTables/datatables.min.js"></script>
<script>
    let table = new DataTable('#tuser', {
        responsive: true,
        language: {
            //url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' // via CDN
            url: '../assets/DataTables/es-ES.json' // via local
        },
    });
</script>