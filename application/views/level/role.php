<div id="content" class="app-content">
  <h1 class="page-header">KELOLA ACCESS LEVEL</h1>
  <div class="panel panel-inverse">
    <div class="panel-heading">
                <h4 class="panel-title">Note* : Untuk ceklis create, update dan delete silahkan ceklis terlebih dahulu access view nya</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    </div>

  <div class="box-body" style="overflow-x: scroll; ">
    <div class="panel-body">
       <table id="data-table-default" class="table table-bordered table-hover table-td-valign-middle text-white">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th width="24%">Nama</th>
                <th width="25%">Access View</th>
                <th width="10%">Read</th>
                <th width="10%">Create</th>
                <th width="10%">Update</th>
                <th width="10%">Delete</th>
                <th width="10%">Export</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($row->result() as $key => $value) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $value->menu ?></td>
                  <td>
                    <div class="form-check">
                        <?php
                          $menuId = $value->menu_id;
                          $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                          FROM `sub_menu` JOIN `menu` 
                            ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                         WHERE `sub_menu`.`menu_id` = $menuId
                         ";
                          $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>
                       <?php foreach ($subMenu as $sm) : ?>
                        <input class="form-check-input access" type="checkbox" <?= check_access($role['level_id'],$sm['sub_menu_id']); ?>
                              data-level="<?= $role['level_id']; ?>"
                              data-submenu="<?= $sm['sub_menu_id'] ?>" >
                            <label style="margin-bottom: 3px" class="" for="customCheck1"><?= $sm['nama_sub_menu'] ?></label><br>
                      <?php endforeach; ?>                 
                    </div>
                  </td>
                   <!-- Query Untuk Akses Read -->
                  <td>
                    <div class="form-check">
                      <?php
                        $menuId = $value->menu_id;
                        $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                                  FROM `sub_menu` JOIN `menu` 
                                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                                 WHERE `sub_menu`.`menu_id` = $menuId
                                 ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>

                         <?php foreach ($subMenu as $sm) :
                         $coba =check_access($role['level_id'],$sm['sub_menu_id']); ?>
                         <?php if ($coba=='') { ?>
                           <input class="form-check-input read-access" type="checkbox" disabled="">
                         <?php }else{ ?>
                          <input class="form-check-input read-access" type="checkbox" <?= check_access_read($role['level_id'],$sm['sub_menu_id']); ?> 
                                data-level="<?= $role['level_id']; ?>"
                                data-submenu="<?= $sm['sub_menu_id'] ?>"
                              >
                         <?php } ?>
                          <label style="margin-bottom: 3px" class="" for="customCheck1">Ya</label><br>
                        <?php endforeach; ?>
                      </div>
                  </td>

                  <!-- Query Untuk Akses Create -->
                  <td>
                    <div class="form-check">
                      <?php
                        $menuId = $value->menu_id;
                        $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                                  FROM `sub_menu` JOIN `menu` 
                                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                                 WHERE `sub_menu`.`menu_id` = $menuId
                                 ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>

                         <?php foreach ($subMenu as $sm) :
                         $coba =check_access($role['level_id'],$sm['sub_menu_id']); ?>
                         <?php if ($coba=='') { ?>
                           <input class="form-check-input create-access" type="checkbox" disabled="">
                         <?php }else{ ?>
                          <input class="form-check-input create-access" type="checkbox" <?= check_access_create($role['level_id'],$sm['sub_menu_id']); ?> 
                                data-level="<?= $role['level_id']; ?>"
                                data-submenu="<?= $sm['sub_menu_id'] ?>"
                              >
                         <?php } ?>
                          <label style="margin-bottom: 3px" class="" for="customCheck1">Ya</label><br>
                        <?php endforeach; ?>
                      </div>
                  </td>

                  <!-- Query Untuk Akses Update -->
                  <td>
                    <div class="form-check">
                      <?php
                        $menuId = $value->menu_id;
                        $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                                  FROM `sub_menu` JOIN `menu` 
                                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                                 WHERE `sub_menu`.`menu_id` = $menuId
                                 ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>

                         <?php foreach ($subMenu as $sm) :
                         $coba =check_access($role['level_id'],$sm['sub_menu_id']); ?>
                         <?php if ($coba=='') { ?>
                           <input class="form-check-input update-access" type="checkbox" disabled="">
                         <?php }else{ ?>
                          <input class="form-check-input update-access" type="checkbox" <?= check_access_update($role['level_id'],$sm['sub_menu_id']); ?> 
                                data-level="<?= $role['level_id']; ?>"
                                data-submenu="<?= $sm['sub_menu_id'] ?>"
                              >
                         <?php } ?>
                          <label style="margin-bottom: 3px"  class="" for="customCheck1">Ya</label><br>
                        <?php endforeach; ?>
                      </div>
                  </td>

                  <!-- Query Untuk Akses Delete -->
                  <td>
                    <div class="form-check">
                      <?php
                        $menuId = $value->menu_id;
                        $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                                  FROM `sub_menu` JOIN `menu` 
                                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                                 WHERE `sub_menu`.`menu_id` = $menuId
                                 ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>

                         <?php foreach ($subMenu as $sm) :
                         $coba =check_access($role['level_id'],$sm['sub_menu_id']); ?>
                         <?php if ($coba=='') { ?>
                           <input class="form-check-input delete-access" type="checkbox" disabled="">
                         <?php }else{ ?>
                          <input class="form-check-input delete-access" type="checkbox" <?= check_access_delete($role['level_id'],$sm['sub_menu_id']); ?> 
                                data-level="<?= $role['level_id']; ?>"
                                data-submenu="<?= $sm['sub_menu_id'] ?>"
                              >
                         <?php } ?>
                          <label style="margin-bottom: 3px"  class="" for="customCheck1">Ya</label><br>
                        <?php endforeach; ?>
                      </div>
                  </td>

                  <!-- Query Untuk Akses Export -->
                  <td>
                    <div class="form-check">
                      <?php
                        $menuId = $value->menu_id;
                        $querySubMenu = "SELECT `sub_menu`.`nama_sub_menu`,`sub_menu`.`sub_menu_id`,`menu`.*
                                  FROM `sub_menu` JOIN `menu` 
                                    ON `sub_menu`.`menu_id` = `menu`.`menu_id`
                                 WHERE `sub_menu`.`menu_id` = $menuId
                                 ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                        ?>

                         <?php foreach ($subMenu as $sm) :
                         $coba =check_access($role['level_id'],$sm['sub_menu_id']); ?>
                         <?php if ($coba=='') { ?>
                           <input class="form-check-input export-access" type="checkbox" disabled="">
                         <?php }else{ ?>
                          <input class="form-check-input export-access" type="checkbox" <?= check_access_export($role['level_id'],$sm['sub_menu_id']); ?> 
                                data-level="<?= $role['level_id']; ?>"
                                data-submenu="<?= $sm['sub_menu_id'] ?>"
                              >
                         <?php } ?>
                          <label style="margin-bottom: 3px" class="" for="customCheck1">Ya</label><br>
                        <?php endforeach; ?>
                      </div>
                  </td>
                    </form>
                </tr>
              <?php } ?>

            </tbody>
          </table>
    </div>

  </div>
</div>

</div>


    <script type="text/javascript">
      $('.access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            document.location.href = "<?= base_url('level/role/') ?>" + levelId;
          }

        });

      })

      $('.read-access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess_read'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            
          }

        });

      })

      $('.create-access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess_create'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            
          }

        });

      })

      $('.update-access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess_update'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            
          }

        });

      })

      $('.delete-access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess_delete'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            
          }

        });

      })

      $('.export-access').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const levelId = $(this).data('level');
        $.ajax({
          url: "<?= base_url('level/changeaccess_export'); ?>",
          type: "post",
          data: {
            subMenuId: subMenuId,
            levelId: levelId,
          },
          success: function() {
            
          }

        });

      })

    </script>