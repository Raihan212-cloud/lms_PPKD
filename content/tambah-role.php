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

if (isset($_GET['add-role-menu'])) {
    $id_role = $_GET['add-role-menu'];

    $rowEditRoleMenu = [];
    $editRoleMenu = mysqli_query($config, "SELECT * FROM menu_roles WHERE id_roles='$id_role'");
    while ($editMenu = mysqli_fetch_assoc($editRoleMenu)) {
        $rowEditRoleMenu[] = $editMenu['id_menu'];
    }

    $menus = mysqli_query($config, "SELECT * FROM menus ORDER BY parent_id, urutan");

    $rowmenus = [];
    while ($m = mysqli_fetch_assoc($menus)) {
        $rowmenus[] = $m;
    }
}

if (isset($_POST['save'])) {
    $id_role = $_GET['add-role-menu'];
    $id_menus = $_POST['id_menus'] ?? [];

    mysqli_query($config, "DELETE FROM menu_roles WHERE id_roles='$id_role'");
    foreach ($id_menus as $m) {
        $id_menu = $m;
        mysqli_query($config, "INSERT INTO menu_roles(id_roles, id_menu) VALUE('$id_roles','$id_menu')");
    }

    header("location:?page=tambah-role&add-role-menu=" . $id_roles . "&tambah=berhasil");
}

?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?>Modul</h5>
                <?php if (isset($_GET['add-role-menu'])): ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <ul>
                                <?php foreach ($rowmenus as $mainMenu): ?>
                                    <?php if ($mainMenu['parent_id'] == 0 or $mainMenu['parent_id'] == ""): ?>
                                        <li>
                                            <label for="">
                                                <!-- jika id value id_menu nilai nya 1 == jika nilai id_menu dari 
                                                 table menu_roles juga sama dengan -->
                                                <input <?php echo in_array($mainMenu['id'], $rowEditRoleMenu) ? 'checked' : '' ?> type="checkbox" name="id_menus[]"
                                                    value="<?php echo $mainMenu['id'] ?>">
                                                <?php echo $mainMenu['name'] ?>
                                            </label>
                                            <ul>
                                                <?php foreach ($rowmenus as $rowSubMenu): ?>
                                                    <?php if ($rowSubMenu['parent_id'] == $mainMenu['id']): ?>
                                                        <li>
                                                            <label for="">
                                                                <input <?php echo in_array($rowSubMenu['id'], $rowEditRoleMenu) ? 'checked' : '' ?> type="checkbox" name="id_menus[]"
                                                                    value="<?php echo $rowSubMenu['id'] ?>">
                                                                <?php echo $rowSubMenu['name'] ?>
                                                            </label>
                                                        </li>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </ul>
                                        </li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="save">Save Change</button>
                        </div>

                    </form>
                <?php elseif (isset($_GET['edit']) or empty($_GET['edit'])): ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Instructor Name *</label>
                            <input type="text" class="form-control"
                                name="name" value="<?php echo isset($rowEdit['name']) ? $rowEdit['name'] : '' ?>"
                                placeholder="Enter Your Role" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="Save">
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>