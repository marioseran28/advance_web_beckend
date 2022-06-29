html menampilkan tglnya:
<tr><td width='200'>Tgl Pinjam <?php echo form_error('tgl_pinjam') ?></td><td><input type="text" class="form-control" name="tgl_pinjam" style="width: 200px" id="tgl_pinjam" value="<?php echo $tgl_pinjam; ?>" placeholder="tttt/bb/hh" /></td></tr>

	    <tr><td width='200'>Tgl Kembali <?php echo form_error('tgl_kembali') ?></td><td><input type="text" class="form-control" name="tgl_kembali" style="width: 200px" id="tgl_kembali" value="<?php echo $tgl_kembali; ?>" placeholder="tttt/bb/hh" /></td></tr>
////////////////////////////////////////////////////////////////////////////////////////////////

javascriptnya :
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript">
	$(function() {
        $(document).ready(function() {
    $('#tgl_pinjam').datepicker({
       dateFormat: 'yy/mm/dd',
    });
        });    
    });

     $(function() {
        $(document).ready(function() {
    $('#tgl_kembali').datepicker({
       dateFormat: 'yy/mm/dd',
    });
        });    
    });
</script>