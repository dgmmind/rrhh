<?php
// Simulando los datos que recibirías
$payroll = [
    'payrollId' => 2,
    'codeFortnight' => '020825',
    'startDate' => '2025-08-16',
    'endDate' => '2025-08-30',
    'payrollIhss' => 595.16,
    'ihssChecked' => 1,
    'payrollRapFioPiso' => 11903.13,
    'rapFioPisoChecked' => 1,
    'payrollRapFio' => 0.015,
    'rapFioChecked' => 1,
    'payrollIsr' => 0,
    'isrChecked' => 1,
    'payrollCreationDate' => '2025-08-14 23:34:03'
];

$detailPayroll = [
    [
        'payrollDetailId' => 641,
        'employeeId' => 82,
        'employeeName' => 'Ericka Daniela Martinez',
        'dni' => '0801-1999-10071',
        'bankName' => 'BAC',
        'accountNumber' => '746392181',
        'biweeklyBaseSalary' => 17750.00,
        'commissions' => 0.00,
        'bonuses' => 0.00,
        'otherIncome' => 0.00,
        'daysAbsent' => 0,
        'otherDeductions' => 0.00,
        'ihss' => 595.16,
        'rapFioPiso' => 11903.13,
        'rapFio' => 87.70,
        'isr' => 0.00
    ],
    [
        'payrollDetailId' => 642,
        'employeeId' => 83,
        'employeeName' => 'Evelin Daniela Oseguera Aguilar',
        'dni' => '0801-2001-04394',
        'bankName' => 'BANPAIS',
        'accountNumber' => '213000317181',
        'biweeklyBaseSalary' => 17500.00,
        'commissions' => 0.00,
        'bonuses' => 0.00,
        'otherIncome' => 0.00,
        'daysAbsent' => 1,
        'otherDeductions' => 583.33,
        'ihss' => 595.16,
        'rapFioPiso' => 11903.13,
        'rapFio' => 83.95,
        'isr' => 0.00
    ],
    [
        'payrollDetailId' => 643,
        'employeeId' => 84,
        'employeeName' => 'Astrid Mariela Colindres Zelaya',
        'dni' => '0801-1999-10070',
        'bankName' => 'BAC',
        'accountNumber' => '746030901',
        'biweeklyBaseSalary' => 17750.00,
        'commissions' => 0.00,
        'bonuses' => 0.00,
        'otherIncome' => 0.00,
        'daysAbsent' => 0,
        'otherDeductions' => 0.00,
        'ihss' => 595.16,
        'rapFioPiso' => 11903.13,
        'rapFio' => 87.70,
        'isr' => 0.00
    ]
];

// Calcular totales
$totalSalaries = 0;
$totalDeductions = 0;
$totalNet = 0;

foreach ($detailPayroll as $employee) {
    $grossSalary = $employee['biweeklyBaseSalary'] + $employee['commissions'] + $employee['bonuses'] + $employee['otherIncome'];
    $deductions = $employee['ihss'] + $employee['rapFio'] + $employee['isr'] + $employee['otherDeductions'];
    $netSalary = $grossSalary - $deductions;
    
    $totalSalaries += $grossSalary;
    $totalDeductions += $deductions;
    $totalNet += $netSalary;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Nómina - <?php echo $payroll['codeFortnight']; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .header-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }

        .config-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .config-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .config-item {
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .config-item label {
            display: block;
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .config-item input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            background: white;
            color: #374151;
        }

        .config-item input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .checkbox-item input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .employees-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .table-header {
            background: #f1f5f9;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-content {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.875rem;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        td {
            color: #4b5563;
        }

        .employee-name {
            font-weight: 600;
            color: #0f172a;
        }

        .amount {
            text-align: right;
            font-family: 'SF Mono', Monaco, monospace;
            font-weight: 500;
        }

        .amount.positive {
            color: #059669;
        }

        .amount.negative {
            color: #dc2626;
        }

        .totals-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .total-item {
            text-align: center;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .total-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'SF Mono', Monaco, monospace;
        }

        .total-value.salary {
            color: #059669;
        }

        .total-value.deduction {
            color: #dc2626;
        }

        .total-value.net {
            color: #0f172a;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header-info {
                grid-template-columns: 1fr;
            }
            
            .config-grid {
                grid-template-columns: 1fr;
            }
            
            .totals-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Configuración de Nómina</h1>
            <div class="header-info">
                <div class="info-item">
                    <span class="info-label">Código Quincena</span>
                    <span class="info-value"><?php echo $payroll['codeFortnight']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha Inicio</span>
                    <span class="info-value"><?php echo date('d/m/Y', strtotime($payroll['startDate'])); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha Fin</span>
                    <span class="info-value"><?php echo date('d/m/Y', strtotime($payroll['endDate'])); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">ID Nómina</span>
                    <span class="info-value">#<?php echo $payroll['payrollId']; ?></span>
                </div>
            </div>
        </div>

        <!-- Configuración Global -->
        <div class="config-section">
            <h2 class="section-title">Configuración de Deducciones</h2>
            <div class="config-grid">
                <div class="config-item">
                    <label>IHSS</label>
                    <input type="number" step="0.01" value="<?php echo $payroll['payrollIhss']; ?>" readonly>
                    <div class="checkbox-item">
                        <input type="checkbox" <?php echo $payroll['ihssChecked'] ? 'checked' : ''; ?> disabled>
                        <span>Aplicar IHSS</span>
                    </div>
                </div>
                <div class="config-item">
                    <label>RAP/FIO Piso</label>
                    <input type="number" step="0.01" value="<?php echo $payroll['payrollRapFioPiso']; ?>" readonly>
                    <div class="checkbox-item">
                        <input type="checkbox" <?php echo $payroll['rapFioPisoChecked'] ? 'checked' : ''; ?> disabled>
                        <span>Aplicar RAP/FIO Piso</span>
                    </div>
                </div>
                <div class="config-item">
                    <label>RAP/FIO (%)</label>
                    <input type="number" step="0.001" value="<?php echo $payroll['payrollRapFio']; ?>" readonly>
                    <div class="checkbox-item">
                        <input type="checkbox" <?php echo $payroll['rapFioChecked'] ? 'checked' : ''; ?> disabled>
                        <span>Aplicar RAP/FIO</span>
                    </div>
                </div>
                <div class="config-item">
                    <label>ISR</label>
                    <input type="number" step="0.01" value="<?php echo $payroll['payrollIsr']; ?>" readonly>
                    <div class="checkbox-item">
                        <input type="checkbox" <?php echo $payroll['isrChecked'] ? 'checked' : ''; ?> disabled>
                        <span>Aplicar ISR</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Empleados -->
        <div class="employees-table">
            <div class="table-header">
                <h2 class="section-title" style="margin: 0; padding: 0; border: none;">Detalle de Empleados</h2>
            </div>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Banco</th>
                            <th>Cuenta</th>
                            <th>Sueldo Base</th>
                            <th>Días Faltados</th>
                            <th>IHSS</th>
                            <th>RAP/FIO</th>
                            <th>ISR</th>
                            <th>Otras Deduc.</th>
                            <th>Total Deduc.</th>
                            <th>Neto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detailPayroll as $index => $employee): 
                            $grossSalary = $employee['biweeklyBaseSalary'] + $employee['commissions'] + $employee['bonuses'] + $employee['otherIncome'];
                            $totalEmployeeDeductions = $employee['ihss'] + $employee['rapFio'] + $employee['isr'] + $employee['otherDeductions'];
                            $netSalary = $grossSalary - $totalEmployeeDeductions;
                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td class="employee-name"><?php echo $employee['employeeName']; ?></td>
                            <td><?php echo $employee['dni']; ?></td>
                            <td><?php echo $employee['bankName']; ?></td>
                            <td><?php echo $employee['accountNumber']; ?></td>
                            <td class="amount positive">L.<?php echo number_format($grossSalary, 2); ?></td>
                            <td><?php echo $employee['daysAbsent']; ?></td>
                            <td class="amount negative">L.<?php echo number_format($employee['ihss'], 2); ?></td>
                            <td class="amount negative">L.<?php echo number_format($employee['rapFio'], 2); ?></td>
                            <td class="amount negative">L.<?php echo number_format($employee['isr'], 2); ?></td>
                            <td class="amount negative">L.<?php echo number_format($employee['otherDeductions'], 2); ?></td>
                            <td class="amount negative">L.<?php echo number_format($totalEmployeeDeductions, 2); ?></td>
                            <td class="amount positive">L.<?php echo number_format($netSalary, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totales -->
        <div class="totals-section">
            <h2 class="section-title">Resumen de Totales</h2>
            <div class="totals-grid">
                <div class="total-item">
                    <div class="total-label">Total Salarios Brutos</div>
                    <div class="total-value salary">L.<?php echo number_format($totalSalaries, 2); ?></div>
                </div>
                <div class="total-item">
                    <div class="total-label">Total Deducciones</div>
                    <div class="total-value deduction">L.<?php echo number_format($totalDeductions, 2); ?></div>
                </div>
                <div class="total-item">
                    <div class="total-label">Total Neto a Pagar</div>
                    <div class="total-value net">L.<?php echo number_format($totalNet, 2); ?></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad adicional si es necesaria
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Formulario de configuración de nómina cargado');
            
            // Agregar interactividad si es necesaria
            const configInputs = document.querySelectorAll('.config-item input');
            configInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.borderColor = '#3b82f6';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.borderColor = '#e2e8f0';
                });
            });
        });
    </script>
</body>
</html>
