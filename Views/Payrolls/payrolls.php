<?php
/** @var Users $data1 */
$payrolls=$data1;

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
                <form action="#" class="form-data" id="create-payroll" data-destination="payrolls" calling-method="setNewPayroll" data-type="">
                    <div class="row">  
                        
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Code Fortnight</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="codeFortnight">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" placeholder="Enter ..." name="startDate">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" placeholder="Enter ..." name="endDate">
                        </div>
                     </div> 
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Payroll IHSS</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="payrollIhss">
                            <input type="checkbox" name="ihssCheckbox" id="ihssCheckbox">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Payroll RAP FIO PISO</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="payrollRapFioPiso">
                            <input type="checkbox" name="rapFioPisoCheckbox" id="rapFioPisoCheckbox">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Payroll RAP FIO</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="payrollRapFio">
                            <input type="checkbox" name="rapFioCheckbox" id="rapFioCheckbox">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Payroll ISR</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="payrollIsr">
                            <input type="checkbox" name="isrCheckbox" id="isrCheckbox">
                        </div>
                     </div> 
                        
                    </div>          
                    <button type="submit" id="send-payroll" class="btn btn-success btn-block">Guardar Planilla</button>
                </form> 
            </div>
            <div class="card-footer">
                Footer
            </div>  
            </div>    
     

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
                        <th scope="col">Identity</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Email</th>
                        <th scope="col">Profile Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($payrolls as $row): ?>
                        <tr>
                            <td><?php echo $row['payrollId']; ?></td>
                            <td scope="row"><?php echo $row['codeFortnight']; ?></td>
                            <td><?php echo $row['startDate']; ?> <?php echo $row['endDate']; ?></td>
                            <td><?php echo $row['payrollCreationDate']; ?></td>
                            <td><a href="<?php echo router(); ?>payrolls/overview/<?php echo $row['payrollId']; ?>">Crear</a></td>
                            <td><a href="<?php echo router(); ?>payrolls/compliance/<?php echo $row['payrollId']; ?>">Compliance</a></td>

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