<!--== #HEADER ==-->
<?php /** @var Payrolls $data */
adminHeader($data); ?>
<!--== #NAV ==-->
<?php adminNav($data); ?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
        table-layout: auto;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
        text-align: center;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    input {
        width: 100px; /* Asegura que el input ocupe todo el espacio disponible en la celda */
        box-sizing: border-box; /* Incluye padding y borde en el ancho total */
    }
</style>

<h1>Planilla Detallada</h1>
<form action="" id="create-details">
    <input type="text" name="payrollId" value="<?php echo $data1['payrollId']; ?>">

    <table>
        <thead>
        <tr>
            <th>No.</th>
            <th>Código Planilla</th>
            <th>Código Quincena</th>
            <th>Código Colaborador</th>
            <th>Nombre</th>
            <th>No. DNI</th>
            <th>Banco</th>
            <th>Cuenta</th>
            <th>Sueldo Mensual</th>
            <th>Sueldo Base Quincenal</th>
            <th>Comisiones</th>
            <th>Bonificaciones</th>
            <th>Otros Ingresos</th>
            <th>Total Ingresos</th>
            <th colspan="2">Dias Faltados</th>
            <th>Otras deducciones</th>
            <th>IHSS</th>
            <th>RAP FIO Piso</th>
            <th>RAP FIO</th>
            <th>ISR</th>
            <th>Total deducciones</th>
            <th>Total Quincena</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n=1;
        /** @var Permissions $data1 */
        $employees = $data1['employees'];
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
                    <input type="text" value="<?php echo $employeeId; ?>" name="employee[<?php echo $i?>][employeeId]"<?php echo $employeeId; ?>>
                </td>
                <td><?php echo $details['codeFortnight']; ?><?php echo $employees[$i]['employeeCode']; ?></td>
                <td><?php echo $details['codeFortnight']; ?></td>
                <td><?php echo $employees[$i]['employeeCode']; ?></td>
                <td><?php echo $employees[$i]['profileNames']; ?></td>
                <td><?php echo $employees[$i]['profileIdentity']; ?></td>
                <td><input type="text" value="<?php echo $bankName; ?>" name="employee[<?php echo $i?>][bankName]"<?php echo $bankName; ?>></td>
                <td><input type="text" value="<?php echo $accountNumber; ?>" name="employee[<?php echo $i?>][accountNumber]"<?php echo $accountNumber; ?>></td>
                <td><input class="monthly-salary" type="text" value="<?php echo $monthlySalary; ?>" name="employee[<?php echo $i?>][monthlySalary]"<?php echo $monthlySalary; ?>></td>
                <td><input class="biweekly-base-salary" type="text" value="<?php echo $biweeklyBaseSalary; ?>"></td>
                <td><input class="commissions" type="text" value="<?php echo $commissions; ?>" name="employee[<?php echo $i?>][commissions]"<?php echo $commissions; ?>></td>
                <td><input class="bonuses" type="text" value="<?php echo $bonuses; ?>" name="employee[<?php echo $i?>][bonuses]"<?php echo $bonuses; ?>></td>

                <td><input class="other-income" type="text" value="<?php echo $otherIncome; ?>" name="employee[<?php echo $i?>][otherIncome]"<?php echo $otherIncome; ?>></td>
                <td><input class="total-revenue" type="text" value="<?php echo $totalRevenue; ?>"></td>
                <td><input class="days-absent" type="text" value="<?php echo $daysAbsent; ?>" name="employee[<?php echo $i?>][daysAbsent]"<?php echo $daysAbsent; ?>></td>
                <td><input class="deduction-lost-days" type="text" value="<?php echo $deductionLostDays; ?>"></td>
                <td><input class="other-deductions" type="text" value="<?php echo $otherDeductions; ?>" name="employee[<?php echo $i?>][otherDeductions]"<?php echo $otherDeductions; ?>></td>

                <td><input class="ihss" type="text" value="<?php echo $ihss; ?>" name="employee[<?php echo $i?>][ihss]"<?php echo $ihss; ?>></td>

                <td><input class="rap-fio-piso" type="text" value="<?php echo $rapFioPiso; ?>" name="employee[<?php echo $i?>][rapFioPiso]"<?php echo $rapFioPiso; ?>></td>
                <td><input class="rap-fio" type="text" value="<?php echo $rapFio; ?>" name="employee[<?php echo $i?>][rapFio]"<?php echo $rapFio; ?>></td>
                <td><input class="isr" type="text" value="<?php echo $isr; ?>" name="employee[<?php echo $i?>][isr]"<?php echo $isr; ?>></td>
                <td><input class="total-deductions" type="text" value="<?php echo $totalDeductions; ?>"></td>
                <td><input class="total-fort-night" type="text" value="<?php echo $totalFortnight; ?>"></td>
                <td><input class="notes" type="text" value="<?php echo $notes; ?>" name="employee[<?php echo $i?>][notes]"<?php echo $notes; ?>></td>
            </tr>
            <?php
            $n++;
        }
        ?>
        </tbody>
    </table>
    <button>Save</button>
</form>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>
<script>
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

</script>