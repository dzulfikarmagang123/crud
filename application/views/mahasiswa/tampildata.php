<main>
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <?= form_open('mahasiswa/deletemultiple', ['class' => 'formhapus']) ?>
            <div class="card-header">
                <button type="button" class="btn btn-dark" id="tomboltambah"><i class="fas fa-plus-circle"></i></button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </div>
            <div class="card-body">
                <table id="datamahasiswa">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="centangSemua">
                            </th>
                            <th>No</th>
                            <th>NOBP</th>
                            <th>Nama Indi Ramadhan</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl.Lahir</th>
                            <th>Jenkel</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <div class="viewmodal" style="display: none;"></div>
</main>
<!-- Function -->
<script type="text/javascript">
    function datamahasiswa() {
        $('#datamahasiswa').DataTable({
            responsive: true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('mahasiswa/ambildata'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "width": 5
            }],
        });
    }
    $(document).ready(function() {
        $('#centangSemua').click(function(e) {
            if ($(this).is(":checked")) {
                $('.centangNobp').prop('checked', true);
            } else {
                $('.centangNobp').prop('checked', false);
            }
        });
        datamahasiswa();
        $('#tomboltambah').click(function(e) {
            $.ajax({
                url: "<?= site_url('mahasiswa/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        $('.viewmodal').html(response.sukses).show();
                        $('#modaltambah').on('shown.bs.modal', function(e) {
                            $('#nobp').focus();
                        })
                        $('#modaltambah').modal('show');
                    }
                }
            });
        });
        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangNobp:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Maaf tidak ada yang bisa dihapus, silahkan dicentang !'
                })
            } else {
                Swal.fire({
                    title: 'Hapus Data',
                    text: `Ada ${jmldata.length} data mahasiswa yang akan dihapus, yakin ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.sukses
                                    })
                                    datamahasiswa();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        });
                    }
                })
            }
            return false;
        });
    });

    function edit(nobp) {
        $.ajax({
            type: 'post',
            url: "<?= site_url('mahasiswa/formedit') ?>",
            data: {
                nobp: nobp
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').on('shown.bs.modal', function(e) {
                        $('#nama').focus();
                    })
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function hapus(nobp) {
        Swal.fire({
            title: 'Hapus',
            text: `Yakin menghapus mahasiswa dengan nobp =${nobp} ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('mahasiswa/hapus') ?>",
                    data: {
                        nobp: nobp,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Konfirmasi',
                                text: response.sukses
                            });
                            datamahasiswa();
                        }
                    }
                });
            }
        })
    }
</script>