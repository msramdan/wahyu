<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= $sett_apps->nama_aplikasi ?> - <?= $sett_apps->company ?> </title>
 		<link rel="icon" type="image/png" href="<?php echo base_url('assets') ?>/assets/img/<?= $sett_apps->favicon ?>" />
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="<?= base_url() ?>assets/assets/css/vendor.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/css/transparent/app.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="<?= base_url() ?>assets/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/select-picker/dist/picker.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />

		<!-- data table -->
		<link href="<?= base_url() ?>assets/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
		<link href="<?= base_url() ?>assets/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />


		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
		<script src="<?= base_url() ?>assets/assets/ckeditor/ckeditor.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?= base_url() ?>assets/assets/js/jquery.idle.js"></script>
		<script src="<?= base_url() ?>assets/assets/js/jquery.idle.min.js"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js"></script>

		  <script>
		    $(document).idle({
		      onIdle: function() {
		        window.location = "<?php echo base_url(); ?>auth/logout";
		      },
		      idle: 3000000
		    });
		  </script>

	</head>
	<body style="overflow-x: hidden;">
		<div class="app-cover"></div>
		<div id="loader" class="app-loader">
			<span class="spinner"></span>
		</div>

		<div id="app" class="app app-header-fixed app-sidebar-fixed">
			<div id="header" class="app-header">
				<div class="navbar-header">
					<a href="<?= base_url() ?>Dashboard" class="navbar-brand"><span class="navbar-logo"></span> <b class="me-1"><?= $sett_apps->nama_aplikasi ?></b></a>
					<button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-nav">
					<div class="navbar-item navbar-form">
					</div>
					<div class="navbar-item navbar-user dropdown">
					<a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
						<?php $this->fungsi->user_login()->photo; ?>
						<img src="<?= base_url() ?>assets/assets/img/user/<?= $this->fungsi->user_login()->photo; ?>" alt="" />
						<span>
							<span class="d-none d-md-inline"><?= ucfirst($this->fungsi->user_login()->nama_user) ?></span>
							<b class="caret"></b>
						</span>
					</a>
						<div class="dropdown-menu dropdown-menu-end me-1">
						<a href="<?= base_url() ?>User/edit_profile" class="dropdown-item">Edit Profile</a>
						<div class="dropdown-divider"></div>
						<a href="<?= base_url() ?>Auth/logout" class="dropdown-item">Log Out</a>
					</div>
					</div>
				</div>
			</div>

			<div id="sidebar" class="app-sidebar">
				<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
					<div class="menu">
						<div class="menu-profile">
							<a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
								<div class="menu-profile-cover with-shadow"></div>
								<div class="menu-profile-image">
									<img src="<?= base_url() ?>assets/assets/img/user/<?= $this->fungsi->user_login()->photo?>" alt="" />
								</div>
								<div class="menu-profile-info">
									<div class="d-flex align-items-center">
										<div class="flex-grow-1">
											<?= ucfirst($this->fungsi->user_login()->nama_user) ?>
										</div>
										<div class="menu-caret ms-auto"></div>
									</div>
									<small><?= ucfirst($this->fungsi->user_login()->email) ?></small>
								</div>
							</a>
						</div>
						<div id="appSidebarProfileMenu" class="collapse">
							<div class="menu-item pt-5px">
								<a href="<?= base_url() ?>Setting_app" class="menu-link">
									<div class="menu-icon"><i class="fa fa-cog"></i></div>
									<div class="menu-text">Settings App</div>
								</a>
							</div>
							<div class="menu-divider m-0"></div>
						</div>
						<div class="menu-header">Navigation</div>
						<div class="menu-item">
							<a href="<?= base_url() ?>Dashboard" class="menu-link">
								<div class="menu-icon">
									<i class="fa fa-home"></i>
								</div>
								<div class="menu-text">Dashboard</div>
							</a>
						</div>

		<?php
	          $session_level_id = $this->fungsi->user_login()->level_id;
	          $queryMenu = "SELECT `user_access_menu`.`user_access_menu_id`,`level_id`,`menu`.`menu`,`menu`.`icon`,`menu`.`menu_id` as menu_id
	            FROM `user_access_menu` JOIN `sub_menu` 
	              ON `user_access_menu`.`sub_menu_id` = `sub_menu`.`sub_menu_id`
	              JOIN `menu` 
	              ON `menu`.`menu_id` = `sub_menu`.`menu_id`
	           WHERE `user_access_menu`.`level_id` = $session_level_id
	           GROUP BY `menu`.`menu_id`
	              ORDER BY `menu`.`urutan` ASC";
	          $menu = $this->db->query($queryMenu)->result_array(); 
	     ?>
	          <?php foreach ($menu as $m) : ?>
	        	<div class="menu-item has-sub">
							<a href="javascript:;" class="menu-link">
								<div class="menu-icon">
									<i class="<?= $m['icon'] ?>"></i>
								</div>
								<div class="menu-text"><?= $m['menu'] ?></div>
								<div class="menu-caret"></div>
							</a>
							<div class="menu-submenu">
								<div class="menu-item">
								<?php
		                $menuId = $m['menu_id'];
		                $querySubMenu = "SELECT `user_access_menu`.`level_id`,`user_access_menu`.`sub_menu_id`,`sub_menu`.*
		                FROM `user_access_menu` JOIN `sub_menu` 
		                  ON `user_access_menu`.`sub_menu_id` = `sub_menu`.`sub_menu_id`
		               WHERE `sub_menu`.`menu_id` = $menuId
		               AND `user_access_menu`.`level_id` = $session_level_id
		               ";
		                $subMenu = $this->db->query($querySubMenu)->result_array();
		            ?>
		            <?php foreach ($subMenu as $sm) : ?>
	                <a href="<?= base_url($sm['url']) ?>" class="menu-link">
	                	<div class="menu-text"><?= $sm['nama_sub_menu'] ?></div>
	                	<?php
	                	if($sm['nama_sub_menu'] == 'Menunggu Persetujuan') {
	                		?>
	                			<div class="menu-badge count-waiting-order"><?php echo $this->db->where('status', 'WAITING')->get('orders')->num_rows() ?></div>
	                		<?php
	                	}
	                	?>
	                </a>
	              <?php endforeach; ?>
								</div>
							</div>
						</div>
	          <?php endforeach ?>
						<div class="menu-item d-flex">
							<a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="app-sidebar-bg"></div>
			<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>

		</div>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
	  <?php if ($this->session->flashdata('message') ) : ?>
	  <?php endif; ?>


		<div class="flash-data2" data-flashdata2="<?= $this->session->flashdata('error'); ?>"></div>
    <?php if ($this->session->flashdata('error') ) : ?>
    <?php endif; ?>

		<!-- isi -->
		<?php echo $contents ?>


		<script src="<?= base_url() ?>assets/assets/js/vendor.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/js/app.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/js/theme/transparent.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/d3/d3.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/nvd3/build/nv.d3.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/jvectormap-next/jquery-jvectormap.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/jvectormap-next/jquery-jvectormap-world-mill.js" type="beba54df5f87d24c2458d535-text/javascript"></script>

		<!-- <script src="<?= base_url() ?>assets/assets/plugins/gritter/js/jquery.gritter.js" type="beba54df5f87d24c2458d535-text/javascript"></script> -->

		<script src="<?= base_url() ?>assets/assets/plugins/gritter/js/jquery.gritter.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.canvaswrapper.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.colorhelpers.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.saturated.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.browser.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.drawSeries.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.uiConstants.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.time.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.resize.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.pie.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.crosshair.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.categories.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.navigate.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.touchNavigate.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.hover.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.touch.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.selection.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.symbol.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.legend.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/flot/source/jquery.flot.legend.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/jquery-sparkline/jquery.sparkline.min.js" type="beba54df5f87d24c2458d535-text/javascript"></script>

		<script src="<?= base_url() ?>assets/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

		<script src="<?= base_url() ?>assets/assets/js/demo/dashboard.js" type="beba54df5f87d24c2458d535-text/javascript"></script>
		<script src="<?= base_url() ?>assets/assets/js/rocket-loader.min.js" data-cf-settings="beba54df5f87d24c2458d535-|49" defer=""></script>

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
		<script src="<?php echo base_url();?>assets/assets/js/dataflash.js"></script>
		<script src="<?= base_url() ?>assets/assets/js/number_format.js"></script>
		<script src="<?= base_url() ?>assets/assets/plugins/select-picker/dist/picker.min.js"></script>

		

	</body>
</html>



<script>
    //datatable
  $('#data-table-default').DataTable({
    responsive: true
  });
  $('#data-table-default2').DataTable({
    responsive: true
  });
  //ckeditor
  $('#wysihtml5').wysihtml5();

  // setInterval(function(){
  //     $.get("<?php echo base_url() ?>orders/count_waiting_orders", function(data){
  //         data = $.parseJSON(data);
  //         $('.count-waiting-order').html(data)
  //     });
  // }, 1000);

</script>

