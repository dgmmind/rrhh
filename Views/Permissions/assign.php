<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>

<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>
<?php
/** @var Payrolls $data1 */
$payroll=$data1;

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Overview</h1>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <form action="#" class="form-data" id="update-roles" data-destination="permissions" calling-method="updatePermissions" data-type="">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body scrol-x tree-wrapper">
                    <input type="text" name="roleId" value="<?php echo $data1['roleId']; ?>">
                    <table class="table db-table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Module Id</th>
                            <th scope="col">Module</th>
                            <th scope="col">Create</th>
                            <th scope="col">Read</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        /** @var Permissions $data1 */
                        $modules = $data1['modules'];
                        for ($i=0; $i < count($modules); $i++) {
                            $permissions = $modules[$i]['permissions'];
                            $cCheck = $permissions['c'] == 1 ? " checked " : "";
                            $rCheck = $permissions['r'] == 1 ? " checked " : "";
                            $uCheck = $permissions['u'] == 1 ? " checked " : "";
                            $dCheck = $permissions['d'] == 1 ? " checked " : "";

                            $moduleId = $modules[$i]['moduleId'];
                            //debug($modules);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $n; ?>
                                    <input type="hidden" name="module[<?php echo $i; ?>][moduleId]" value="<?php echo $moduleId; ?>">
                                </td>
                                <td> <?php echo $modules[$i]['moduleName']; ?></td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="module[<?php echo $i; ?>][c]" <?php echo $cCheck ?> id="module[<?php echo $i; ?>][c]" <?php echo $cCheck ?>>
                                        <label for="module[<?php echo $i; ?>][c]" <?php echo $cCheck ?> class="custom-control-label">Custom Checkbox</label>
                                    </div>

                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="module[<?php echo $i; ?>][r]" <?php echo $rCheck ?> id="module[<?php echo $i; ?>][r]" <?php echo $rCheck ?>>
                                        <label for="module[<?php echo $i; ?>][r]" <?php echo $rCheck ?> class="custom-control-label">Custom Checkbox</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="module[<?php echo $i; ?>][u]" <?php echo $uCheck ?> id="module[<?php echo $i; ?>][u]" <?php echo $uCheck ?>>
                                        <label for="module[<?php echo $i; ?>][u]" <?php echo $uCheck ?> class="custom-control-label">Custom Checkbox</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="module[<?php echo $i; ?>][d]" <?php echo $dCheck ?> id="module[<?php echo $i; ?>][d]" <?php echo $dCheck ?>>
                                        <label for="module[<?php echo $i; ?>][d]" <?php echo $dCheck ?> class="custom-control-label">Custom Checkbox</label>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $n++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="buttons-payroll">
                        <button type="submit" id="send-payroll" class="btn btn-success btn-block">Guardar Planilla</button>
                    </div>
                </div>

                <!-- /.card-footer-->
            </div>
        </form>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- JS Funtions Payrolls-->
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>