<?php

class PayrollsModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener todas las planillas
     * @throws Exception
     */
    public function getPayrolls(): array
    {
        $query = "SELECT * FROM payrolls";
        $request = $this->findAll($query, []);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_PAROLLS_NOT_FOUND",
                "message" => "No hay planillas para mostrar."
            ]);
        }

        return $request;
    }

    /**
     * Obtener una planilla por ID
     * @throws Exception
     */
    public function getPayroll(int $id): array
    {
        $query = "SELECT * FROM payrolls WHERE payrollId = ?";
        $request = $this->find($query, [$id]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_PAROLL_NOT_FOUND",
                "message" => "No hay planillas para mostrar."
            ]);
        }

        return $request;
    }

    /**
     * Crear nueva planilla
     */
    public function setNewPayroll($json): array
    {
        $this->beginTransaction();
        $data = json_decode($json, true);

        try {
            // Verificar duplicado
            $query = "SELECT * FROM payrolls WHERE codeFortnight = ?";
            $request = $this->find($query, [$data['codeFortnight']]);

            if (!empty($request)) {
                return ["status" => "ERROR_CODE_FORTNIGHT_EXISTS", "redirect" => false];
            }

            // Preparar query de inserción
            $query = "INSERT INTO payrolls 
                (codeFortnight, startDate, endDate, payrollIhss, ihssChecked, payrollRapFioPiso, rapFioPisoChecked, payrollRapFio, rapFioChecked, payrollIsr, isrChecked)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Normalizar checkboxes
            $data['ihssCheckbox'] = isset($data['ihssCheckbox']) && $data['ihssCheckbox'] === 'on' ? 1 : 0;
            $data['rapFioCheckbox'] = isset($data['rapFioCheckbox']) && $data['rapFioCheckbox'] === 'on' ? 1 : 0;
            $data['rapFioPisoCheckbox'] = isset($data['rapFioPisoCheckbox']) && $data['rapFioPisoCheckbox'] === 'on' ? 1 : 0;
            $data['isrCheckbox'] = isset($data['isrCheckbox']) && $data['isrCheckbox'] === 'on' ? 1 : 0;

            $setData = [
                $data['codeFortnight'],
                $data['startDate'],
                $data['endDate'],
                $data['payrollIhss'],
                $data['ihssCheckbox'],
                $data['payrollRapFioPiso'],
                $data['rapFioPisoCheckbox'],
                $data['payrollRapFio'],
                $data['rapFioCheckbox'],
                $data['payrollIsr'],
                $data['isrCheckbox'],
            ];

            $insertedId = $this->save($query, $setData);
            $this->commitTransaction();

            return $insertedId > 0
                ? ["status" => "success", "redirect" => true]
                : ["status" => "error", "redirect" => false];

        } catch (Exception $e) {
            $this->rollbackTransaction();
            return ["status" => "error", "redirect" => false];
        }
    }

    /**
     * Obtener detalles de planilla por ID
     * @throws Exception
     */
    public function getPayrollDetails($id): array
    {
        $query = "SELECT * FROM payrolls WHERE payrollId = ?";
        $request = $this->find($query, [$id]);

        if (empty($request)) {
            return json_encode(["status" => "ERROR_PAROLLS_NOT_FOUND"]);
        }

        return $request;
    }

    /**
     * Obtener empleados activos
     */
    public function getEmployee(): false|array|string
    {
        $query = "SELECT * FROM employees WHERE employeeStatus != ?";
        $request = $this->findAll($query, [0]);

        if (empty($request)) {
            return json_encode(["status" => "ERROR_EMPLOYEES_NOT_FOUND"]);
        }

        return $request;
    }

    /**
     * Obtener detalles de planilla por ID
     */
    public function detailPayrollId($id): false|array|string
    {
        $query = "
            SELECT *
            FROM payroll_details
            INNER JOIN payrolls ON payrolls.payrollId = payroll_details.payrollId
            WHERE payroll_details.payrollId = ?";
        $request = $this->findAll($query, [$id]);

        return $request ?: [];
    }

    /**
     * Obtener todos los empleados con sus perfiles
     * @throws Exception
     */
    public function getEmployees(): false|array|string
    {
        $query = "
            SELECT 
                employees.employeeId,
                employees.employeeCode,
                employees.monthlySalary,
                employees.bankName,
                employees.accountNumber,
                profiles.profileNames,
                profiles.profileSurnames,
                profiles.profileIdentity
            FROM employees
            INNER JOIN profiles ON employees.profileId = profiles.profileId";

        $request = $this->findAll($query, []);

        if (empty($request)) {
            return json_encode(["status" => "ERROR_EMPLOYEES_NOT_FOUND"]);
        }

        return $request;
    }

    /**
     * Guardar detalles de planilla por empleado
     */
    public function setPayrollDetail(array $payrolls, int $payrollId): false|string
    {
        $this->beginTransaction();

        if (!isset($payrolls['employee']) || !is_array($payrolls['employee'])) {
            throw new InvalidArgumentException("The 'employee' key is missing or is not an array.");
        }

        $employeeDetails = $payrolls['employee'];

        try {
            $this->deletePayrollDetail($payrollId);

            foreach ($employeeDetails as $details) {
                $query = "
                    INSERT INTO payroll_details 
                    (payrollId, employeeId, bankName, accountNumber, biweeklyBaseSalary, commissions, bonuses, otherIncome, daysAbsent, otherDeductions, rapFioPiso, rapFio, isr, notes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $setData = [
                    $payrollId,
                    $details["employeeId"],
                    $details["bankName"],
                    $details["accountNumber"],
                    $details["monthlySalary"] / 2, // Quincenal
                    $details["commissions"],
                    $details["bonuses"],
                    $details["otherIncome"],
                    $details["daysAbsent"],
                    $details["otherDeductions"],
                    $details["rapFioPiso"],
                    $details["rapFio"],
                    $details["isr"],
                    $details["notes"]
                ];

                $this->save($query, $setData);
            }

            $this->commitTransaction();

            return json_encode(["status" => "SUCCESS_PAYROLL_UPDATE"]);
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * Eliminar detalles de planilla
     */
    public function deletePayrollDetail(int $payrollId): string
    {
        if (!$this->inTransaction()) {
            $this->beginTransaction();
        }

        try {
            $sql = "DELETE FROM payroll_details WHERE payrollId = ?";
            $this->deleteRecord($sql, [$payrollId]);

            if (!$this->inTransaction()) {
                $this->commitTransaction();
            }

            return 'DATA_DELETE';
        } catch (Exception $e) {
            if ($this->inTransaction()) {
                $this->rollbackTransaction();
            }
            throw $e;
        }
    }

    /**
     * Contar días de asistencia de un empleado
     */
    public function getEmployeeAttendanceDays($userId, $startDate, $endDate): int
    {
        $query = "
            SELECT COUNT(DISTINCT DATE(attendanceCreatedIn)) AS totalDays
            FROM attendances
            WHERE userId = ?
            AND attendanceCreatedIn >= ?
            AND attendanceCreatedIn <= CONCAT(?, ' 23:59:59')";
        
        $request = $this->find($query, [$userId, $startDate, $endDate]);

        return !empty($request['totalDays']) ? (int)$request['totalDays'] : 0;
    }
}
