<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-structure.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-style.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function(){
		$('#kategori').focus();
		
		// -- Func. Ajax saving
		function ajaxSave (parent_menu,jenis_menu,link_menu,nama_menu,desc_menu,hiddenId) {
			//$("#validation").html('<img src="./images/webadmin/icon/load.gif"/> Saving..');
			//$(".alert_error").replaceWith("<h4 class='alert_info'>Saving</h4>");
			alertInfo = $(".alert_info");
			if (alertInfo.length == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_info'>Please Wait, Saving data...</h4>");
			} else {
				$(".alert_info").html("Please Wait, Saving data...");
			}
			
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/menu/save_process'
				,data : 'parent_id='+parent_menu+'&jenis_id='+jenis_menu+'&link_menu='+link_menu+'&nama_menu='+nama_menu+'&desc_menu='+desc_menu+'&hidden_id='+hiddenId
				,success : function (resp) {
					if (resp == "success") {
						var info = $(".alert_info");
						var error = $(".alert_error");
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						}
						window.location = 'index.php/portal_admin/menu';
						
					} else {
						$(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						return false;
					}
					
				}
			});
		}
		
		function checkAlertInfo (alertInfoLen,msg) {
			if (alertInfoLen == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			} else {
				$(".alert_info").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			}
		}
		
		$('#submit').click(function(){
			var parent_menu = $('#parent_menu').val();
			var jenis_menu = $('#jenis_menu').val();
			var link_menu = $('#link_menu').val();
			var nama_menu = $('#nama_menu').val();
			var desc_menu = $('#desc_menu').val();
			
			var hiddenId = $('#hidden_id').val();
			var alertInfo = $(".alert_info");
			if (link_menu == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#link_menu").addClass("formee-error");
				$('#link_menu').focus();
			} else if (jenis_menu == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#jenis_menu").addClass("formee-error");
				$('#jenis_menu').focus();
			} else if (nama_menu == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#nama_menu").addClass("formee-error");
				$('#nama_menu').focus();
			} else if (desc_menu == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#desc_menu").addClass("formee-error");
				$('#desc_menu').focus();
			}
			else {
				$("#link_menu").removeClass("formee-error");
				$("#nama_menu").removeClass("formee-error");
				$("#desc_menu").removeClass("formee-error");
				ajaxSave(parent_menu,jenis_menu,link_menu,nama_menu,desc_menu,hiddenId);
			}
		});
	});
</script>

<?php
	$cmb_data = array();
	if(isset($combo_menu)){
		foreach ($combo_menu as $cmb) {
			$cmb_data[$cmb['id']] = $cmb['nama_menu'];
		}
	}
	
	$cmb_jenis = array();
	if(isset($combo_jenis)){
		foreach ($combo_jenis as $cmb) {
			$cmb_jenis[$cmb['id']] = $cmb['jenis'];
		}
	}
	
	// -- Form Data
	// $error = "";
	$link_menu = "";
	$nama_menu = "";
	$desc_menu = "";
	$hidden_id = "";
	$parent_id = "";
	$jenis_id = "";
	
	if(isset($data)){
		foreach ($data as $row) {
			// $error = (isset($row['error']))?$row['error']:null;
			$link_menu = $row['link'];
			$nama_menu = $row['nama_menu'];
			$desc_menu = $row['desc'];
			$hidden_id = $row['id'];
			$parent_id = $row['parent_id'];
			$jenis_id = $row['jenis_id'];
		}
	}
?>
<article class="module width_full">
	<header><h3>Menu Management</h3></header>
	<div class="module_content">
	<div class="formee">
        <div class="grid-12-12">
               <label>Parent Menu <em class="formee-req">*</em></label>
				<?php echo form_dropdown('parent_menu', $cmb_data, $parent_id,'id="parent_menu"  style="width:92%;"'); ?> <input type='hidden' name='hidden_id' id='hidden_id' value="<?php echo $hidden_id;?>">
        </div>
		<div class="grid-12-12">
               <label>Jenis Menu <em class="formee-req">*</em></label>
				<?php echo form_dropdown('jenis_menu', $cmb_jenis, $jenis_id,'id="jenis_menu"  style="width:92%;"'); ?>
        </div>
		<div class="grid-12-12">
               <label>Link Menu <em class="formee-req">*</em>&nbsp;(Fill "#" if it doesn't have a link)</label>
				<input type='text' name='link_menu' id="link_menu" style="width:92%;" value="<?php echo $link_menu;?>">
        </div>
		<div class="grid-12-12 clear">
                <label>Nama menu <em class="formee-req">*</em></label>
				<input type='text' name='nama_menu' id="nama_menu" style="width:92%;" value="<?php echo $nama_menu;?>">
        </div>
		<div class="grid-12-12 clear">
                <label>Desc menu <em class="formee-req">*</em></label>
				<input type='text' name='desc_menu' id="desc_menu" style="width:92%;" value="<?php echo $desc_menu;?>">
        </div>
		<div class="grid-12-12">
               <input class="left" id="submit" type="submit" title="save" value="Save" />
               <input class="left" type="button" title="cancel" value="Cancel" onclick='self.history.back()' />
        </div>
   </div>
   </form>
   </div>
</article>