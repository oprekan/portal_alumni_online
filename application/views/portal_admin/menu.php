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
			id : 'menu_grid',
			url : 'index.php/portal_admin/menu/get_menu',
			dataType : 'json',
			sortname : "urutan",
			sortorder : "asc",
			usepager : true,
			title : 'List Menu',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 350,
			singleSelect: true,
			onSuccess : function () {
				
			},
			colModel : [ 
			// {
				// display : 'No',
				// name : 'no',
				// width : 20,
				// sortable : false,
				// align : 'center'
			// }, 
			{
				display : 'Menu',
				name : 'nama_menu',
				width : 150,
				sortable : true,
				align : 'left'
			},{
				display : 'Menu 2',
				name : 'nama_menu2',
				width : 150,
				sortable : true,
				align : 'left',
				hide : true
			}, {
				display : 'Parent ID',
				name : 'parent_id',
				width : 150,
				sortable : true,
				align : 'left',
				hide : true
			}, {
				display : 'Link',
				name : 'link',
				width : 150,
				sortable : true,
				align : 'left'
			}, {
				display : 'Type',
				name : 'tipe',
				width : 80,
				sortable : true,
				align : 'center'
			}, {
				display : 'Order',
				name : 'urutan',
				width : 60,
				sortable : true,
				align : 'center'
			}, {
				display : 'Up',
				name : 'up',
				width : 40,
				sortable : true,
				align : 'center',
				process : orderUp
			}, {
				display : 'Down',
				name : 'down',
				width : 40,
				sortable : true,
				align : 'center',
				process : orderDown
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
				onpress : addData
			},{
				separator : true
			} ]
			// searchitems : [ {
				// display : 'Parent',
				// name : 'parent',
				// isdefault : true
			// },{
				// display : 'Child',
				// name : 'child'
			// }]
		});
		
		// -- Func. Ajax Delete
		function ajaxDelete (id) {
			$(".alert_info").text("Deleting data...")
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/menu/delete_menu'
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
		
		// -- Func. order up
		function orderUp(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					parentId = jQuery.trim($('.flexme3 tr#row'+id+' td:nth-child(3) div').text());
					tipe = $('.flexme3 tr#row'+id+' td:nth-child(5) div').text();
					urutan = $('.flexme3 tr#row'+id+' td:nth-child(6) div').text();
					
					$.ajax({
						type : 'POST'
						,url : 'index.php/portal_admin/menu/order'
						,data : 'id='+id+'&order=up&parent_id='+parentId+'&tipe='+tipe+'&urutan='+urutan
						,success : function (resp) {
							if (resp == "success") {
								$(".flexme3").flexReload();
								
							} else if (resp="onTop") {
								alert("Menu cannot be moved to the top");
							} else {
								alert(resp);
								return false;
							}
						}
					});
				}
			);
		} 
		
		// -- Func. order down
		function orderDown(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					parentId = jQuery.trim($('.flexme3 tr#row'+id+' td:nth-child(3) div').text());
					tipe = $('.flexme3 tr#row'+id+' td:nth-child(5) div').text();
					urutan = $('.flexme3 tr#row'+id+' td:nth-child(6) div').text();
					
					$.ajax({
						type : 'POST'
						,url : 'index.php/portal_admin/menu/order'
						,data : 'id='+id+'&order=down&parent_id='+parentId+'&tipe='+tipe+'&urutan='+urutan
						,success : function (resp) {
							if (resp == "success") {
								$(".flexme3").flexReload();
								
							} else if (resp="onBellow") {
								alert("Menu cannot be moved down");
							} else {
								alert(resp);
								return false;
							}
						}
					});
				}
			);
		} 
		
		// -- Func. Cell Click for editing
		function procEdit(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					window.location = "index.php/portal_admin/menu/update_menu/"+id;
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
					menu = $('.flexme3 tr#row'+id+' td:nth-child(2) div').text();
					var answer = confirm('Anda yakin akan menghapus menu '+menu+' ?');
					if (answer) {
						ajaxDelete(id);
					} else {
						return false;
					}
				}
			);
		} 
		
		function addData(com, grid) {
			if (com == 'Add') {
				window.location = "index.php/portal_admin/menu/add_menu";
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