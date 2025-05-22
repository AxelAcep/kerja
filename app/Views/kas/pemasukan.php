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

    <!-- Styles -->
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

    <!-- Sidebar -->
    <?= $this->include('layout/sidebar-dashboard'); ?>

    <!-- Main Content -->
    <main class="page-content content-wrap">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="container-fluid">

                    <!-- Card Panel -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">

                                    <h2 class="mb-1" style="margin-bottom:25px;">Pemasukan Kas</h2>
                                    <!-- Form Input -->
                                    <form id="form-tambah-kas" class="form-inline" method="post" action="tambah/data">
                                        <?= csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px;">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" required />
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-bottom: 15px; padding-left: 5px;">
                                                <label for="kategori">Kategori</label>
                                                <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan kategori" required />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Tambah Kas</button>
                                    </form>
                                    <hr />

                                    <!-- Tabel Data Kas -->
                                    <div class="table-responsive">
                                        <table id="kas-table" class="display table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                    <th>User</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-table">
                                                <?php $no = 1; foreach ($kas_pemasukan as $kas): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $kas['kategori']; ?></td>
                                                    <td><?= number_format($kas['jumlah']); ?></td>
                                                    <td><?= date('d-m-Y', strtotime($kas['tanggal'])); ?></td>
                                                    <td><?= $kas['user_id']; ?></td>
                                                    <td style="text-align: center;">
                                                        <!-- action buttons here -->
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->

                    <!-- Footer -->


                </div><!-- /.container-fluid -->
            </div><!-- /#main-wrapper -->
        </div><!-- /.page-inner -->
    </main>

    <!-- Scripts -->
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

    <!-- Toastr Flash Message -->
    <script>
    const table = $('#kas-table').DataTable({
        "pageLength": 10,       // maksimal 10 baris per halaman
        "lengthChange": false,  // sembunyikan dropdown jumlah baris
        "pagingType": "simple", // hanya Previous dan Next tombol
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
    // Inisialisasi DataTable dengan opsi bahasa Indonesia dan konfigurasi lainnya
    const table = $('#kas-table').DataTable({
        "pageLength": 10,       // maksimal 10 baris per halaman
        "lengthChange": false,  // sembunyikan dropdown jumlah baris
        "pagingType": "simple", // hanya tombol Previous dan Next
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
            "info": "MENAMPIL _START_ - _END_ DARI _TOTAL_ ENTRI",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Berikutnya"
            }
        }
    });

    // Event submit form tambah kas dengan AJAX
    $('#form-tambah-kas').on('submit', function (e) {
                e.preventDefault();

                const jumlah = $('#jumlah').val();
                const kategori = $('#kategori').val();
                const csrfName = $('input[name^="csrf_"]').attr('name');
                const csrfToken = $('input[name^="csrf_"]').val();

                $.ajax({
                    url: '/kas/tambah/data',
                    type: 'POST',
                    data: {
                        jumlah: jumlah,
                        kategori: kategori,
                        [csrfName]: csrfToken
                    },
                    success: function (res) {
                        if (res.success && res.html) {
                            $('#main-wrapper').html(res.html);

                            $.toast({
                                heading: 'Berhasil',
                                text: 'Pemasukan kas berhasil ditambahkan.',
                                icon: 'success',
                                position: 'top-right',
                                showHideTransition: 'slide'
                            });

                            // Re-init DataTable setelah konten diganti
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
                                destroy: true
                            });
                        }
                    },
                    error: function (xhr) {
                        let errMsg = 'Gagal menambahkan data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
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
