<style>
	.alignLeft {
		text-align: left; !important;
	}
</style>
<article class="module width_full">
	<table class="flexme3" style="display: none"></table>
	<script type="text/javascript">
	$(document).ready(function() {
		var menu_id = '<?php echo $menu_id;?>';
		$(".flexme3").flexigrid({
			id : 'menu_grid',
			url : 'index.php/portal_admin/content/get_news',
			dataType : 'json',
			sortname : "ts",
			sortorder : "desc",
			usepager : true,
			title : 'News List',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 400,
			singleSelect: true,
			onSuccess : function () {
				
			},
			colModel : [ 
			{
				display : 'No',
				name : 'no',
				width : 20,
				sortable : false,
				align : 'center'
			},{
				display : 'Menu ID',
				name : 'menu_id',
				width : 80,
				sortable : true,
				align : 'left',
				hide : true
			},{
				display : 'Kategori ID',
				name : 'kategori_id',
				width : 80,
				sortable : true,
				align : 'left',
				hide : true
			},{
				display : 'Kategori',
				name : 'nama_kategori',
				width : 80,
				sortable : true,
				align : 'left'
			},{
				display : 'Judul',
				name : 'judul',
				width : 150,
				sortable : true,
				align : 'left'
			}, {
				display : 'Posted By',
				name : 'created_by',
				width : 150,
				sortable : true,
				align : 'center'
			}, {
				display : 'Posted On',
				name : 'post_date',
				width : 80,
				sortable : true,
				align : 'center'
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
				onpress : procAdd
			},{
				separator : true
			} ],
			searchitems : [ {
				display : 'Kategori',
				name : 'nama_kategori',
				isdefault : true
			},{
				display : 'Judul',
				name : 'judul',
			}]
		});
		
		// -- Func. Ajax Delete
		function ajaxDelete (id) {
			$(".alert_info").text("Deleting data...")
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/content/delete_news'
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
					window.location = "index.php/portal_admin/content/update_news/"+id+"/"+menu_id;
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
					var judul = $('.flexme3 tr#row'+id+' td:nth-child(5) div').text();
					var answer = confirm('Anda yakin akan menghapus berita '+judul+' ?');
					if (answer) {
						ajaxDelete(id);
					} else {
						return false;
					}
				}
			);
		} 
		
		function procAdd(com, grid) {
			if (com == 'Delete') {
				confirm('Delete ' + $('.trSelected', grid).length + ' items?')
			} else if (com == 'Add') {
				window.location = "index.php/portal_admin/content/manage_news/"+menu_id;
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