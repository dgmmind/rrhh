<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Pivot Dinámica PUSHGIT ADD .
    GIT COMMIT -M</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Tabla Dinámica (Pivot) con Datos</h1>

<div>
    <label for="rows">Selecciona filas:</label>
    <select id="rows" multiple onchange="generatePivot()"></select>
</div>

<div>
    <label for="columns">Selecciona columnas:</label>
    <select id="columns" multiple onchange="generatePivot()"></select>
</div>

<div>
    <label for="values">Selecciona valores:</label>
    <select id="values" multiple onchange="generatePivot()"></select>
</div>

<h2>Tabla Pivot Generada</h2>
<div id="pivotTable"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>

<script>
    // Datos proporcionados
    const data = [
        { "first_name": "Ana", "last_name": "Barravino", "project": "Debt - C2C Koji - Sp", "phone": "5595742025", "company": "HFG 2020", "state": "CA", "amount": "$11,526.00" },
        { "first_name": "Ignacio", "last_name": "Paredes", "project": "English LT- 02", "phone": "4806130966", "company": "DMB", "state": "AZ", "amount": "$11,689.21" },
        { "first_name": "Yohn", "last_name": "Gutierrez", "project": "Debt C2C SP - HFG - MP", "phone": "4045572942", "company": "SIBERT", "state": "GA", "amount": "$26,115.00" },
        { "first_name": "Kwame", "last_name": "Moorer", "project": "Debt C2C - HFG - MP", "phone": "4696165483", "company": "DMB", "state": "TX", "amount": "$12,076.00" },
        { "first_name": "Rebeca", "last_name": "Lombardi", "project": "Debt - C2C Koji - Sp", "phone": "9703555990", "company": "SIBERT", "state": "CO", "amount": "$25,713.00" },
        { "first_name": "Alberto", "last_name": "conde", "project": "Debt C2C SP - HFG - MP", "phone": "2132781196", "company": "DMB", "state": "CA", "amount": "$14,507.00" },
        { "first_name": "Angel", "last_name": "Perez", "project": "Debt - C2C Koji - Sp", "phone": "9097469887", "company": "DMB", "state": "CA", "amount": "$14,596.00" },
        { "first_name": "Altan", "last_name": "Erskine", "project": "Debt C2C - HFG - MP", "phone": "6619024349", "company": "DMB", "state": "CA", "amount": "$15,395.00" },
        { "first_name": "Ana", "last_name": "Barravino", "project": "Debt - C2C Koji - Sp", "phone": "6465152234", "company": "DMB", "state": "NY", "amount": "$17,323.00" },
        { "first_name": "Mario", "last_name": "Stewart", "project": "Debt C2C - HFG - Fitz", "phone": "3144896983", "company": "DMB", "state": "MO", "amount": "$19,854.00" },
        { "first_name": "William", "last_name": "King", "project": "Debt C2C - HFG - MP", "phone": "3055041072", "company": "DMB", "state": "FL", "amount": "$35,045.00" },
        { "first_name": "Alberto", "last_name": "Conde", "project": "referral", "phone": "2134548275", "company": "DMB", "state": "CA", "amount": "$11,886.01" },
        { "first_name": "Carmelina", "last_name": "Lopez", "project": "Debt - C2C Koji - Sp", "phone": "7863328965", "company": "DMB", "state": "FL", "amount": "$15,426.00" },
        { "first_name": "Claudia", "last_name": "Moreno", "project": "Debt - C2C Koji - Sp", "phone": "8315245830", "company": "DMB", "state": "TX", "amount": "$11,903.00" },
        { "first_name": "Carmelina", "last_name": "Lopez", "project": "Debt C2C - Avanto SP", "phone": "4028139070", "company": "DMB", "state": "NE", "amount": "$34,553.10" },
        { "first_name": "William", "last_name": "King", "project": "Debt C2C - HFG - MP", "phone": "3364560919", "company": "DMB", "state": "NC", "amount": "$20,202.00" }
    ];

    // Función para llenar los select con las opciones
    function populateSelectors() {
        const keys = Object.keys(data[0]);

        const rowSelect = document.getElementById("rows");
        const columnSelect = document.getElementById("columns");
        const valueSelect = document.getElementById("values");

        keys.forEach(key => {
            let option = document.createElement("option");
            option.value = key;
            option.textContent = key;
            rowSelect.appendChild(option);
            columnSelect.appendChild(option.cloneNode(true));
            valueSelect.appendChild(option.cloneNode(true));
        });
    }

    // Función para generar la tabla dinámica
    // Función para generar la tabla dinámica
    function generatePivot() {
        const rows = Array.from(document.getElementById("rows").selectedOptions).map(option => option.value);
        const columns = Array.from(document.getElementById("columns").selectedOptions).map(option => option.value);
        const values = Array.from(document.getElementById("values").selectedOptions).map(option => option.value);

        const groupedData = _.groupBy(data, item => {
            return rows.map(row => item[row]).join('-');
        });

        const pivotTable = {};

        // Si se seleccionaron solo filas, mostrar los datos de las filas
        if (rows.length > 0 && columns.length === 0 && values.length === 0) {
            renderRows(groupedData);
            return;
        }

        // Crear la estructura de la tabla pivote si hay columnas y valores seleccionados
        Object.keys(groupedData).forEach(rowKey => {
            const group = groupedData[rowKey];
            columns.forEach(column => {
                const columnValues = _.groupBy(group, item => item[column]);
                Object.keys(columnValues).forEach(colKey => {
                    pivotTable[rowKey] = pivotTable[rowKey] || {};
                    pivotTable[rowKey][colKey] = columnValues[colKey].reduce((sum, item) => {
                        // Comprobar que el valor existe y es un número antes de intentar sumarlo
                        const value = item[values[0]];
                        if (value && !isNaN(value.replace(/[^\d.-]/g, ''))) {
                            return sum + parseFloat(value.replace(/[^\d.-]/g, ''));
                        }
                        return sum;
                    }, 0);
                });
            });
        });

        // Renderizar la tabla generada
        renderPivotTable(pivotTable);
    }


    // Función para renderizar solo filas
    function renderRows(groupedData) {
        const tableContainer = document.getElementById("pivotTable");
        tableContainer.innerHTML = ""; // Limpiar tabla existente

        const table = document.createElement("table");
        const thead = document.createElement("thead");
        const tbody = document.createElement("tbody");

        // Crear la cabecera de la tabla
        const headerRow = document.createElement("tr");
        const rowHeader = document.createElement("th");
        rowHeader.textContent = "Filas";
        headerRow.appendChild(rowHeader);
        thead.appendChild(headerRow);

        // Crear las filas de datos
        Object.keys(groupedData).forEach(rowKey => {
            const tr = document.createElement("tr");
            const th = document.createElement("th");
            th.textContent = rowKey;
            tr.appendChild(th);
            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    // Función para renderizar la tabla generada
    function renderPivotTable(pivotTable) {
        const tableContainer = document.getElementById("pivotTable");
        tableContainer.innerHTML = ""; // Limpiar tabla existente

        const table = document.createElement("table");
        const thead = document.createElement("thead");
        const tbody = document.createElement("tbody");

        // Crear la cabecera de la tabla
        const headerRow = document.createElement("tr");
        const rowHeader = document.createElement("th");
        rowHeader.textContent = "Filas/Columnas";
        headerRow.appendChild(rowHeader);

        const columns = Object.keys(pivotTable).reduce((cols, rowKey) => {
            Object.keys(pivotTable[rowKey]).forEach(colKey => {
                if (!cols.includes(colKey)) cols.push(colKey);
            });
            return cols;
        }, []);

        columns.forEach(col => {
            const th = document.createElement("th");
            th.textContent = col;
            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);

        // Crear las filas de datos
        Object.keys(pivotTable).forEach(rowKey => {
            const tr = document.createElement("tr");
            const th = document.createElement("th");
            th.textContent = rowKey;
            tr.appendChild(th);

            columns.forEach(col => {
                const td = document.createElement("td");
                td.textContent = pivotTable[rowKey][col] || 0;
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    // Inicializar selectores
    populateSelectors();
</script>

</body>
</html>
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
        <form action="#" class="form-data" id="create-details" data-destination="payrolls" calling-method="updatePayroll" data-type="">
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
                    <input type="hidden" name="payrollId" value="<?php echo $payroll['payrollId']; ?>">
                    <table class="table db-table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Código Planilla</th>
                            <th scope="col">Código Quincena</th>
                            <th scope="col">Código Colaborador</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">No. DNI</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Cuenta</th>
                            <th scope="col">Sueldo Mensual</th>
                            <th scope="col">Sueldo Base Quincenal</th>
                            <th scope="col">Comisiones</th>
                            <th scope="col">Bonificaciones</th>
                            <th scope="col">Otros Ingresos</th>
                            <th scope="col">Total Ingresos</th>
                            <th scope="col" colspan="2">Dias Faltados</th>
                            <th scope="col">Otras deducciones</th>
                            <th scope="col">
                                IHSS
                                <input type="checkbox" id="checkedIhss">
                            </th>
                            <th scope="col">RAP FIO Piso</th>
                            <th scope="col">RAP FIO</th>
                            <th scope="col">ISR</th>
                            <th scope="col">Total deducciones</th>
                            <th scope="col">Total Quincena</th>
                            <th scope="col">Notes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        $employees = $payroll['employees'];
                        for ($i=0; $i < count($employees); $i++) {
                            $details = $employees[$i]['details'];
                            $employeeId = $details['employeeId'] ?? $employees[$i]['employeeId'];
                            $bankName = $details['bankName'] ?? $employees[$i]['bankName'];
                            $accountNumber = $details['accountNumber'] ?? $employees[$i]['accountNumber'];
                            $monthlySalary = $details['monthlySalary'] ?? $employees[$i]['monthlySalary'];

                            $biweeklyBaseSalary = $monthlySalary /2;

                            $commissions = $details['commissions'];
                            $bonuses = $details['bonuses'];
                            $otherIncome = $details['otherIncome'];

                            $totalRevenue =  $biweeklyBaseSalary +$commissions +$bonuses +$otherIncome;

                            $daysAbsent = $details['daysAbsent'];
                            $deductionLostDays = round($monthlySalary / 30 * $daysAbsent, 2);
                            $otherDeductions = $details['otherDeductions'];
                            $ihss = $details['ihss'];
                            $rapFioPiso = $details['rapFioPiso'];
                            $rapFio = $details['rapFio'];
                            $isr = $details['isr'];
                            $notes = $details['notes'];
                            $totalDeductions = $deductionLostDays + $otherDeductions + $ihss + $rapFioPiso + $rapFio + $isr;
                            $totalFortnight = $totalRevenue - $totalDeductions;

                            //debug($details);
                            //echo "commissions".$employeeId ;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $n; ?>
                                    <input type="hidden" value="<?php echo $employeeId; ?>" name="employee[<?php echo $i?>][employeeId]">
                                </td>
                                <td><?php echo $details['codeFortnight']; ?><?php echo $employees[$i]['employeeCode']; ?></td>
                                <td><?php echo $details['codeFortnight']; ?></td>
                                <td><?php echo $employees[$i]['employeeCode']; ?></td>
                                <td><?php echo $employees[$i]['profileNames']; ?></td>
                                <td><?php echo $employees[$i]['profileIdentity']; ?></td>
                                <td><input type="text" class="form-control form-control-db" value="<?php echo $bankName; ?>" name="employee[<?php echo $i?>][bankName]"></td>
                                <td><input type="text" class="form-control form-control-db" value="<?php echo $accountNumber; ?>" name="employee[<?php echo $i?>][accountNumber]"></td>
                                <td><input class="monthly-salary form-control form-control-db" type="text" value="<?php echo $monthlySalary; ?>" name="employee[<?php echo $i?>][monthlySalary]"></td>
                                <td><input class="biweekly-base- form-control form-control-db" type="text" value="<?php echo $biweeklyBaseSalary; ?>"></td>
                                <td><input class="commissions form-control form-control-db" type="text" value="<?php echo $commissions; ?>" name="employee[<?php echo $i?>][commissions]"></td>
                                <td><input class="bonuses form-control form-control-db" type="text" value="<?php echo $bonuses; ?>" name="employee[<?php echo $i?>][bonuses]"></td>

                                <td><input class="other-income form-control form-control-db" type="text" value="<?php echo $otherIncome; ?>" name="employee[<?php echo $i?>][otherIncome]"></td>
                                <td><input class="total-revenue form-control form-control-db" type="text" value="<?php echo $totalRevenue; ?>"></td>
                                <td><input class="days-absent form-control form-control-db" type="text" value="<?php echo $daysAbsent; ?>" name="employee[<?php echo $i?>][daysAbsent]"></td>
                                <td><input class="deduction-lost-days form-control form-control-db" type="text" value="<?php echo $deductionLostDays; ?>"></td>
                                <td><input class="other-deductions form-control form-control-db" type="text" value="<?php echo $otherDeductions; ?>" name="employee[<?php echo $i?>][otherDeductions]"></td>

                                <td><input class="ihss form-control form-control-db" type="text" data-value="ihss" value="<?php echo $ihss; ?>" name="employee[<?php echo $i?>][ihss]"></td>

                                <td><input class="rap-fio-piso form-control form-control-db" type="text" value="<?php echo $rapFioPiso; ?>" name="employee[<?php echo $i?>][rapFioPiso]"></td>
                                <td><input class="rap-fio form-control form-control-db" type="text" value="<?php echo $rapFio; ?>" name="employee[<?php echo $i?>][rapFio]"></td>
                                <td><input class="isr form-control form-control-db" type="text" value="<?php echo $isr; ?>" name="employee[<?php echo $i?>][isr]"></td>
                                <td><input class="total-deductions form-control form-control-db" type="text" value="<?php echo $totalDeductions; ?>"></td>
                                <td><input class="total-fort-night form-control form-control-db" type="text" value="<?php echo $totalFortnight; ?>"></td>
                                <td><input class="notes form-control form-control-db" type="text" value="<?php echo $notes; ?>" name="employee[<?php echo $i?>][notes]"></td>
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
<script>
    const valueCalculateRapFio = 0.015;
    const valueCalculateIhss = 561.14;

    const valueCalculateIsr = 20986.03;

    const checkedIhss = document.getElementById("checkedIhss");
    const checkedIsr = document.getElementById("checkedIsr");
    const checkedRapFio = document.getElementById("checkedRapFio");

    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const elements = {
                baseSalary: row.querySelector('.monthly-salary'),
                commissions: row.querySelector('.commissions'),
                bonuses: row.querySelector('.bonuses'),
                otherIncome: row.querySelector('.other-income'),
                totalRevenue: row.querySelector('.total-revenue'),
                daysAbsent: row.querySelector('.days-absent'),
                deductionLostDays: row.querySelector('.deduction-lost-days'),
                otherDeductions: row.querySelector('.other-deductions'),
                ihss: row.querySelector('.ihss'),
                rapFioPiso: row.querySelector('.rap-fio-piso'),
                rapFio: row.querySelector('.rap-fio'),
                isr: row.querySelector('.isr'),
                totalDeductions: row.querySelector('.total-deductions'),
                totalFortNight: row.querySelector('.total-fort-night'),
            };
            checkedIhss.addEventListener("change", () => {
                elements.ihss.value=100;
            });
            const getBaseSalary = () => parseFloat(elements.baseSalary.value) || 0;

            const recalculateTotal = () => {
                const commissionValue = parseFloat(elements.commissions.value) || 0;
                const bonusValue = parseFloat(elements.bonuses.value) || 0;
                const otherIncomeValue = parseFloat(elements.otherIncome.value) || 0;
                elements.totalRevenue.value = (getBaseSalary() / 2 + commissionValue + bonusValue + otherIncomeValue).toFixed(2);
            };

            const recalculateDaysAbsentDeduction = () => {
                const daysAbsentValue = parseFloat(elements.daysAbsent.value) || 0;
                elements.deductionLostDays.value = ((getBaseSalary() / 30) * daysAbsentValue).toFixed(2);
            };

            const recalculateTotalDeductions = () => {
                recalculateDaysAbsentDeduction();

                const deductionLostDaysValue = parseFloat(elements.deductionLostDays.value) || 0;
                const otherDeductionsValue = parseFloat(elements.otherDeductions.value) || 0;
                const ihssValue = parseFloat(elements.ihss.value) || 0;
                const rapFioPisoValue = parseFloat(elements.rapFioPiso.value) || 0;
                const rapFioValue = parseFloat(elements.rapFio.value) || 0;
                const isrValue = parseFloat(elements.isr.value) || 0;

                elements.totalDeductions.value = (
                    deductionLostDaysValue +
                    otherDeductionsValue +
                    ihssValue +
                    rapFioPisoValue +
                    rapFioValue +
                    isrValue
                ).toFixed(2);
            };

            const recalculateAll = () => {
                recalculateTotal();
                recalculateTotalDeductions();

                const totalRevenueValue = parseFloat(elements.totalRevenue.value) || 0;
                const totalDeductionsValue = parseFloat(elements.totalDeductions.value) || 0;

                elements.totalFortNight.value = (totalRevenueValue - totalDeductionsValue).toFixed(2);
            };

            // Agregar eventos a los campos relevantes
            const inputsToWatch = [
                elements.commissions,
                elements.bonuses,
                elements.otherIncome,
                elements.daysAbsent,
                elements.otherDeductions,
                elements.ihss,
                elements.rapFioPiso,
                elements.rapFio,
                elements.isr,
            ];

            inputsToWatch.forEach(input => input.addEventListener('input', recalculateAll));
        });
    });

</script>

<script>
    /*
    const payrollId = <?= json_encode($data["payrollId"]) ?>;
    const form = document.getElementById('create-details');

    // Escuchar el evento de envío del formulario
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío por defecto del formulario

        // Capturar los datos del formulario en este punto
        const formData = new FormData(form);
        const obj = Object.fromEntries(formData.entries());

        fetch('http://localhost/insider/payrolls/setDetails/' + payrollId, {
            method: 'POST', // Método de envío
            body: formData, // Datos del formulario
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Procesar la respuesta como JSON
            })
            .then((data) => {
                console.log('Success:', data);
                // Opcional: Puedes mostrar un mensaje de éxito en la interfaz
            })
            .catch((error) => {
                console.error('Error:', error);
                // Opcional: Mostrar un mensaje de error en la interfaz
            });
    });
*/
</script>
