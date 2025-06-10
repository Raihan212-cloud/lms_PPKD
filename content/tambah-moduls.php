<?php

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $queryModulsDetails = mysqli_query($config, "SELECT file FROM moduls_details WHERE id_modul='$id'");
    $rowModulsDetails = mysqli_fetch_assoc($queryModulsDetails);
    unlink("uploads/" . $rowModulsDetails['file']);

    $queryDelete = mysqli_query($config, "DELETE FROM moduls_details WHERE id_modul = '$id'");
    $queryDelete = mysqli_query($config, "DELETE FROM moduls WHERE id = '$id'");
    if ($queryDelete) {
        header("location:?page=moduls&hapus=berhasil");
    } else {
        header("location:?page=moduls&hapus=gagal");
    }
}

if (isset($_POST['save'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    // $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
    $id_instructor = $_POST['id_instructors'];
    $id_major = $_POST['id_majors'];
    $name = $_POST['name'];

    $insert = mysqli_query($config, "INSERT INTO moduls (id_instructors, id_majors, name) 
    VALUES ('$id_instructor', '$id_major', '$name')");

    if ($insert) {
        $id_modul = mysqli_insert_id($config);
        // $_FILES
        foreach ($_FILES['file']['name'] as $index => $file) {
            if ($_FILES['file']['name'][$index] == 0) {
                $name = basename($_FILES['file']['name'][$index]);
                $fileName = uniqid() . "-" . $name;
                $path = "uploads/";
                $targetPath = $path . $fileName;

                if (move_uploaded_file($_FILES['file']['tmp_name'][$index], $targetPath)) {
                    $insertModulDetail = mysqli_query($config, "INSERT INTO moduls_details 
                (id_modul,file) VALUES ('$id_modul','$fileName')");
                }
            }
        }
        header("location:?page=moduls&tambah=berhasil");
    }
}

$id_instructors = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryInstructorsMajor = mysqli_query($config, "SELECT majors.name, instructors_majors.* 
FROM instructors_majors LEFT JOIN majors ON majors.id = instructors_majors.id_majors 
WHERE instructors_majors.id_instructors = '$id_instructors'");

$rowInstructorsMajors = mysqli_fetch_all($queryInstructorsMajor, MYSQLI_ASSOC);

$id_modul = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryModul = mysqli_query($config, "SELECT majors.name AS majors_name, 
instructors.name AS instructors_name, moduls.* 
FROM moduls
LEFT JOIN majors ON majors.id = moduls.id_majors
LEFT JOIN instructors ON instructors.id = moduls.id_instructors");
$rowModul = mysqli_fetch_assoc($queryModul);

$queryDetailModul = mysqli_query($config, "SELECT * FROM moduls_details WHERE id_modul ='$id_modul'");
$rowDetailModul = mysqli_fetch_all($queryDetailModul, MYSQLI_ASSOC);

if (isset($_GET['download'])) {
    $file = $_GET['download'];
    $filepath = "uploads/" . $file;
    if (file_exists($filepath)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . basename($filePath));
        header("Expires:0");
        header("Cache-Control: must-revalidate");
        header('pragma: public');
        header('Content-Length: ' . filesize($filepath));
        ob_clean();
        flush();
        readfile($filepath);
        exit;
    }
}
?>

<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['detail']) ? 'Edit' : 'Add' ?> Modul</h5>

                <?php if (isset($_GET['detail'])): ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Modul Name</th>
                            <th>:</th>
                            <td><?php echo $rowModul['name'] ?></td>
                        </tr>
                        <tr>
                            <th>Major</th>
                            <th>:</th>
                            <td><?php echo $rowModul['majors_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Instructor</th>
                            <th>:</th>
                            <td><?php echo $rowModul['instructors_name'] ?></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>file Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowDetailModul as $index => $rowDetailModul): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td>
                                        <a target="_blank" href="?page=tambah-moduls&download=<?php echo urlencode($rowDetailModul['file']) ?>">
                                            <?php echo $rowDetailModul['file'] ?> <i class="bi bi-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                <?php else: ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Instructor Name *</label>
                                    <input readonly value="<?php echo $_SESSION['NAME'] ?>" type="text" class="form-control">
                                    <input type="hidden" name="id_instructors" value=" <?php echo $_SESSION['ID_USER'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Moduls Name *</label>
                                    <input type="text" name="name" value="" placeholder="Enter Modul Name" class="form-control" required>
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

                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-primary addRow" id="addRow">+ Row</button>
                            </div>

                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="Save">
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>

    <script>
        const button = document.querySelector('.addRow');
        const tbody = document.querySelector('#myTable tbody');

        button.addEventListener("click", function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td><input type='file' name='file[]'></td>
            <td>Delete</td>`;
            tbody.appendChild(tr);
        })

        // button.addEventListener("click", function() {
        //     const tr = document.createdElement('tr');
        //     tr.innerHTML =
        //         `<td><input type='file' name='file[]'></td>
        //         <td>Delete</td>`;

        //     tbody.appendChild(tr);
        // })
    </script>