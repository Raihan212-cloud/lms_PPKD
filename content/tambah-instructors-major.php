<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $id_instructors = $_GET['id'];

    $queryDelete = mysqli_query($config, "DELETE FROM instructors_majors WHERE id = '$id'");
    if ($queryDelete) {
        header("location:?page=tambah-instructors-major&id=" . $id_instructors . "hapus=berhasil");
    } else {
        header("location:?page=tambah-instructors-major&id=" . $id_instructors . "hapus=gagal");
    }
}


$id = isset($_GET['id']) ? $_GET['id'] : '';
$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM instructors_majors ORDER BY id DESC");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['id_majors'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    $id_majors = $_POST['id_majors'];
    if (isset($_POST['edit'])) {
        $update = mysqli_query($config, "UPDATE instructors_majors SET id_majors='$id_majors' WHERE id='$edit'");
        header("location:?page=tambah-instructors-major&id=" . $id . "&ubah=berhasil");
    } else {

        $insert = mysqli_query($config, "INSERT INTO instructors_majors (id_majors, id_instructors) 
            VALUES('$id_majors','$id')");
        header("location:?page=tambah-instructors-major&id=" . $id . "&tambah=berhasil");
    }
}


$queryMajor = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowMajor = mysqli_fetch_all($queryMajor, MYSQLI_ASSOC);

$queryInstructors = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id'");
$rowInstructors = mysqli_fetch_assoc($queryInstructors);

$queryInstructorsMajor = mysqli_query($config, "SELECT majors.name AS m_name, instructors_majors.id, instructors_majors.id_instructors FROM instructors_majors 
LEFT JOIN majors ON majors.id = instructors_majors.id_majors WHERE instructors_majors.id_instructors = '$id' ORDER BY instructors_majors.id DESC");
$rowInstructorsMajors = mysqli_fetch_all($queryInstructorsMajor, MYSQLI_ASSOC);
// print_r($rowInstructorsMajors);
// die;



// print_r($rowInstructorsMajors);
// die;

?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Instructors Major : <?php echo $rowInstructors['name'] ?></h5>
                <div align="right">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Instructor Major
                    </button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Major Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($rowInstructorsMajors as $index => $rowInstructorsMajor): ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $rowInstructorsMajor['m_name'] ?></td>
                                <td>
                                    <a onclick="return confirm('are you sure wanna delete this data')"
                                        href="?page=tambah-instructors-major&id=<?= $rowInstructorsMajor['id_instructors'] ?>&delete=<?php echo $rowInstructorsMajor['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Instructor Major</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Major Name</label>
                        <select name="id_majors" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowMajor as $rowMajor): ?>
                                <option value="<?php echo $rowMajor['id'] ?>"> <?php echo $rowMajor['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>