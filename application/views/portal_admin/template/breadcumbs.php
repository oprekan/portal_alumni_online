<div class="user">
	<?php
		$nama = $this->session->userdata('nama_lengkap');
		echo "<p>$nama (<a href='#'>3 Messages</a>)</p>";
	?>
	<p>John Doe (<a href="#">3 Messages</a>)</p>
	<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
</div>
<div class="breadcrumbs_container">
	<article class="breadcrumbs">
		<?php
			$i=1;
			$total = count($breadcumbs);
			foreach ($breadcumbs as $link=>$value) {
				if ($i != $total) {
					echo "<a href='$link'>$value</a><div class='breadcrumb_divider'></div>";
				} else {
					echo "<a class='current'>$value</a>";
				}
				$i++;
			}
		?>
	</article>
	<div style="float: right; margin: 8px;"> <a href="portal_admin/admin/logout" style="color:#666666;text-decoration:none;">Logout</a></div>
</div>