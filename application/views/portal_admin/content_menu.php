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
			url : 'index.php/portal_admin/content/get_menu',
			dataType : 'json',
			sortname : "urutan",
			sortorder : "asc",
			usepager : true,
			title : 'List Menu',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 400,
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
			},{
				display : 'Jenis Page',
				name : 'jenis_id',
				width : 80,
				sortable : true,
				align : 'center',
				hide : true
			}, {
				display : 'Order',
				name : 'urutan',
				width : 60,
				sortable : true,
				align : 'center'
			}, /*{
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
			}, */{
				display : 'Manage Content',
				name : 'edit',
				width : 80,
				sortable : true,
				align : 'center',
				hide : false,
				process : procManage
			}]
		});
		
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
		
		// -- Func. Cell Click to manage content
		function procManage(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					tipe = $('.flexme3 tr#row'+id+' td:nth-child(5) div').text();
					jenisPage = $('.flexme3 tr#row'+id+' td:nth-child(6) div').text();
					if (tipe != "parent") {
						window.location = "index.php/portal_admin/content/manage/"+id+"/"+jenisPage;
					}
				}
			);
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