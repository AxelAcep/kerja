<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?= $title; ?></title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Ircham Ali" />
    <link rel="shortcut icon" href="/assets/frontend/img/apple-touch-icon.png" />

    <link href="/assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/uniform/css/uniform.default.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/line-icons/simple-line-icons.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/waves/waves.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/slidepushmenus/css/component.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/backend/plugins/toastr/jquery.toast.min.css" rel="stylesheet" />
    <link href="/assets/backend/css/modern.min.css" rel="stylesheet" />
    <link href="/assets/backend/css/themes/dark.css" class="theme-color" rel="stylesheet" />
    <link href="/assets/backend/css/custom.css" rel="stylesheet" />
    <link href="/assets/backend/css/dropify.min.css" rel="stylesheet" />

    <style>
        html, body {
            height: 900%;
            margin: 0;
            padding: 0;
        }
        main.page-content {
            height: 90%;
            display: flex;
            flex-direction: column;
        }
        .page-inner {
            flex-grow: 1;
            overflow-y: auto;
        }
        .container-fluid, #main-wrapper {
            height: 90%;
        }
    </style>
</head>

<body class="page-header-fixed compact-menu page-sidebar-fixed">
    <div class="overlay"></div>

    <?= $this->include('layout/sidebar-dashboard'); ?>

    <main class="page-content content-wrap">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">

                                    <?php if (session()->getFlashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                                            <?= session()->getFlashdata('success'); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <h2 class="mb-1" style="margin-bottom:25px;">Pengeluaran Kas</h2>
                                    <form id="form-kurang-kas" class="form-inline" method="post" action="kurang/data">
                                        <?= csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px;">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" required />
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px; padding-left: 5px;">
                                                <label for="kategori">Kategori</label>
                                                <select class="form-control" id="kategori" name="kategori" required>
                                                    <option value="">Pilih Kategori</option>
                                                    <?php foreach ($kategori as $cat): ?>
                                                        <option value="<?= esc($cat['nama_kategori']); ?>">
                                                            <?= esc($cat['nama_kategori']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Kurang Kas</button>
                                    </form>
                                    <hr />

                                    <div class="table-responsive">
                                        <table id="kas-table" class="display table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                    <th>User</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-table">
                                                <?php $no = 1; foreach ($kas_pengeluaran as $kas): ?>
                                                <tr>
                                                    <td><?= $kas['kode_kas']; ?></td>
                                                    <td><?= $kas['kategori']; ?></td>
                                                    <td><?= number_format($kas['jumlah']); ?></td>
                                                    <td><?= date('d-m-Y', strtotime($kas['tanggal'])); ?></td>
                                                    <td><?= $kas['user_id']; ?></td>

                                                    <td style="text-align: center;">
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $kas['kode_kas']; ?>">
                                                            Edit
                                                        </button>

                                                        <a href="/kas/pengeluaran/delete/<?= $kas['kode_kas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                            Delete
                                                        </a>
                                                    </td>

                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php foreach ($kas_pengeluaran as $kas): ?>
                                            <div class="modal fade" id="editModal<?= $kas['kode_kas']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $kas['kode_kas']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="/kas/pengeluaran/edit/<?= $kas['kode_kas']; ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $kas['kode_kas']; ?>">Edit Data Kas</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Kategori</label>
                                                        <select name="kategori" class="form-control" required>
                                                            <?php foreach ($kategori as $cat): ?>
                                                                <option value="<?= esc($cat['nama_kategori']); ?>"
                                                                    <?= ($cat['nama_kategori'] == $kas['kategori']) ? 'selected' : ''; ?>>
                                                                    <?= esc($cat['nama_kategori']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah</label>
                                                        <input type="number" name="jumlah" class="form-control" value="<?= $kas['jumlah']; ?>" required />
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div></div></div></div></main>

    <script src="/assets/backend/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="/assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/backend/plugins/datatables/js/jquery.datatables.min.js"></script>
    <script src="/assets/backend/plugins/toastr/jquery.toast.min.js"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/classie.js"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
    <script src="/assets/backend/plugins/offcanvasmenueffects/js/main.js"></script>
    <script src="/assets/backend/plugins/waves/waves.min.js"></script>
    <script src="/assets/backend/js/modern.min.js"></script>

    <script>
        const table = $('#kas-table').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "pagingType": "simple",
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
                "info": "MENAMPIL _START_ - _END_ DARI _TOTAL_ ENTRI",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                }
            }
        });
        $(document).ready(function () {
            // Inisialisasi DataTable sudah dilakukan di luar document.ready atau bisa dihapus salah satunya jika double
            // Yang di dalam document.ready ini sepertinya duplikat, bisa dihapus salah satu. Saya akan hapus yang di luar document.ready.
            // const table = $('#kas-table').DataTable({ // <-- Hapus ini jika di luar document.ready sudah ada
            //     "pageLength": 10,
            //     "lengthChange": false,
            //     "pagingType": "simple",
            //     "language": {
            //         "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
            //         "info": "MENAMPIL _START_ - _END_ DARI _TOTAL_ ENTRI",
            //         "paginate": {
            //             "previous": "Sebelumnya",
            //             "next": "Berikutnya"
            //         }
            //     }
            // });

            // Event submit form tambah kas dengan AJAX
            $('#form-kurang-kas').on('submit', function (e) {
                e.preventDefault();

                const jumlah = $('#jumlah').val();
                // Kategori sekarang adalah nilai dari <select>
                const kategori = $('#kategori').val();
                const csrfName = $('input[name^="csrf_"]').attr('name');
                const csrfToken = $('input[name^="csrf_"]').val();

                $.ajax({
                    url: '/kas/kurang/data',
                    type: 'POST',
                    data: {
                        jumlah: jumlah,
                        kategori: kategori, // Ini akan mengirim nilai terpilih dari select
                        [csrfName]: csrfToken
                    },
                    success: function (res) {
                        if (res.success && res.html) {
                            // Mengganti seluruh #main-wrapper bisa menyebabkan DataTable ter-render ulang
                            // Ini mungkin penyebab DataTable tidak berfungsi dengan baik setelah AJAX.
                            // Lebih baik perbarui hanya body tabelnya.
                            // $('#main-wrapper').html(res.html); // Pertimbangkan untuk tidak menggunakan ini

                            $.toast({
                                heading: 'Berhasil',
                                text: 'Pengeluaran kas berhasil dikurangkan.',
                                icon: 'success',
                                position: 'top-right',
                                showHideTransition: 'slide'
                            });

                            // Karena Anda memuat ulang seluruh #main-wrapper di success,
                            // maka DataTable harus di-inisialisasi ulang.
                            // Namun, jika Anda mengubah ke pembaruan tabel secara dinamis,
                            // Anda mungkin tidak perlu baris ini.
                            // Jika Anda tetap ingin memuat ulang seluruh kontainer,
                            // pastikan untuk menghancurkan instance DataTable yang lama sebelum inisialisasi baru.
                            $('#kas-table').DataTable().destroy(); // Hancurkan instance yang lama
                            $('#kas-table').DataTable({
                                "pageLength": 10,
                                "lengthChange": false,
                                "language": {
                                    "paginate": {
                                        "previous": "Sebelumnya",
                                        "next": "Berikutnya"
                                    },
                                    "info": "MENAMPIL _START_ - _END_ DARI _TOTAL_ ENTRI",
                                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                                },
                                // destroy: true // ini sudah ada di atas
                            });

                            // Jika Anda ingin memperbarui tabel secara dinamis tanpa reload semua,
                            // Anda harus mendapatkan data baru dari respons dan menambahkannya ke tabel.
                            // Ini akan lebih kompleks tapi UX lebih baik.
                            // Misalnya:
                            // table.row.add([
                            //     res.newData.kode_kas,
                            //     res.newData.kategori,
                            //     res.newData.jumlah,
                            //     res.newData.tanggal,
                            //     res.newData.user_id,
                            //     '<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal' + res.newData.kode_kas + '">Edit</button> <a href="/kas/pengeluaran/delete/' + res.newData.kode_kas + '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Delete</a>'
                            // ]).draw(false);
                            // Lalu kosongkan form: $('#form-kurang-kas')[0].reset();

                        } else {
                            $.toast({
                                heading: 'Error',
                                text: res.message || 'Gagal menambahkan data. HTML tidak diterima.',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right'
                            });
                        }
                    },
                    error: function (xhr) {
                        let errMsg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            errMsg = 'Respons server: ' + xhr.responseText.substring(0, 100) + '...';
                        }
                        $.toast({
                            heading: 'Error',
                            text: errMsg,
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>