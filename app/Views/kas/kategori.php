<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?= esc($title) ?></title>

    <meta name="description" content="Halaman manajemen kategori transaksi." />
    <meta name="keywords" content="kategori, transaksi, keuangan, dashboard" />
    <meta name="author" content="Your Name/Ircham Ali" />
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
        /* Essential styles for the layout to work */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevent body scroll, page-inner handles it */
        }
        main.page-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Ensure main content doesn't overflow its container */
        }
        .page-inner {
            flex-grow: 1;
            overflow-y: auto; /* Allows content within page-inner to scroll */
            padding-bottom: 20px; /* Add some padding at the bottom for better look */
        }
        .container-fluid, #main-wrapper {
            height: 100%;
        }
        /* Custom style for the panel background */
        .panel-white {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,.1); /* Optional: add a subtle shadow */
            margin-top: 20px; /* Add some top margin to separate from top bar */
        }
        /* Adjustments for form-inline responsiveness */
        .form-inline .form-control {
            margin-bottom: 10px; /* Spacing for smaller screens */
        }
        .table-responsive {
            overflow-x: hidden; /* default, tapi kita batasi lebarnya */
        }
        @media (min-width: 576px) {
            .form-inline .form-control {
                margin-bottom: 0;
            }
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
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-lg-12 panel-white">
                            <h2 class="text-center mb-4">Kategori Transaksi</h2>

                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <form action="<?= site_url('kas/kategori/tambah') ?>" method="post" class="form-inline mb-10 d-flex" style="margin-bottom: 40px; margin-top: 20px;">
                                <?= csrf_field() ?>
                                <input type="text" name="nama_kategori" class="form-control flex-grow-1 mr-2" placeholder="Masukkan kategori baru..." required>
                                <button type="submit" class="btn btn-primary" style="color: #fff;background-color: #22BAA0;border-color: transparent;"><i class="fa fa-plus"></i> Tambah</button>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th>Kategori</th>
                                            <th style="width: 20%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($kategori as $k) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($k['nama_kategori']) ?></td>
                                                <td>
                                                    <button
                                                        class="btn btn-warning btn-sm btn-edit"
                                                        data-id="<?= $k['id'] ?>"
                                                        data-nama="<?= esc($k['nama_kategori']) ?>"
                                                        data-toggle="modal"
                                                        data-target="#editModal"
                                                        title="Edit Kategori">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </button>
                                                    <a href="<?= site_url('kas/kategori/delete/' . $k['id']) ?>"
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                                       title="Hapus Kategori">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div> </div> </div> </div></div></div></main>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editForm" method="post" action="<?= site_url('kas/kategori/editKategori') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="editId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editNama">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="editNama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnUbah" class="btn btn-primary">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/backend/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="/assets/backend/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/backend/plugins/pace-master/pace.min.js"></script>
    <script src="/assets/backend/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="/assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/backend/plugins/switchery/switchery.min.js"></script>
    <script src="/assets/backend/plugins/uniform/jquery.uniform.min.js"></script>
    <script src="/assets/backend/plugins/classie/classie.js"></script>
    <script src="/assets/backend/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/backend/plugins/waves/waves.min.js"></script>
    <script src="/assets/backend/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/backend/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/backend/plugins/toastr/jquery.toast.min.js"></script>
    <script src="/assets/backend/plugins/datatables/js/jquery.datatables.min.js"></script>
    <script src="/assets/backend/js/modern.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Use a noConflict wrapper to ensure jQuery is correctly aliased to $
        (function($) {
            $(document).ready(function() { // Use $(document).ready for safety
                // 1) Initialize DataTables
                if ($.fn.DataTable) { // Check if DataTables is loaded
                    $('.datatable').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json" // Optional: Indonesian localization
                        }
                    });
                } else {
                    console.error("DataTables is not loaded. Check script order/paths.");
                }


                // 2) Populate modal when edit button is clicked
                $('.btn-edit').on('click', function() { // Use .on() for better event handling
                    const id = $(this).data('id');
                    const nama = $(this).data('nama');

                    console.log('Edit button clicked.');
                    console.log('Data ID:', id);
                    console.log('Data Nama:', nama);

                    // Ensure the values are set correctly
                    $('#editId').val(id);
                    $('#editNama').val(nama);

                    console.log('Modal hidden input #editId value:', $('#editId').val());
                    console.log('Modal text input #editNama value:', $('#editNama').val());

                    // Bootstrap's data-toggle should handle showing the modal,
                    // but you can manually show it if needed:
                    // $('#editModal').modal('show');
                });

                // 3) Handle "Ubah" button click with SweetAlert2 confirmation
                $('#btnUbah').on('click', function() {
                    const idToUpdate = $('#editId').val();
                    const namaToUpdate = $('#editNama').val();

                    if (!idToUpdate || !namaToUpdate) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'ID atau Nama Kategori tidak ditemukan. Mohon coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return; // Prevent submission if data is truly incomplete
                    }

                    Swal.fire({
                        title: 'Konfirmasi Perubahan',
                        text: `Ubah kategori menjadi "${namaToUpdate}"?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ubah!',
                        cancelButtonText: 'Batal'
                    }).then(res => {
                        if (res.isConfirmed) {
                            console.log('SweetAlert confirmed. Submitting form...');
                            $('#editForm').submit(); // Submit the form
                        } else {
                            console.log('SweetAlert cancelled.');
                        }
                    });
                });

                // 4) Clear modal fields when modal is hidden
                $('#editModal').on('hidden.bs.modal', function() {
                    $('#editId').val('');
                    $('#editNama').val('');
                    console.log('Modal closed. Fields reset.');
                });
            });
        })(jQuery); // Pass jQuery object to the wrapper function
    </script>
</body>
</html>