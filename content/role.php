<?php
$query = mysqli_query($config, "SELECT * FROM roles WHERE deleted_at = 0 ORDER BY id DESC");
//  12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5>
                    <div class="card-title">Data Roles</div>
                </h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-role" class="btn btn-primary">Add Roles</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name of Roles</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index += 1; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td>
                                        <a href="?page=tambah-role&add-role-menu=<?php echo $row['id'] ?>"
                                            class="btn btn-success">Add Role Menu</a>
                                        <a href="?page=tambah-role&edit=<?php echo $row['id'] ?>"
                                            class="btn btn-primary">Edit</a>
                                        <a onclick="return confirm('are you sure wanna delete this data')"
                                            href="?page=tambah-role&delete=<?php echo $row['id'] ?>"
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