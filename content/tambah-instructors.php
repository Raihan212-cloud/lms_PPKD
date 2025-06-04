<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE instructors SET deleted_at = 1 WHERE id = '$id_user'");
    if ($queryDelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}

if (isset($_POST['name'])) {
    // ada tidak parameter bernama edit, kalo ada jalankan perintah eit/update, kalo tidak ada
    // tambah data baru / insert
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO instructors (name, gender, education, phone, email, address) 
        VALUES('$name','$gender','$education','$phone','$email','$address')");
        header("location:?page=user&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE instructors SET name = '$name', gender = '$gender', education = '$education', phone = '$phone',
         email = '$email', address = '$address', WHERE id ='$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}
?>
<div class="row">
    <div class="col sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Instructors</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Fullname *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Your Name" required>
                    </div>
                    <div class="Gender">
                        <label for="">Gender</label>
                        <br>
                        <input class="form-check-input" type="radio" name="gender" id="radioDefault1" value="1">
                        <label class="form-check-label" for="radioDefault1">
                            Cowo
                        </label>
                        <br>
                        <input class="form-check-input" type="radio" name="gender" id="radioDefault2" value="0" checked>
                        <label class="form-check-label" for="radioDefault2">
                            Cewe
                        </label>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="">Education *</label>
                        <input type="text" class="form-control" name="education" placeholder="Enter Your last education" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Phone *</label>
                        <input type="number" class="form-control" name="phone" placeholder="Enter Your Phone Number" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="Email" class="form-control" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Address *</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter Your Address" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>