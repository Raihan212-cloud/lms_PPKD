<?php
$id_user = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$id_role = isset($_SESSION['ID_ROLE']) ? $_SESSION['ID_ROLE'] : '';

$rowStudents = mysqli_fetch_assoc(mysqli_query($config, "SELECT * FROM students WHERE id='$id_user'"));
$id_major = isset($rowStudents['id_major']) ? $rowStudents['id_major'] : '';

if ($id_role == 5) {
    $where = "WHERE moduls.id_majors='$id_major'";
} elseif ($id_role == 1) {
    $where = "WHERE moduls.id_instructors='$id_user'";
}
$query = mysqli_query($config, "SELECT majors.name AS majors_name, 
instructors.name AS instructors_name, moduls.* 
FROM moduls
LEFT JOIN majors ON majors.id = moduls.id_majors
LEFT JOIN instructors ON instructors.id = moduls.id_instructors
WHERE moduls.id_instructors ='$id_user'
ORDER BY moduls.id DESC");
//  12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
// die;
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5>
                    <div class="card-title">Data Modul</div>
                </h5>
                <?php if (canAddModul(1)): ?>
                    <div class="mb-3" align="right">
                        <a href="?page=tambah-moduls" class="btn btn-primary">Add Modul</a>
                    </div>
                <?php endif ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Instructor Name</th>
                                <th>Majors</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td>
                                        <a href="?page=tambah-moduls&detail=<?php echo $row['id'] ?>"><i class="bi bi-link"></i>
                                            <?php echo $row['name'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row['instructors_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['majors_name'] ?>
                                    </td>

                                    <td>
                                        <a href="?page=tambah-moduls&edit=<?php echo $row['id'] ?>"
                                            class="btn btn-primary">Edit</a>
                                        <a onclick="return confirm('are you sure wanna delete this data')"
                                            href="?page=tambah-moduls&delete=<?php echo $row['id'] ?>"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>