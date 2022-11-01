<?php
require '../src/functions.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $person = select_one_from("contact", $id);

    if (isset($_GET['delete'])) {
        if (delete_one_from("contact", $id) > 0) {
            echo "<script>alert('Succesfully removing a contact from your contact list')</script>";
            header('Location: index.php');
            exit;
        } else {
            echo mysqli_error($conn);
        }
    }

    if (isset($_POST['submit-edit-contact'])) {
        $nama_depan = htmlspecialchars($_POST['nama-depan']);
        $nama_belakang = htmlspecialchars($_POST['nama-belakang']);
        $telepon = htmlspecialchars($_POST['telepon']);
        $email = htmlspecialchars($_POST['email']);

        $set_values = "nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', telepon = '$telepon', email = '$email'";

        if (edit_one_from("contact", $id, $set_values) > 0) {
            echo "<script>alert('This contact has been updated')</script>";
            header("Location: detail.php?id=$id");
            exit;
        } else {
            echo mysqli_error($conn);
        }
    }
} else {
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en" data-theme="forest">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Detail</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="font-poppins flex items-center justify-center h-screen">
    <main>
        <div class="flex items-center gap-2">
            <a href="index.php" class="btn btn-sm btn-accent btn-outline ">
                <img src="./img/back-arrow.svg" alt="return back" class="w-5">
            </a>

            <label for="delete-contact" class="btn btn-sm btn-accent">Delete</label>
        </div>

        <div class="my-5 ">
            <p class="text-xl p-3 border-b-2 border-r-2 border-white w-fit">
                <?=$person['nama_depan'] . ' ' . $person['nama_belakang']?></p>
            <p class="text-xl p-3 border-l-2 border-white ml-auto w-fit"><?=$person['telepon']?></p>
            <p class="text-xl p-3 border-t-2 border-r-2 border-white"><?=$person['email']?></->
        </div>

        <input type="checkbox" id="delete-contact" class="modal-toggle" />
        <div class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Are you sure you want to delete this contact?</h3>
                <div class="modal-action">
                    <a href="detail.php?id=<?=$person['id']?>&delete" class="btn btn-sm btn-error">delete</a>
                    <label for="delete-contact" class="btn btn-sm btn-error btn-outline">cancel</label>
                </div>
            </div>
        </div>

        <label for="edit-form" class="btn btn-sm btn-secondary mb-10">edit</label>

        <input type="checkbox" id="edit-form" class="modal-toggle" />
        <div class="modal modal-bottom sm:modal-middle ">
            <div class="modal-box ">
                <h3 class="font-bold text-lg mb-5">Edit Contact</h3>
                <form action="" method="post" class="flex flex-col gap-3">
                    <input type="text" placeholder="Nama Depan" class="input input-bordered w-full max-w-xs input-md"
                        value="<?=$person['nama_depan']?>" name="nama-depan" />
                    <input type="text" placeholder="Nama Belakang" class="input input-bordered w-full max-w-xs input-md"
                        value="<?=$person['nama_belakang']?>" name="nama-belakang" />
                    <input type="text" placeholder="Nomor Telepon" class="input input-bordered w-full max-w-xs input-md"
                        value="<?=$person['telepon']?>" name="telepon" />
                    <input type="text" placeholder="Email" class="input input-bordered w-full max-w-xs input-md"
                        value="<?=$person['email']?>" name="email" />
                    <div class="modal-action">
                        <input type="submit" value="edit" class="btn btn-sm btn-info" name="submit-edit-contact">
                        <label for="edit-form" class="btn btn-sm btn-info btn-outline">Draft</label>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>