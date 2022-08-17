<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('mahasiswa/updatedata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group mb-4">
                    <input type="number" name="nobp" id="nobp" class="form-control" placeholder="NO.BP" readonly value="<?= $nobp ?>">
                </div>
                <div class="form-group mb-4">
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" value="<?= $nama ?>">
                </div>
                <div class="form-group mb-4">
                    <input type="text" name="tempat" id="tempat" class="form-control" placeholder="Tempat Lahir" value="<?= $tempat ?>">
                </div>
                <div class="form-group mb-4">
                    <label for="tanggallahir">Tanggal Lahir</label>
                    <input type="date" name="tgl" id="tgl" class="form-control" value="<?= $tgl ?>">
                </div>
                <div class="form-group mb-4">
                    <select name="jenkel" id="jenkel" class="form-control">
                        <option value="">- Jenis Kelamin -</option>
                        <option value="L" <?php if ($jenkel == 'L') echo 'selected'; ?>>Laki-Laki</option>
                        <option value="P" <?php if ($jenkel == 'P') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-dark">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        $('.pesan').html(response.error).show();
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        });
                        datamahasiswa();
                        $('#modaledit').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>