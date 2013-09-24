<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-structure.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-style.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(document).ready(function(){
		var varId = <?php echo $variable_id;?>;
		$('#kategori').focus();
		
		// -- Func. Ajax saving
		function ajaxSave (tipe_id,pertanyaan,hiddenId) {
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
				,url : 'portal_admin/quesioners/save_process'
				,data : 'variable_id='+varId+'&tipe_id='+tipe_id+'&pertanyaan='+pertanyaan+'&hidden_id='+hiddenId
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
						window.location = 'portal_admin/quesioners/question/'+varId;
						
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
			var tipe_id = $('#tipe').val();
			var pertanyaan = $('#pertanyaan').val();
			var hiddenId = $('#hidden_id').val();
			var alertInfo = $(".alert_info");
			if (tipe_id == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#tipe").addClass("formee-error");
				$('#tipe').focus();
			} else if (pertanyaan == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#pertanyaan").addClass("formee-error");
				$('#pertanyaan').focus();
			}
			else {
				$("#tipe").removeClass("formee-error");
				$("#pertanyaan").removeClass("formee-error");
				ajaxSave(tipe_id,pertanyaan,hiddenId);
			}
		});
	});
</script>
<?php
	$cmb_data = array();
	if(isset($combo_tipe)){
		foreach ($combo_tipe as $cmb) {
			$cmb_data[$cmb['id']] = $cmb['tipe'];
		}
	}
	
	// -- Form Data
	$error = "";
	$pertanyaan = "";
	$hidden_id = "";
	$tipe_id = "";
	
	if(isset($data)){
		foreach ($data as $row) {
			$error = (isset($row['error']))?$row['error']:null;
			$pertanyaan = $row['pertanyaan'];
			$hidden_id = $row['id'];
			$tipe_id = $row['tipe_id'];
		}
	}
?>
<article class="module width_full">
	<header><h3>Question Management</h3></header>
	<div class="module_content">
	<div class="formee">
        <div class="grid-12-12">
               <label>Variable </label>
				<input type='text' name='variable' id="variable" style="width:92%;" value="<?php echo $variable;?>" disabled='disabled'>
        </div>
		<div class="grid-12-12">
               <label>Tipe <em class="formee-req">*</em></label>
				<?php echo form_dropdown('tipe', $cmb_data, $tipe_id,'id="tipe"  style="width:92%;"'); ?> 
				<input type='hidden' name='hidden_id' id='hidden_id' value="<?php echo $hidden_id;?>">
        </div>
		<div class="grid-12-12">
               <label>Pertanyaan <em class="formee-req">*</em></label>
			   <textarea name='pertanyaan' id='pertanyaan' rows='3' style='width:92%;margin-bottom:0;'><?php echo $pertanyaan;?></textarea>
				<!--<input type='text' name='pertanyaan' id="pertanyaan" style="width:92%;" >-->
        </div>
		<div class="grid-12-12">
               <input class="left" id="submit" type="submit" title="save" value="Save" />
               <input class="left" type="button" title="cancel" value="Cancel" onclick='self.history.back()' />
        </div>
   </div>
   </form>
   </div>
</article>