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

                                    <h2 class="mb-1" style="margin-bottom:25px;">Pengeluaran Kas</h2>
                                    <!-- Form Input -->
                                    <form class="form-inline" method="post" action="#">
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
                                        <button type="submit" class="btn btn-success">Kurang Kas</button>
                                    </form>

                                    <hr />

                                    <!-- Tabel Data Kas -->
                                    <div class="table-responsive">
                                        <table id="kas-table" class="display table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                    <th>User ID</th>
                                                    <th>Kategori</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach($kas_pemasukan as $item): ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= number_format($item['jumlah'], 0, ',', '.'); ?></td>
                                                        <td><?= date('d-m-Y', strtotime($item['tanggal'])); ?></td>
                                                        <td><?= esc($item['user_id']); ?></td>
                                                        <td><?= esc($item['kategori']); ?></td>
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
                    <footer class="page-footer text-center">
                        <p class="no-s"><?= date('Y'); ?> &copy; Powered by Ircham Ali.</p>
                    </footer>

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
        <?php if (session()->getFlashdata('success')) : ?>
            $.toast({
                heading: 'Sukses',
                text: '<?= session()->getFlashdata('success'); ?>',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-right'
            });
        <?php endif; ?>
    </script>

</body>

</html>
