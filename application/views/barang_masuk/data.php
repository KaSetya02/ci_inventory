<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Hystory of Incoming Goods
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangmasuk/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Item
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive " id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                     <th>Foto Supplier</th>
                    <th>Supplier</th>
                    <th>Gambar Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>User</th>
                    <?php if (is_admin()) : ?><th>Hapus</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        $total += $bm['jumlah_masuk'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['id_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?php if($bm['foto'] != null) { ?>
                            <?php echo "<img src='assets/img/avatar/$bm[foto]' width='70px' style='border: 3px solid #333333;' />";?>
                            <?php } ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?php if($bm['image'] != null) { ?>
                            <?php echo "<img src='assets/upload/$bm[image]' width='70px'  />";?>
                            <?php } ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['jumlah_masuk'] . ' ' . $bm['nama_satuan']; ?></td>
                            <td><?= $bm['nama']; ?></td>
                              <?php if (is_admin()) : ?><td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangmasuk/delete/') . $bm['id_barang_masuk'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td><?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>