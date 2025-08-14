<?php
/** @var Users $data1 */
$roles=$data1;

?>


    <!-- Admin Header -->
<?php adminHeader($data); ?>
    <!-- Admin Nav -->
<?php adminNav($data); ?>

    <!-- Admin Sidebar -->
<?php adminSidebar($data); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
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
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Role Name</th>
                            <th scope="col">Role Description</th>
                            <th scope="col">Role Status</th>
                            <th scope="col">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?php echo $role["roleName"]?></td>
                                <th scope="row"><?php echo $role["roleDescription"]?></th>
                                <td><?php echo $role["roleStatus"]?></td>
                                <td><a href="<?php echo router(); ?>permissions/assign/<?php echo $role['roleId']; ?>">Permisos</a><a href="#">Edit</a><a href="#">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Footer
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- Admin Sidebar -->
<?php adminFooter($data); ?>