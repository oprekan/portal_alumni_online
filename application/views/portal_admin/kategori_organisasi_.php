<style>
	.alignLeft {
		text-align: left; !important;
	}
</style>
<article class="module width_full">
	<table class="flexme3" style="display: none"></table>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".flexme3").flexigrid({
			id : 'admin_grid',
			url : 'index.php/portal_admin/kategori_organisasi/get_kategori',
			dataType : 'json',
			sortname : "kategori",
			sortorder : "asc",
			usepager : true,
			title : 'Category List',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 350,
			singleSelect: true,
			colModel : [ {
				display : 'No',
				name : 'no',
				width : 20,
				sortable : false,
				align : 'center'
			}, {
				display : 'Nama',
				name : 'kategori',
				width : 150,
				sortable : true,
				align : 'left'
			}, {
				display : 'Edit',
				name : 'edit',
				width : 50,
				sortable : true,
				align : 'center',
				hide : false,
				process : procEdit
			}, {
				display : 'Delete',
				name : 'delete',
				width : 50,
				sortable : true,
				align : 'center',
				hide : false,
				process : procDelete
			}],
			buttons : [ {
				name : 'Add',
				bclass : 'add',
				onpress : test
			},{
				separator : true
			} ],
			searchitems : [ {
				display : 'Kategori',
				name : 'kategori',
				isdefault : true
			}]
		});
		
		// -- Func. Ajax Delete
		function ajaxDelete (id) {
			$(".alert_info").text("Deleting data...")
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/kategori_organisasi/delete_kategori'
				,data : 'id='+id
				,success : function (resp) {
					var info = $(".alert_info");
					var error = $(".alert_error");
					var success = $(".alert_success");
					if (resp == "success") {
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						} else if (success.length != 0) {
							$(".alert_success").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						}
						 $(".flexme3").flexReload();
					} else {
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						} else if (success.length != 0) {
							$(".alert_success").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						}
						return false;
					}
				}
			});
		}
		
		// -- Func. Cell Click for editing
		function procEdit(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					window.location = "index.php/portal_admin/kategori_organisasi/update_kategori/"+id;
				}
			);
		} 
		
		// -- Func. Cell Click for deleting
		function procDelete(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					kategori = $('.flexme3 tr#row'+id+' td:nth-child(2) div').text();
					var answer = confirm('Anda yakin akan menghapus kategori '+kategori+' ?');
					if (answer) {
						ajaxDelete(id);
					} else {
						return false;
					}
				}
			);
		} 
		
		function test(com, grid) {
			if (com == 'Delete') {
				confirm('Delete ' + $('.trSelected', grid).length + ' items?')
			} else if (com == 'Add') {
				window.location = "index.php/portal_admin/kategori_organisasi/add_kategori";
			}
		}
		
		function doCommand(com, grid) {
			if (com == 'Edit') {
				$('.trSelected', grid).each(function() {
					var id = $(this).attr('id');
					id = id.substring(id.lastIndexOf('row')+3);
					alert("Edit row " + id);
				});
			} else if (com == 'Delete') {
				$('.trSelected', grid).each(function() {
					var id = $(this).attr('id');
					id = id.substring(id.lastIndexOf('row')+3);
					alert("Delete row " + id);
				});
			}
		}
	});
	</script>
</article>