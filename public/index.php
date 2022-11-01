<?php
require '../src/functions.php';

$contact = select_all_assoc("contact");

if (isset($_POST['submit-new-contact'])) {
    $nama_depan = htmlspecialchars($_POST['nama-depan']);
    $nama_belakang = htmlspecialchars($_POST['nama-belakang']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);

    $data_values = "'', '$nama_depan', '$nama_belakang', '$telepon', '$email'";

    if (insert_one_to("contact", $data_values) > 0) {
        echo "<script>
            alert('New Contact has been added to your contact list');
            window.location.href='index.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_GET['s'])) {
    $keyword = $_GET['s'];
    $like_values = "nama_depan LIKE '%$keyword%' OR nama_belakang LIKE '%$keyword%' OR telepon LIKE '%$keyword%' OR email LIKE '%$keyword%'";
    $contact = select_with_search_from("contact", $like_values);
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="forest">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Contact</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="font-poppins">
    <main class="container mx-auto max-w-6xl py-10">

        <div class="flex gap-4 mb-10">
            <label for="add-form" class="btn btn-sm btn-secondary ">New Contact</label>

            <div class="form-control">
                <div class="input-group input-group-sm">
                    <input type="text" id="search-input" placeholder="Search…" class="input input-bordered input-sm" />
                    <button id="search-btn" class="btn btn-square btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <script>
            const searchInput = document.querySelector('#search-input');
            const searchBtn = document.querySelector('#search-btn');

            searchBtn.addEventListener('click', _ => {
                const keyword = searchInput.value;
                window.location.href = `index.php?s=${keyword}`;
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key == 'Enter') {
                    const keyword = searchInput.value;
                    window.location.href = `index.php?s=${keyword}`;
                }
            })
            </script>
        </div>


        <input type="checkbox" id="add-form" class="modal-toggle" />
        <div class="modal modal-bottom sm:modal-middle ">
            <div class="modal-box">
                <h3 class="font-bold text-xl mb-5">New Contact</h3>
                <form action="" method="post" class="flex flex-col gap-3">
                    <input type="text" placeholder="Nama Depan" class="input input-bordered w-full max-w-xs input-md"
                        name="nama-depan" />
                    <input type="text" placeholder="Nama Belakang" class="input input-bordered w-full max-w-xs input-md"
                        name="nama-belakang" />
                    <input type="text" placeholder="Nomor Telepon" class="input input-bordered w-full max-w-xs input-md"
                        name="telepon" />
                    <input type="text" placeholder="Email" class="input input-bordered w-full max-w-xs input-md"
                        name="email" />
                    <div class="modal-action">
                        <input type="submit" value="add" class="btn btn-sm btn-secondary" name="submit-new-contact">
                        <label for="add-form" class="btn btn-sm btn-secondary btn-outline">Draft</label>
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach ($contact as $person): ?>
                    <tr>
                        <th><?=$no?></th>
                        <td><?=$person['nama_depan'] . ' ' . $person['nama_belakang']?></td>
                        <td>+62 <?=$person['telepon']?></td>
                        <td><?=$person['email']?></td>
                        <td><a href="detail.php?id=<?=$person['id']?>"
                                class="btn btn-outline btn-accent btn-sm">detail</a></td>
                    </tr>
                    <?php $no++;?>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>