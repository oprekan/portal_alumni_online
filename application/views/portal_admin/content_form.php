<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-structure.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/tinymcpuk/jscripts/tiny_mce/themes/advanced/skins/default/ui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/tinymcpuk/jscripts/tiny_mce/plugins/inlinepopups/skins/clearlooks2/window.css" type="text/css" media="screen" />

<script src="portal_assets/admin/tinymcpuk/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="portal_assets/admin/tinymcpuk/jscripts/tiny_mce/tiny_lokomedia.js" type="text/javascript"></script>
<?php
	// -- Form Data
	$error = "";
	$nama_menu = "";
	$isi = "";
	$gbr = "";
	$hidden_id = "";
	
	if(isset($data)){
		foreach ($data as $row) {
			$this->authlib->log($row);
			$error = (isset($row['error']))?$row['error']:null;
			$nama_menu = $row['nama_menu'];
			$isi = $row['isi'];
			$gbr = $row['gambar'];
			$hidden_id = $row['id'];
		}
	}
?>
<article class="module width_full">
	<header><h3>Content Management</h3></header>
	<div class="module_content">
	<?php echo form_open_multipart('portal_admin/content/save_process');?>
	<div class="formee">
        <div class="grid-12-12">
               <label>Menu</label>
				<input type='text' style="width:90%;" name='menu' id='menu' readonly="readonly" value="<?php echo $nama_menu;?>">
				<input type='hidden' name='hidden_id' id='hidden_id' value="<?php echo $hidden_id;?>">
        </div>
		<div class="grid-12-12 clear">
                <label>Content</label>
               <textarea id="loko" name="isi" style='width: 600px; height: 350px;'><?php echo $isi;?></textarea>
        </div>
		<div class="grid-12-12">
               <label>Gambar</label>
			   <?php if($gbr!=""){echo "<img src='./portal_assets/admin/images/static/".$gbr."'/><input type='checkbox' name='del_image' value='delete' /> Delete Image";}else{echo "No Image";}?>
		</div>
		<div class="grid-12-12">
               <label>Upload Gambar</label>
			   <input type='file' name='userfile' size=40> <br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px
			   <input type='hidden' name='hidden_gbr' value="<?php echo $gbr;?>">
		</div>
        <div class="grid-12-12">
               <input class="left" id="submit" type="submit" title="send" value="Send" />
               <input class="left" type="button" title="cancel" value="Cancel" onclick='self.history.back()' />
        </div>
   </div>
   </form>
   </div>
</article>