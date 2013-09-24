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
			url : 'portal_admin/quesioners/get_variable',
			dataType : 'json',
			sortname : "variable",
			sortorder : "asc",
			usepager : true,
			title : 'Variable List',
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
				display : 'ID Variable',
				name : 'id',
				width : 150,
				sortable : true,
				align : 'left',
				hide : true
			},{
				display : 'Variable',
				name : 'variable',
				width : 200,
				sortable : true,
				align : 'left'
			},{
				display : 'Total Question',
				name : 'total_question',
				width : 80,
				sortable : true,
				align : 'center'
			},{
				display : 'Manage Question',
				name : 'manage',
				width : 100,
				sortable : true,
				align : 'center',
				hide : false,
				process : procEdit
			}],
			searchitems : [ {
				display : 'Variable',
				name : 'variable',
				isdefault : true
			},{
				display : 'Tipe',
				name : 'tipe'
			}]
		});
		
		// -- Func. Cell Click for editing
		function procEdit(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					window.location = "portal_admin/quesioners/question/"+id;
				}
			);
		} 
	});
	</script>
</article>