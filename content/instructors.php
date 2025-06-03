<?php
$query = mysqli_query($config, "SELECT * FROM instructors WHERE deleted_at = 0 ORDER BY id DESC");
//  12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5>
                    <div class="card-title">Data Instructors</div>
                </h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-instructors" class="btn btn-primary">Add Instructors</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Fullname</th>
                                <th>Gender</th>
                                <th>education</th>
                                <th>phone</th>
                                <th>email</th>
                                <th>address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['gender'] == 1 ? '<span class="badge rounded-pill bg-primary">Laki-Laki</span>' : '<span class="badge rounded-pill bg-danger">Perempuan</span>' ?></td>
                                    <td><?php echo $row['education'] ?></td>
                                    <td><?php echo $row['phone'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $row['address'] ?></td>
                                    <td>
                                        <a href="?page=tambah-instructors&edit=<?php echo $row['id'] ?>"
                                            class="btn btn-primary">Edit</a>
                                        <a onclick="return confirm('are you sure wanna delete this data')"
                                            href="?page=tambah-instructors&delete=<?php echo $row['id'] ?>"
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