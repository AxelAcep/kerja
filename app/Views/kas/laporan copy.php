<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= esc($title) ?></title>
    <link href="/assets/backend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/backend/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet"/>
    <style>.panel-white{background:#fff;padding:20px;border-radius:5px;}</style>
</head>
<body>

<?= $this->include('layout/sidebar-dashboard') ?>

<div class="container mt-4">
  <div class="panel-white">
    <h2 class="text-center mb-4">Kategori Transaksi</h2>

    <!-- Flashdata -->
    <?php if(session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <!-- Tambah Baru -->
    <form action="<?= site_url('kas/kategori/tambah') ?>" method="post" class="form-inline mb-4">
      <?= csrf_field() ?>
      <input type="text" name="nama_kategori" class="form-control mr-2" placeholder="Masukkan kategori..." required>
      <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
    </form>

    <!-- Tabel -->
    <table class="table table-bordered datatable">
      <thead class="thead-dark">
        <tr><th>No</th><th>Kategori</th><th>Aksi</th></tr>
      </thead>
      <tbody>
      <?php $no=1; foreach($kategori as $k): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= esc($k['nama_kategori']) ?></td>
          <td>
            <button
              class="btn btn-warning btn-sm btn-edit"
              data-id="<?= $k['id'] ?>"
              data-nama="<?= esc($k['nama_kategori']) ?>"
              data-toggle="modal"
              data-target="#editModal">
              <i class="fa fa-pencil"></i> Edit
            </button>
            <a href="<?= site_url('kas/kategori/delete/'.$k['id']) ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin ingin hapus?')">
              <i class="fa fa-trash"></i> Hapus
            </a>
          </td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" method="post" action="<?= site_url('kas/kategori/edit') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Kategori</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="editNama">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="editNama" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <!-- tombol type="button" agar JS selalu memutuskan kapan form submit -->
          <button type="button" id="btnUbah" class="btn btn-primary">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>


</body>
</html>
