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
<div style="text-align: center">
    <button onclick="reset()">Reset</button>
</div>
<script>
    function reset(){
        localStorage.removeItem('tableData');

    }
</script>
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
        <th  colspan="2">Dias Faltados</th>
        <th>Otras deducciones</th>
        <th>IHSS <input type="checkbox" id="checkedIhss"></th>
        <th>RAP FIO Piso</th>
        <th>RAP FIO <input type="checkbox" id="checkedRapFio"></th>
        <th>ISR<input type="checkbox" id="checkedIsr"></th>
        <th>Total deducciones</th>
        <th>Total Quincena</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Recorrer los datos y generar filas dinámicamente
    $n = 1;
    foreach ($data2 as $row) {
        ?>
        <tr>
            <td><input data-value="serialNumber" type="text" value="<?php echo $n; ?>"></td>
            <td><input data-value="spreadsheetCode" type="text" value="<?php echo $data1['codeFortnight']; ?><?php echo $row['employeeCode']; ?>"></td>
            <td><input data-value="codeFortnight" type="text" value="<?php echo $data1['codeFortnight']; ?>"></td>
            <td><input data-value="employeeId" type="hidden" value="<?php echo $row['employeeId']; ?>"><input data-value="employeeCode" type="text" value="<?php echo $row['employeeCode']; ?>"></td>
            <td><input data-value="profileName" type="text" value="<?php echo $row['profileNames']; ?> <?php echo $row['profileSurnames']; ?>"></td>
            <td><input data-value="profileIdentity" type="text" value="<?php echo $row['profileIdentity']; ?>"></td>
            <td><input data-value="bankName" type="text" value="<?php echo $row['bankName']; ?>"></td>
            <td><input data-value="accountNumber" type="text" value="<?php echo $row['accountNumber']; ?>"></td>
            <td><input data-value="monthlySalary" type="text" value="<?php echo $row['monthlySalary']; ?>"></td>
            <td><input data-value="biweeklyBaseSalary" type="text" value="<?php echo $row['monthlySalary'] / 2; ?>"></td>

            <td><input data-value="commissions" type="text" value="0.00"></td>
            <td><input data-value="bonuses" type="text" value="0.00"></td>
            <td><input data-value="otherIncome" type="text" value="0.00"></td>
            <td><input data-value="totalRevenue" type="text" value="<?php echo $row['monthlySalary'] / 2; ?>"></td>
            <td><input data-value="daysMissed" type="text" value="0.00"></td>
            <td><input data-value="deductionLostDays" type="text" value="0.00"></td>
            <td><input data-value="otherDeductions" type="text" value="0.00"></td>

            <td><input data-value="ihss" type="text" value="0.00"></td>
            <td><input data-value="rapFioPiso" type="text" value="11336.32"></td>
            <td><input data-value="rapFio" type="text" value="0.00"></td>
            <td><input key="<?php echo $row['profileIdentity']; ?>" data-value="isr" type="text" value="0.00"></td>
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
    function populateTableFromLocalStorage() {
    let jsonData = JSON.parse(localStorage.getItem('tableData')) || [];

    // Obtener todas las filas de la tabla
    const rows = document.querySelectorAll("table tbody tr");

    // Recorrer las filas y asignar los valores de jsonData a los inputs correspondientes
    rows.forEach((row, index) => {
        if (jsonData[index]) {
            const inputs = row.querySelectorAll("input[data-value]");

            inputs.forEach(input => {
                const inputName = input.getAttribute("data-value");
                if (jsonData[index][inputName] !== undefined) {
                    // Asignar el valor almacenado en localStorage al input correspondiente
                    input.value = jsonData[index][inputName];
                }
            });
        }
    });
}

function statusCheckbox() {
    // Obtén el estado de los checkboxes del localStorage
    const statusCheckbox = JSON.parse(localStorage.getItem('statusCheckbox')) || {};

    // Referencias a los checkboxes
    const checkboxes = {
        checkedIhss: document.getElementById('checkedIhss'),
        checkedRapFio: document.getElementById('checkedRapFio'),
        checkedIsr: document.getElementById('checkedIsr'),
    };

    // Establece el estado inicial de los checkboxes según el localStorage
    for (let key in checkboxes) {
        if (statusCheckbox[key] !== undefined) {
            checkboxes[key].checked = statusCheckbox[key];
        }
    }

    // Agrega un evento de cambio para cada checkbox
    Object.keys(checkboxes).forEach((key) => {
        checkboxes[key].addEventListener('change', () => {
            // Actualiza el estado del checkbox en el localStorage
            statusCheckbox[key] = checkboxes[key].checked;
            localStorage.setItem('statusCheckbox', JSON.stringify(statusCheckbox));
        });
    });
}

    document.addEventListener("DOMContentLoaded", () => {
        statusCheckbox()
        populateTableFromLocalStorage();
        let jsonData = JSON.parse(localStorage.getItem('tableData')) || [];
        const valueCalculateRapFio = 0.015;
        const valueCalculateIhss = 561.14;

        const valueCalculateIsr = 20986.03;

        const checkedIhss = document.getElementById("checkedIhss");
        const checkedIsr = document.getElementById("checkedIsr");
        const checkedRapFio = document.getElementById("checkedRapFio");

        // Obtener la tabla y las filas del cuerpo
        const table = document.querySelector("table");
        if (!table) {
            console.error("Table not found.");
            return;
        }

        const rows = table.querySelectorAll("tbody tr");

        const updateIhssValues = () => {
            rows.forEach((row, index) => {
                const ihssInput = row.querySelector("input[data-value='ihss']");

                // Si el checkbox está marcado, asignar el valor de IHSS
                if (checkedIhss.checked) {
                    ihssInput.value = valueCalculateIhss.toFixed(2);
                    jsonData[index].ihss = valueCalculateIhss; // Actualizar jsonData con el valor de IHSS
                } else {
                    ihssInput.value = 0; // Si no está marcado, dejar el valor en 0
                    jsonData[index].ihss = 0; // Actualizar jsonData con 0
                }

                // Recalcular la fila para actualizar las deducciones totales
                recalculateRow(index);
            });

            // Guardar el estado actualizado en localStorage
            localStorage.setItem('tableData', JSON.stringify(jsonData));
        };


        const updateIsrValues = () => {
            rows.forEach((row, index) => {
                const isrInput = row.querySelector("input[data-value='isr']");
                const inputKey = isrInput.getAttribute("key");
                const profileIdentity ="0801-1999-10070";



                // Si el checkbox está marcado, asignar el valor de ISR
                if (checkedIsr.checked) {
                    //const calculatedIsr = (valueCalculateIsr / 9).toFixed(2);
                    const calculatedIsr = Math.round((valueCalculateIsr / 9) * 100) / 100;

                    if (inputKey===profileIdentity){
                        isrInput.value = calculatedIsr;
                        console.log(inputKey)

                    }



                    //jsonData[index].isr = parseFloat(calculatedIsr); // Actualizar jsonData con el valor calculado todo el json
                    // Buscar en el JSON el objeto con el profileIdentity correspondiente
                    const targetIndex = jsonData.findIndex(item => item.profileIdentity === profileIdentity);
                    if (targetIndex !== -1) {

                        jsonData[targetIndex].isr = calculatedIsr;
                    }


                } else {
                    isrInput.value = 0; // Si no está marcado, dejar el valor en 0
                    //jsonData[index].isr = 0; // Actualizar jsonData con 0 todo el json
                    const targetIndex = jsonData.findIndex(item => item.profileIdentity === profileIdentity);
                    if (targetIndex !== -1) {
                        jsonData[targetIndex].isr = 0; // Actualizar el valor de `isr` en el JSON
                    }


                }

                // Recalcular la fila para actualizar las deducciones totales
                recalculateRow(index);
            });

            // Guardar el estado actualizado en localStorage
            localStorage.setItem('tableData', JSON.stringify(jsonData));
        };


        checkedIhss.addEventListener("change", () => {
            updateIhssValues();
        });
        checkedIsr.addEventListener("change", () => {
            updateIsrValues();
        });

        // Función para recalcular valores específicos de `rapFio`
        const updateRapFioValues = () => {
            rows.forEach((row, index) => {
                const rapFioInput = row.querySelector("input[data-value='rapFio']");
                const monthlySalary = parseFloat(row.querySelector("input[data-value='monthlySalary']").value.trim()) || 0;
                const rapFioPiso = parseFloat(row.querySelector("input[data-value='rapFioPiso']").value.trim()) || 0;

                // Actualizar el valor de rapFio solo si el checkbox está marcado

                const newRapFioValue = checkedRapFio.checked ? (monthlySalary - rapFioPiso) * valueCalculateRapFio : 0;
                const roundedRapFioValue = Math.round(newRapFioValue * 100) / 100;
                // Actualizar el input en la tabla y en el JSON local
                rapFioInput.value = newRapFioValue.toFixed(2);
                jsonData[index].rapFio = roundedRapFioValue;

                // Recalcular la fila para actualizar las deducciones totales
                recalculateRow(index);
            });

            // Guardar el estado actualizado en localStorage
            localStorage.setItem('tableData', JSON.stringify(jsonData));
        };

        // Listener para cambios en el checkbox
        checkedRapFio.addEventListener("change", () => {
            updateRapFioValues();
        });

        // Función existente para recalcular valores de la fila
        const recalculateRow = (rowIndex) => {




            const data = jsonData[rowIndex];
            const row = rows[rowIndex];

            // Calcular total ingresos
            data.totalRevenue = data.biweeklyBaseSalary + data.commissions + data.bonuses + data.otherIncome;
            row.querySelector("input[data-value='totalRevenue']").value = data.totalRevenue.toFixed(2);

            // Calcular deducción por días faltados
            const dailySalary = data.monthlySalary / 30;
            data.deductionLostDays = dailySalary * data.daysMissed;
            row.querySelector("input[data-value='deductionLostDays']").value = data.deductionLostDays.toFixed(2);

            // Calcular total deducciones
            data.totalDeductions = data.deductionLostDays + data.otherDeductions + data.ihss + data.rapFio + data.isr;
            row.querySelector("input[data-value='totalDeductions']").value = data.totalDeductions.toFixed(2);

            // Calcular total quincena
            data.totalFortnight = data.totalRevenue - data.totalDeductions;
            row.querySelector("input[data-value='totalFortnight']").value = data.totalFortnight.toFixed(2);

            // Guardar cambios en localStorage
            localStorage.setItem('tableData', JSON.stringify(jsonData));
            //console.log(jsonData)
        };

        // Agregar eventos de entrada a los inputs para recalcular en tiempo real
        rows.forEach((row, index) => {
            const inputs = row.querySelectorAll("input[data-value]");
            inputs.forEach((input) => {
                input.addEventListener("input", () => {
                    // Actualizar el JSON con los cambios del input
                    const inputName = input.getAttribute('data-value');
                    const value = input.value.trim();

                    jsonData[index][inputName] = isNaN(value) ? value : parseFloat(value) || 0;

                    // Recalcular la fila y guardar cambios
                    recalculateRow(index);
                });
            });
        });



        if (jsonData.length === 0) {
            rows.forEach(row => {
                const rowData = {
                    serialNumber: row.querySelector("input[data-value='serialNumber']")?.value.trim(),
                    spreadsheetCode: row.querySelector("input[data-value='spreadsheetCode']")?.value.trim(),
                    codeFortnight: row.querySelector("input[data-value='codeFortnight']")?.value.trim(),
                    employeeId: row.querySelector("input[data-value='employeeId']")?.value.trim(),
                    employeeCode: row.querySelector("input[data-value='employeeCode']")?.value.trim(),
                    profileName: row.querySelector("input[data-value='profileName']")?.value.trim(),
                    profileIdentity: row.querySelector("input[data-value='profileIdentity']")?.value.trim(),
                    bankName: row.querySelector("input[data-value='bankName']")?.value.trim(),
                    accountNumber: row.querySelector("input[data-value='accountNumber']")?.value.trim(),
                    monthlySalary: parseFloat(row.querySelector("input[data-value='monthlySalary']")?.value.trim()) || 0,
                    biweeklyBaseSalary: parseFloat(row.querySelector("input[data-value='biweeklyBaseSalary']")?.value.trim()) || 0,
                    commissions: parseFloat(row.querySelector("input[data-value='commissions']")?.value.trim()) || 0,
                    bonuses: parseFloat(row.querySelector("input[data-value='bonuses']")?.value.trim()) || 0,
                    otherIncome: parseFloat(row.querySelector("input[data-value='otherIncome']")?.value.trim()) || 0,
                    totalRevenue: parseFloat(row.querySelector("input[data-value='totalRevenue']")?.value.trim()) || 0,
                    daysMissed: parseFloat(row.querySelector("input[data-value='daysMissed']")?.value.trim()) || 0,
                    deductionLostDays: parseFloat(row.querySelector("input[data-value='deductionLostDays']")?.value.trim()) || 0,
                    otherDeductions: parseFloat(row.querySelector("input[data-value='otherDeductions']")?.value.trim()) || 0,
                    ihss: parseFloat(row.querySelector("input[data-value='ihss']")?.value.trim()) || 0,
                    rapFioPiso: parseFloat(row.querySelector("input[data-value='rapFioPiso']")?.value.trim()) || 0,
                    rapFio: parseFloat(row.querySelector("input[data-value='rapFio']")?.value.trim()) || 0,
                    isr: parseFloat(row.querySelector("input[data-value='isr']")?.value.trim()) || 0,
                    totalDeductions: parseFloat(row.querySelector("input[data-value='totalDeductions']")?.value.trim()) || 0,
                    totalFortnight: parseFloat(row.querySelector("input[data-value='totalFortnight']")?.value.trim()) || 0
                };
                jsonData.push(rowData);
            });

            localStorage.setItem('tableData', JSON.stringify(jsonData));
        }
    });

</script>
<button id="create-details">Guardar Planilla</button>
<!--== #HEADER ==-->
<?php adminHeader($data); ?>
<script>
    const  payrollId= <?= json_encode($data["payrollId"]) ?>;
    form = document.getElementById('create-details')

    form.addEventListener('click', function(e){
        e.preventDefault()
        let obj = JSON.parse(localStorage.getItem('tableData')) || [];
        console.log(obj)

        fetch('http://localhost/insider/payrolls/setDetails/'+payrollId, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(obj),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    })
</script>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>

