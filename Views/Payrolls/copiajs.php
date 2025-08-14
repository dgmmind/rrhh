<!--== #HEADER ==-->
<?php adminHeader($data); ?>
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


        <th>Dias Faltados</th>
        <th>Deduccion</th>
        <th>Otras deducciones</th>
        <th>IHSS</th>
        <th>RAP FIO</th>
        <th>ISR</th>
        <th>Total deducciones</th>
        <th>Total Quincena</th>

    </tr>
    </thead>
    <tbody>
    <?php
    // Recorrer los datos y generar filas dinámicamente
    $n=1;
    foreach ($data1 as $row) {
        ?>
        <tr>
            <td><input data-value="serialNumber" type="text" value="<?php echo $n; ?>"></td>
            <td><input data-value="spreadsheetCode" type="text" value="<?php echo $data2['codeFortnight']; ?><?php echo $row['employeeCode']; ?>"></td>
            <td><input data-value="codeFortnight" type="text" value="<?php echo $data2['codeFortnight']; ?>"></td>
            <td><input data-value="employeeCode" type="text" value="<?php echo $row['employeeCode']; ?>"></td>
            <td><input data-value="profileName" type="text" value="<?php echo $row['profileNames']; ?> <?php echo $row['profileSurnames']; ?>"></td>
            <td><input data-value="profileIdentity" type="text" value="<?php echo $row['profileIdentity']; ?>"></td>
            <td><input data-value="bankName" type="text" value="<?php echo $row['bankName']; ?>"></td>
            <td><input data-value="accountNumber" type="text" value="<?php echo $row['accountNumber']; ?>"></td>
            <td><input data-value="monthlySalary" type="text" value="<?php echo $row['monthlySalary']; ?>"></td>
            <td><input data-value="biweeklyBaseSalary" type="text" value="<?php echo $row['monthlySalary'] / 2; ?>"></td>

            <td><input data-value="commissions" type="text" value="0.00"></td>
            <td><input data-value="otherIncome" type="text" value="0.00"></td>
            <td><input data-value="totalRevenue" type="text" value="0.00"></td>
            <td><input data-value="daysMissed" type="text" value="0.00"></td>
            <td><input data-value="deductionLostDays" type="text" value="0.00"></td>
            <td><input data-value="otherDeductions" type="text" value="0.00"></td>



            <td><input data-value="ihss" type="text" value="0.00"></td>
            <td><input data-value="rapFio" type="text" value="0.00"></td>
            <td><input data-value="isr" type="text" value="0.00"></td>
            <td><input data-value="totalDeductions" type="text" value="0.00"></td>
            <td><input data-value="totalDeductions" type="text" value="0.00"></td>
            <td><input data-value="totalFortnight" type="text" value="0.00"></td>


        </tr>
        <?php
        $n++;
    }
    ?>
    </tbody>
</table>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const table = document.querySelector("table");
        if (!table) {
            console.error("Table not found.");
            return;
        }

        const rows = table.querySelectorAll("tbody tr");
        const jsonData = [];

        // Inicializar el JSON con los datos iniciales de la tabla
        rows.forEach(row => {
            const rowData = {
                serialNumber: row.querySelector("input[data-value='serialNumber']")?.value.trim(),
                spreadsheetCode: row.querySelector("input[data-value='spreadsheetCode']")?.value.trim(),
                codeFortnight: row.querySelector("input[data-value='codeFortnight']")?.value.trim(),
                employeeCode: row.querySelector("input[data-value='employeeCode']")?.value.trim(),
                profileName: row.querySelector("input[data-value='profileName']")?.value.trim(),
                profileIdentity: row.querySelector("input[data-value='profileIdentity']")?.value.trim(),
                bankName: row.querySelector("input[data-value='bankName']")?.value.trim(),
                accountNumber: row.querySelector("input[data-value='accountNumber']")?.value.trim(),
                monthlySalary: parseFloat(row.querySelector("input[data-value='monthlySalary']")?.value.trim()) || 0,
                biweeklyBaseSalary: parseFloat(row.querySelector("input[data-value='biweeklyBaseSalary']")?.value.trim()) || 0,
                commissions: parseFloat(row.querySelector("input[data-value='commissions']")?.value.trim()) || 0,
                bonuses: parseFloat(row.querySelector("input[data-value='otherIncome']")?.value.trim()) || 0,
                totalRevenue: parseFloat(row.querySelector("input[data-value='totalRevenue']")?.value.trim()) || 0,
                daysMissed: parseFloat(row.querySelector("input[data-value='daysMissed']")?.value.trim()) || 0,
                deductionLostDays: parseFloat(row.querySelector("input[data-value='deductionLostDays']")?.value.trim()) || 0,
                otherDeductions: parseFloat(row.querySelector("input[data-value='otherDeductions']")?.value.trim()) || 0,
                ihss: parseFloat(row.querySelector("input[data-value='ihss']")?.value.trim()) || 0,
                rapFio: parseFloat(row.querySelector("input[data-value='rapFio']")?.value.trim()) || 0,
                isr: parseFloat(row.querySelector("input[data-value='isr']")?.value.trim()) || 0,
                totalDeductions: parseFloat(row.querySelector("input[data-value='totalDeductions']")?.value.trim()) || 0,
                totalFortnight: parseFloat(row.querySelector("input[data-value='totalFortnight']")?.value.trim()) || 0
            };

            jsonData.push(rowData);
        });

        // Función para recalcular los valores
        const recalculateRow = (rowIndex) => {
            const data = jsonData[rowIndex];
            const row = rows[rowIndex];

            data.totalRevenue = data.biweeklyBaseSalary + data.commissions + data.bonuses;
            row.querySelector("input[data-value='totalRevenue']").value = data.totalRevenue.toFixed(2);

            // // Calcular deducción por días faltados
            // const dailySalary = data.monthlySalary / 30;
            // data.deductionLostDays = dailySalary * data.daysMissed;
            //
            // // Calcular total ingresos
            // data.totalRevenue = data.biweeklyBaseSalary + data.commissions + data.bonuses;
            //
            // // Calcular total deducciones
            // data.totalDeductions = data.deductionLostDays + data.otherDeductions + data.ihss + data.rapFio + data.isr;
            //
            // // Calcular total quincena
            // data.totalFortnight = data.totalRevenue - data.totalDeductions;
            //
            // // Actualizar valores en la tabla
            // row.querySelector("input[data-value='totalRevenue']").value = data.totalRevenue.toFixed(2);
            // row.querySelector("input[data-value='deductionLostDays']").value = data.deductionLostDays.toFixed(2);
            // row.querySelector("input[data-value='totalDeductions']").value = data.totalDeductions.toFixed(2);
            // row.querySelector("input[data-value='totalFortnight']").value = data.totalFortnight.toFixed(2);
            //
        };

        // // Agregar eventos a los inputs para recalcular en tiempo real
        rows.forEach((row, index) => {
            const inputs = row.querySelectorAll("input[data-value]");
            inputs.forEach((input) => {
                input.addEventListener("input", () => {
                    recalculateRow(index);
                });
            });
        });

        // Mostrar el JSON en la consola para depuración
        console.log("Initial JSON:", JSON.stringify(jsonData, null, 2));
    });

</script>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>

