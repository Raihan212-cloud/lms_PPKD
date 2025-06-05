<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE majors SET deleted_at = 1 WHERE id = '$id_user'");
    if ($queryDelete) {
        header("location:?page=major&hapus=berhasil");
    } else {
        header("location:?page=major&hapus=gagal");
    }
}

if (isset($_POST['name'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    $name = $_POST['name'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO majors (name) VALUES('$name')");
        header("location:?page=major&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE majors SET name = '$name' WHERE id ='$id'");
        header("location:?page=major&ubah=berhasil");
    }
}

$id_instructors = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryInstructorsMajor = mysqli_query($config, "SELECT majors.name, instructors_majors.* 
FROM instructors_majors LEFT JOIN majors ON majors.id = instructors_majors.id_majors 
WHERE instructors_majors.id_instructors = '$id_instructors'");

$rowInstructorsMajors = mysqli_fetch_all($queryInstructorsMajor, MYSQLI_ASSOC);

?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add major</h5>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Instructor Name *</label>
                                <input readonly value="<?php echo $_SESSION['NAME'] ?>" type="text" class="form-control">
                                <input type="hidden" name="id_instructors" value=" <?php echo $_SESSION['ID_USER'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Major Name *</label>
                                <select name="id_majors" id="" class="form-control">
                                    <option value="">Select One</option>
                                    <?php foreach ($rowInstructorsMajors as $row): ?>
                                        <option value="<?php echo $row['id_majors'] ?>"><?php echo $row['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>