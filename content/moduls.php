<?php
$query = mysqli_query($config, "SELECT majors.name AS majors_name, 
instructors.name AS instructors_name, moduls.* 
FROM moduls
LEFT JOIN majors ON majors.id = moduls.id_majors
LEFT JOIN instructors ON instructors.id = moduls.id_instructors
ORDER BY moduls.id DESC");
//  12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5>
                    <div class="card-title">Data Modul</div>
                </h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-moduls" class="btn btn-primary">Add Modul</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instructor Name</th>
                                <th>Majors</th>
                                <th>Nama Anda</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td><?php echo $row['instructor_name'] ?></td>
                                    <td><?php echo $row['major_name'] ?></td>
                                    <td><?php echo $row['name'] ?></td>

                                    <td>
                                        <a href="?page=tambah-moduls&id=<?php echo $row['id'] ?>"
                                            class="btn btn-warning">Add Moduls</a>
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