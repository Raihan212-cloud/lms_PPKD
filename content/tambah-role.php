<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE roles SET deleted_at = 1 WHERE id = '$id_user'");
    if ($queryDelete) {
        header("location:?page=role&hapus=berhasil");
    } else {
        header("location:?page=role&hapus=gagal");
    }
}

if (isset($_POST['name'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    $name = $_POST['name'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO roles (name) VALUES('$name')");
        header("location:?page=role&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE roles SET name = '$name' WHERE id ='$id_user'");
        header("location:?page=role&ubah=berhasil");
    }
}
?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($rowEdit['id']) ? 'Edit' : 'Add' ?>Roles</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Name Roles *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Your Roles" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>