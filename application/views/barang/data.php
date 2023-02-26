<?php error_reporting(0); ?>
<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Inventory
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barang/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Add Item
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
                    <th>ID Barang</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga Barang(Rp)</th>
                    <th>Total Harga Barang(Rp)</th>
                    <th>Gudang</th>
                       <?php if (is_admin()) : ?>
                    <th>Aksi</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $tot_bayar = 0;
                if ($barang) :
                    foreach ($barang as $b) :
                        $total = $b['harga_barang'] * $b['stok'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $b['id_barang']; ?></td>
                            <td><?php if($b['image'] != null) { ?>
                            <?php echo "<img src='assets/upload/$b[image]' width='80px'  />";?>
                            <?php } ?>
                            </td>
                            <td><?= $b['nama_barang']; ?></td>
                            <td><?= $b['nama_jenis']; ?></td>
                            <td><?= $b['stok']; ?></td>
                            <td><?= $b['nama_satuan']; ?></td>
                             <td><?php echo number_format($b['harga_barang'])  ?></td>
                             <td><?php echo number_format($total)  ?></td>
                             <td><?= $b['nama_gudang']; ?></td>
                              <?php if (is_admin()) : ?>
                            <td>
                                <a href="<?= base_url('barang/edit/') . $b['id_barang'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                 
                                    <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/delete/') . $b['id_barang'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>  <?php endif; ?>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>