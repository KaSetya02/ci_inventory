<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Supplier
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('supplier/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Add Supplier
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Supplier</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($supplier) :
                    $no = 1;
                    foreach ($supplier as $s) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $s['supplier']; ?></td>
                             <td><?php if($s['foto'] != null) { ?>
                            <?php echo "<img src='assets/img/avatar/$s[foto]' width='60px' style='border: 3px solid #333333;'/>";?>
                            <?php } ?>
                            </td>
                            <td><?= $s['nama_supplier']; ?></td>
                            <td><?= $s['no_telp']; ?></td>
                            <td><?= $s['alamat']; ?></td>
                            <th>
                                <a href="<?= base_url('supplier/edit/') . $s['id_supplier'] ?>" class="btn btn-circle btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('supplier/delete/') . $s['id_supplier'] ?>" class="btn btn-circle btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>