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
			id : 'kategori_grid',
			url : 'index.php/portal_admin/quesioners/get_kategori',
			dataType : 'json',
			sortname : "kategori",
			sortorder : "asc",
			usepager : true,
			title : 'Kategori List',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 350,
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
				display : 'ID Kategori',
				name : 'id',
				width : 150,
				sortable : true,
				align : 'left',
				hide : true
			},{
				display : 'Kategori',
				name : 'kategori',
				width : 200,
				sortable : true,
				align : 'left'
			},{
				display : 'Active',
				name : 'active',
				width : 50,
				sortable : true,
				align : 'center'
			},{
				display : 'Manage Question',
				name : 'manage',
				width : 100,
				sortable : true,
				align : 'center',
				hide : false,
				process : manageQuestion
			}],
			searchitems : [ {
				display : 'Kategori',
				name : 'kategori',
				isdefault : true
			}]
		});
		
		// -- Func. Cell Click for editing
		function manageQuestion(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					window.location = "index.php/portal_admin/quesioners/variable/"+id;
				}
			);
		} 
	});
	</script>
</article>