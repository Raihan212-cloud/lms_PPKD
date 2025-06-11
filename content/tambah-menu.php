<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE menus WHERE id = '$id_user'");
    if ($queryDelete) {
        header("location:?page=menu&hapus=berhasil");
    } else {
        header("location:?page=menu&hapus=gagal");
    }
}

if (isset($_POST['name'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $urutan = $_POST['urutan'];
    $url = $_POST['url'];
    $parent_id = $_POST['parent_id'];


    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO menus (name, parent_id, icon, url, urutan) VALUES('$name','$parent_id','$icon','$url','$urutan')");
        header("location:?page=menu&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE menus SET 
        name = '$name'
        parent_id = '$parent_id'
        icon = '$icon'
        url = '$url'
        urutan = '$urutan'
        WHERE id ='$id_user'");
        header("location:?page=menu&ubah=berhasil");
    }
}

$queryParentId = mysqli_query(
    $config,
    "SELECT * FROM menus WHERE parent_id = 0 OR parent_id=''"
);
$rowParentId = mysqli_fetch_all($queryParentId, MYSQLI_ASSOC);

?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?>Menu</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Name *</label>
                        <input type="text" class="form-control" name="name" value="<?php echo isset($rowEdit['name']) ? $rowEdit['name'] : '' ?>"
                            placeholder="Enter Name menu" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Parent Id *</label>
                        <select name="parent_id" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowParentId as $parentId): ?>
                                <option value="<?php echo $parentId['id'] ?>">
                                    <?php echo $parentId['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">icon *</label>
                        <input type="text" class="form-control" name="icon" value="<?php echo isset($rowEdit['icon']) ? $rowEdit['icon'] : '' ?>"
                            placeholder="Enter Icon menu" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Url </label>
                        <input type="text" class="form-control" name="url" value="<?php echo isset($rowEdit['url']) ? $rowEdit['url'] : '' ?>"
                            placeholder="Enter Url menu">
                    </div>
                    <div class="mb-3">
                        <label for="">Order</label>
                        <input type="number" class="form-control" name="urutan" value="<?php echo isset($rowEdit['urutan']) ? $rowEdit['urutan'] : '' ?>"
                            placeholder="Enter Order menu">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>