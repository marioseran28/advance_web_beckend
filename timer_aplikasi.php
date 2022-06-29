<div class="content-wrapper">
    
    <section class="content">
    	<div class="col-md-6">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">PENGATURAN WAKTU</h3>
            </div>
            
<table class='table table-bordered'>        

	    <tr><td>Keperluan </td><td colspan="5"><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" /></td></tr>
	    
	    <!-- <tr><td>Set Timer </td><td colspan="3"><input type="time" step="1" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="00:00:00" /></td></tr> -->
	    <tr>
	    	<td width='200'>Set Timer</td>
	    	<td id="peringatan" ><label style="color: red;">TIMES UP!!</label></td>
	    	<td><input type="number" max="23" min="0" style=" width: 80px" class="form-control" name="jam" id="jam" placeholder="Jam" value="0" /></td>
	    	<td> : </td>
	    	<td><input type="number" max="59" min="0" style=" width: 80px" class="form-control" name="menit" id="menit" placeholder="Menit" value="0" /></td>
	    	<td> : </td>
	    	<td><input type="number" max="59" min="0" style=" width: 80px" class="form-control" name="detik" id="detik" placeholder="Detik" value="0" /></td>
	    	
	    </tr>

	    <tr><td></td><td colspan="3">
	    <button onclick="hitung_mundur()" class="btn btn-danger">MULAI</button>
	    <button onclick="stop()" class="btn btn-danger">STOP</button> 
	    <button onclick="reset()" id="buton_reset" class="btn btn-danger">RESET</button>
	    
	    </td></tr>
	</table>
        </div>
    </div>
</section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript">

$("#peringatan").css("display","none");
$("#buton_reset").css("display","none");
var h = document.getElementById("jam");
var m = document.getElementById("menit");
var s = document.getElementById("detik");
var k = document.getElementById("keterangan");

function hitung_mundur() {
	if (k.value=='') {
		alert('Isi keterangan dulu!');
	}else if (h.value == 0 && m.value == 0 && s.value == 0) {
		alert('Isi pengaturan waktu dulu!');
	} else {
		startTimer = setInterval(function() {
        	timer();
        }, 1000);
	}
		
}

function timer(){
    $('#jam').prop('readonly', true);
    $('#menit').prop('readonly', true);
    $('#detik').prop('readonly', true); 
    $('#keterangan').prop('readonly', true); 

    if(h.value == 0 && m.value == 0 && s.value == 0){
        h.value = 0;
        m.value = 0;
        s.value = 0;
        clearInterval(startTimer);
        $("#jam").css("display","none");
        $("#detik").css("display","none");
        $("#menit").css("display","none");
        $("#peringatan").slideDown("fast");
        $("#buton_reset").slideDown("fast");
    } else if(s.value != 0){
        s.value--;
    } else if(m.value != 0 && s.value == 0){
        s.value = 59;
        m.value--;
    } else if(h.value != 0 && m.value == 0){
    	s.value = 59;
        m.value = 59;
        h.value--;
    }
    return;
}

function reset(){
	$('#jam').prop('readonly', false);
    $('#menit').prop('readonly', false);
   	$('#detik').prop('readonly', false);
   	$('#keterangan').prop('readonly', false);
   	$('#keterangan').val('');
	var j = document.getElementById("jam");
    var m = document.getElementById("menit");
    var d = document.getElementById("detik");
    j.value= 0;
    m.value= 0;
    d.value= 0; 
	$("#jam").slideDown("fast");
    $("#detik").slideDown("fast");
    $("#menit").slideDown("fast");
    $("#peringatan").css("display","none");
     $("#buton_reset").css("display","none");
}

function stop(){
	clearInterval(startTimer);
	$("#buton_reset").slideDown("fast");
}
</script>