<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>

<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Planilla</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Array
(
    [payrollId] => 3
    [codeFortnight] => 010825
    [startDate] => 2025-08-01
    [endDate] => 2025-08-15
    [payrollIhss] => 595.16
    [ihssChecked] => 0
    [payrollRapFioPiso] => 11903.13
    [rapFioPisoChecked] => 0
    [payrollRapFio] => 0.015
    [rapFioChecked] => 0
    [payrollIsr] => 0
    [isrChecked] => 0
    [payrollCreationDate] => 2025-08-12 10:55:53
) -->
        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">SEMANA <?php echo $data1['startDate']; ?> - <?php echo $data1['endDate']; ?></h3>

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
                   
<?php
    $payroll = $data1;
    $detailPayroll = $data2;

    //debug($payroll);
   // debug($detailPayroll);
?>
                    <!--
    [0] => Array
        (
            [payrollDetailId] => 677
            [payrollId] => 1
            [employeeId] => 82
            [bankName] => BAC
            [accountNumber] => 213000317130
            [biweeklyBaseSalary] => 8875.00
            [commissions] => 0.00
            [bonuses] => 0.00
            [otherIncome] => 0.00
            [daysAbsent] => 0
            [otherDeductions] => 0.00
            [ihss] => 0.00
            [rapFioPiso] => 0.00
            [rapFio] => 0.00
            [isr] => 0.00
            [notes] => 0
            [payrollDetailsCreationDate] => 2025-08-18 22:51:31
            [codeFortnight] => 010825
            [startDate] => 2025-08-01
            [endDate] => 2025-08-15
            [payrollIhss] =>  595.16
            [ihssChecked] => 0
            [payrollRapFioPiso] => 11903.13
            [rapFioPisoChecked] => 0
            [payrollRapFio] => 0.015
            [rapFioChecked] => 0
            [payrollIsr] => 0
            [isrChecked] => 0
            [payrollCreationDate] => 2025-08-14 23:34:03
        )
-->
<!--No.	Nombre	DNI	Banco	Cuenta	TIPO DE CUENTA	"Sueldo
Mensual"	Sueldo Quincenal	 Deducciones  							Total Quincena
								Dias Faltados		Otras deducciones	IHSS	RAP	ISR		-->
                                <?php
// Función para formatear moneda Lempira
function formatLempira($valor) {
    return 'L. ' . number_format($valor, 2, '.', ',');
}
?>

<section class="table-section" aria-label="Tabla minimalista">
  <div class="table-wrap" role="region">
    <table class="mini-table">
      <thead>
        <tr>
          <th colspan="10">Detalles de la planilla</th>
          <th colspan="4">Deducciones</th>
          <th colspan="2">Totales</th>
        </tr>
        <tr>
          <th>No.</th>
          <th>Nombre</th>
          <th>DNI</th>
          <th>Banco</th>
          <th>Cuenta</th>
          <th>Tipo de Cuenta</th>
          <th>Sueldo Mensual</th>
          <th>Sueldo Quincenal</th>
          <th colspan="2">Dias Faltados</th>
          <th>Otras Deducciones</th>
          <th>IHSS</th>
          <th>RAP</th>
          <th>ISR</th>
          <th>Total Deducciones</th>
          <th>Total Quincena</th>
        </tr>
      </thead>

      <tbody>
      <?php
        // Inicializar totales
        $totalMonthlySalary = 0;
        $totalBiweeklySalary = 0;
        $totalDaysAbsent = 0;
        $totalDaysAbsentAmount = 0;
        $totalOtherDeductions = 0;
        $totalIhss = 0;
        $totalRap = 0;
        $totalIsr = 0;
        $totalDeductions = 0;
        $totalBiweeklyNet = 0;

        foreach ($detailPayroll as $detail) {
            // Cálculos por fila
            $biweeklyMonthly = $detail['biweeklyBaseSalary'] * 2;
            $totalDaysAbsentRow = round($detail['biweeklyBaseSalary'] / 15 * $detail['daysAbsent'], 2);
            $totalDeductionsRow = $totalDaysAbsentRow + $detail['otherDeductions'] + $detail['ihss'] + $detail['rapFio'] + $detail['isr'];
            $totalQuincenaRow = $detail['biweeklyBaseSalary'] - $totalDeductionsRow;

            // Acumular totales
            $totalMonthlySalary += $biweeklyMonthly;
            $totalBiweeklySalary += $detail['biweeklyBaseSalary'];
            $totalDaysAbsent += $detail['daysAbsent'];
            $totalDaysAbsentAmount += $totalDaysAbsentRow;
            $totalOtherDeductions += $detail['otherDeductions'];
            $totalIhss += $detail['ihss'];
            $totalRap += $detail['rapFio'];
            $totalIsr += $detail['isr'];
            $totalDeductions += $totalDeductionsRow;
            $totalBiweeklyNet += $totalQuincenaRow;

            // Imprimir fila
            echo "<tr>
                    <td>{$detail['employeeId']}</td>
                    <td>{$detail['employeeId']}</td>
                    <td>{$detail['employeeId']}</td>
                    <td>{$detail['bankName']}</td>
                    <td>{$detail['accountNumber']}</td>
                    <td>Ahorro</td>
                    <td>" . formatLempira($biweeklyMonthly) . "</td>
                    <td>" . formatLempira($detail['biweeklyBaseSalary']) . "</td>
                    <td>{$detail['daysAbsent']}</td>
                    <td>" . formatLempira($totalDaysAbsentRow) . "</td>
                    <td>" . formatLempira($detail['otherDeductions']) . "</td>
                    <td>" . formatLempira($detail['ihss']) . "</td>
                    <td>" . formatLempira($detail['rapFio']) . "</td>
                    <td>" . formatLempira($detail['isr']) . "</td>
                    <td>" . formatLempira($totalDeductionsRow) . "</td>
                    <td>" . formatLempira($totalQuincenaRow) . "</td>
                  </tr>";
        }
      ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="6"><strong>Totales</strong></td>
          <td><strong><?php echo formatLempira($totalMonthlySalary); ?></strong></td>
          <td><strong><?php echo formatLempira($totalBiweeklySalary); ?></strong></td>
          <td><strong><?php echo $totalDaysAbsent; ?></strong></td>
          <td><strong><?php echo formatLempira($totalDaysAbsentAmount); ?></strong></td>
          <td><strong><?php echo formatLempira($totalOtherDeductions); ?></strong></td>
          <td><strong><?php echo formatLempira($totalIhss); ?></strong></td>
          <td><strong><?php echo formatLempira($totalRap); ?></strong></td>
          <td><strong><?php echo formatLempira($totalIsr); ?></strong></td>
          <td><strong><?php echo formatLempira($totalDeductions); ?></strong></td>
          <td><strong><?php echo formatLempira($totalBiweeklyNet); ?></strong></td>
        </tr>
      </tfoot>
    </table>
  </div>
</section>


<style>
  :root {
    --bg: #fff;
    --fg: #0f172a;
    --muted: #e2e8f0;
    --muted-2: #f8fafc;
    --row-h: 36px;
    --fs-0: 14px;
    --radius: 12px;
  }

  .table-section { 
    font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial; 
    color: var(--fg);
    background: var(--bg);
    padding: 12px; 
  }

  .table-wrap { overflow-x: auto; border: 1px solid var(--muted); border-radius: var(--radius); }

  table { width: 100%; border-collapse: collapse; font-size: var(--fs-0); min-width: 600px; }
  thead th { position: sticky; top: 0; background: var(--muted-2); text-align: left; font-weight: 700; padding: 8px 10px; border: 1px solid var(--muted); white-space: nowrap; }
  tbody td { height: var(--row-h); padding: 6px 10px; border: 1px solid var(--muted); white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
  tbody tr:nth-child(even) { background: #fafafa; }

  @media (max-width: 600px) {
    :root { --fs-0: 13px; --row-h: 32px; }
    thead th, tbody td { padding: 6px 8px; }
    table { min-width: 400px; }
  }
</style>

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
    <!-- /.content-wrapper -->
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>