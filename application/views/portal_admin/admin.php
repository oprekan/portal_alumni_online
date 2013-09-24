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
			url : 'index.php/portal_admin/admin/get_admin',
			dataType : 'json',
			sortname : "nama_lengkap",
			sortorder : "asc",
			usepager : true,
			title : 'Administrator List',
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
				name : 'nama_lengkap',
				width : 150,
				sortable : true,
				align : 'left'
			}, {
				display : 'Username',
				name : 'username',
				width : 100,
				sortable : true,
				align : 'left'
			}, {
				display : 'Email',
				name : 'email',
				width : 120,
				sortable : true,
				align : 'left'
			}, {
				display : 'Level',
				name : 'level',
				width : 95,
				sortable : true,
				align : 'left'
			}, {
				display : 'Blokir',
				name : 'blokir',
				width : 30,
				sortable : true,
				align : 'center',
				hide : false
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
				display : 'Nama',
				name : 'nama_lengkap',
				isdefault : true
			}, {
				display : 'Level',
				name : 'level'
			}, {
				display : 'Blokir',
				name : 'blokir'
			}],
			onSuccess : function () {
				// $('.flexme3 tr').each( function(){ 
					// td = $(this).find("td:nth(1)");
					// td.each(function () {
						// div = $(this).find('div');
						// div.each(function(){
							// css = $(this);
							// css.style.textAlign = 'left';
						// });
					// });
				// });
				
				// tr = $('.flexme3 tr')[0];
				// td = $(tr).find("td:nth(1)");
				// css = $(td[0]).find('div')[0];
				// $(css)[0].style.textAlign = 'left';

				 // $("tr").each(function() {
					// var st = $(this).find("td:nth(1)").text();
					// if (st == "Incoming") {
						// $(this).attr("class",$(this).attr("class") == "erow" ? "darkgreen" : "lightgreen" );
					// }
					// else if (st == "Outgoing") {
						// $(this).attr("class",$(this).attr("class") == "erow" ? "darkred" : "lightred" );
					// }
				// });
				
				// $('.flexme3 tr').each( function(){ 
					// var cell = $('td[abbr="nama_lengkap"] >div', this); 
					// $(this).addClass("alignLeft"); 
					// cell.text(cell.text()); 
					// console.log(cell.text());
				// }); 
			}
		});
		
		// -- Func. Ajax Delete
		function ajaxDelete (id) {
			$(".alert_info").text("Deleting data...")
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/admin/delete_admin'
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
					namaLengkap = $('.flexme3 tr#row'+id+' td:nth-child(2) div').text();
					userName = $('.flexme3 tr#row'+id+' td:nth-child(3) div').text();
					password = $('.flexme3 tr#row'+id+' td:nth-child(4) div').text();
					email = $('.flexme3 tr#row'+id+' td:nth-child(5) div').text();
					level = $('.flexme3 tr#row'+id+' td:nth-child(6) div').text();
					blokir = $('.flexme3 tr#row'+id+' td:nth-child(7) div').text();
					window.location = "index.php/portal_admin/admin/update_admin/"+id;
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
					namaLengkap = $('.flexme3 tr#row'+id+' td:nth-child(2) div').text();
					var answer = confirm('Anda yakin akan menghapus administrator '+namaLengkap+' ?');
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
				window.location = "index.php/portal_admin/admin/add_admin";
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