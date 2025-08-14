<?php
class Payrolls extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['userId']) || !isset($_SESSION['login'])) {

            header('Location:'.router().'auth/login');
            exit();
        }
        getPermissions(MD_PAYROLLS);

    }

    /**
     * @throws Exception
     */
    public function payrolls(): void
    {
//        if (!isset($_SESSION['permissionsModule']['r']) || $_SESSION['permissionsModule']['r'] !== 1) {
//            header('Location:'.router().'dashboard');
//            die();
//        }

        $data["pageName"]     = "payrolls";
        // debug($_SESSION['permissionsModule']);
//        debug($_SESSION['permissions']);
            $payrolls = $this->model->getPayrolls();
            //echo $_SESSION['userId'];
            $this->views->getViews($this, 'payrolls', $data,$payrolls);




    }

    /**
     * @throws Exception
     */

     function setNewPayroll(): void
     {
         $payroll = $_POST;
         $json = json_encode($payroll);
     
         $request = $this->model->setNewPayroll($json);
     
         // Devolver exactamente lo que retorna el modelo
         echo json_encode($request);
     }
     

    /**
     * @throws Exception
     */
    public function overview($id): void
    {

        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }

        $verifiedId = verifyId('payrolls', 'payrollId', $id);
        if (empty($verifiedId['total']) || $verifiedId['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }


        $data["pageName"]     = "createPayroll";
        $data["pageTitle"]     = "Detalles de la planilla";
        $data["tagTitle"]     = "Overview";

        $data["payrollId"] = $id;

        $payroll = $this->model->getPayroll($id);
        $data["payrollIhss"] = $payroll["payrollIhss"];
        $employees = $this->model->getEmployees();

        $detailPayroll = $this->model->detailPayrollId($id);

        $startFortnight=$payroll["startDate"];
        $endFortnight = $payroll["endDate"];

        $defaultDetail = [
            'codeFortnight' => $payroll['codeFortnight'],
            'commissions' => 0,
            'bonuses' => 0,
            'otherIncome' => 0,
            'daysAbsent' => 0,
            'otherDeductions' => 0,
            'ihss' => 0,
            'rapFioPiso' => 0,
            'rapFio' => 0,
            'isr' => 0,
            'notes' => 0,
        ];

        $data1 = ['payrollId' => $id];
//        if (empty($payroll)) {
//            return;
//        }
        $bankName="";
        //debug($detailPayroll);
        foreach ($employees as &$detail) {
            $employeeId = $detail['employeeId'];
            $detail['details'] = $defaultDetail;

            $daysWorked = $this->model->getEmployeeAttendanceDays($employeeId, $startFortnight, $endFortnight);
            

            foreach ($detailPayroll as $employee) {

                if ($employee['bankName']===""){
                    $bankName =$detail['bankName'];
                }else{
                    $bankName =$employee['bankName'];
                }
                if ($employee['accountNumber']===""){
                    $accountNumber =$detail['accountNumber'];
                }else{
                    $accountNumber =$employee['accountNumber'];
                }
                if ($employee['biweeklyBaseSalary']===""){
                    $monthlySalary =$detail['biweeklyBaseSalary'];
                }else{
                    $monthlySalary =$employee['biweeklyBaseSalary']*2;
                }

                if ($employee['employeeId'] === $detail['employeeId']) {
                    $detail['details'] = [
                        'employeeId' => $detail['employeeId'],
                        'codeFortnight' => $employee['codeFortnight'],
                        'employeeCode' => $detail['employeeCode'],
                        'profileNames' => $detail['profileNames'],
                        'profileIdentity' => $detail['profileIdentity'],
                        'bankName' => $bankName,
                        'accountNumber' => $accountNumber,
                        'monthlySalary' => $monthlySalary,
                        'commissions' => $employee['commissions'],
                        'bonuses' => $employee['bonuses'],
                        'otherIncome' => $employee['otherIncome'],
                        'daysAbsent' => 15-$daysWorked,
                        'otherDeductions' => $employee['otherDeductions'],
                        'ihss' => $employee['ihss'],
                        'rapFioPiso' => $employee['rapFioPiso'],
                        'rapFio' => $employee['rapFio'],
                        'isr' => $employee['isr'],
                        'notes' => $employee['notes']
                    ];
                    break;
                }
            }
        }

        $data1['employees'] = $employees;

        $data["userId"] = $id;
        //debug($data1['employees']);

      $data2=$payroll;


        //debug($employees);
        //debug($payroll);
        $this->views->getViews($this, 'overview', $data,$data1,$data2);
    }
    /**
     * @throws Exception
     */
    public function details($id): void
    {

        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }

        $verifiedId = verifyId('payrolls', 'payrollId', $id);
        if (empty($verifiedId['total']) || $verifiedId['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }


        $data["pageName"]     = "createPayroll";
        $data["payrollId"] = $id;
        $payroll = $this->model->getPayroll($id);
        $employees = $this->model->getEmployees();

        $detailPayroll = $this->model->detailPayrollId($id);


        $defaultDetail = [
            'codeFortnight' => $payroll['codeFortnight'],
            'commissions' => 0,
            'bonuses' => 0,
            'otherIncome' => 0,
            'daysAbsent' => 0,
            'otherDeductions' => 0,
            'ihss' => 0,
            'rapFioPiso' => 0,
            'rapFio' => 0,
            'isr' => 0,
            'notes' => 0,
        ];

        $data1 = ['payrollId' => $id];
//        if (empty($payroll)) {
//            return;
//        }
        $bankName="";
        //debug($detailPayroll);
        foreach ($employees as &$detail) {
            $detail['details'] = $defaultDetail;

            foreach ($detailPayroll as $employee) {

                    if ($employee['bankName']===""){
                        $bankName =$detail['bankName'];
                    }else{
                        $bankName =$employee['bankName'];
                    }
                if ($employee['accountNumber']===""){
                    $accountNumber =$detail['accountNumber'];
                }else{
                    $accountNumber =$employee['accountNumber'];
                }
                if ($employee['biweeklyBaseSalary']===""){
                    $monthlySalary =$detail['biweeklyBaseSalary'];
                }else{
                    $monthlySalary =$employee['biweeklyBaseSalary']*2;
                }

                if ($employee['employeeId'] === $detail['employeeId']) {
                    $detail['details'] = [
                        'employeeId' => $detail['employeeId'],
                        'codeFortnight' => $employee['codeFortnight'],
                        'employeeCode' => $detail['employeeCode'],
                        'profileNames' => $detail['profileNames'],
                        'profileIdentity' => $detail['profileIdentity'],
                        'bankName' => $bankName,
                        'accountNumber' => $accountNumber,
                        'monthlySalary' => $monthlySalary,
                        'commissions' => $employee['commissions'],
                        'bonuses' => $employee['bonuses'],
                        'otherIncome' => $employee['otherIncome'],
                        'daysAbsent' => $employee['daysAbsent'],
                        'otherDeductions' => $employee['otherDeductions'],
                        'ihss' => $employee['ihss'],
                        'rapFioPiso' => $employee['rapFioPiso'],
                        'rapFio' => $employee['rapFio'],
                        'isr' => $employee['isr'],
                        'notes' => $employee['notes']
                    ];
                    break;
                }
            }
        }

        $data1['employees'] = $employees;

        $data["userId"] = $id;
        //debug($data1['employees']);




        //debug($employees);
        //debug($payroll);
        $this->views->getViews($this, 'details', $data,$data1);
    }

    public function updatePayroll() : void
    {



        $payroll = $_POST;
        $payrollId = $payroll['payrollId'];
      
       // VERIRIFCAR SI chekAllIsr es on
       if (isset($payroll['chekAllIsr']) && $payroll['chekAllIsr'] === 'on') {
            $employeeIdOne = $payroll['employee'][3]['employeeId'];
            $isrOne = $payroll['employee'][3]['isr'];
            $employeeIdTwo = $payroll['employee'][4]['employeeId'];
            $isrTwo = $payroll['employee'][4]['isr'];

            if ($isrOne === "0.00" || $isrOne === "" || $isrTwo === "0.00" || $isrTwo === "" || $isrOne === "0" || $isrTwo === "0") {
                echo json_encode([
                    "status" => "ERROR_PAYROLL_UPDATE_ISR",
                    "message" => "Debe ingresar el ISR para el empleado marcado en rojo.",
                    "fields" => "['employee'][3]['isr'], ['employee'][4]['isr']"
                ]);
            exit();
        }
    }     
       
        $request = $this->model->setPayrollDetail($payroll, $payrollId);
        


        $response = json_decode($request, true);

        switch ($response["status"]) {
            case "SUCCESS_PAYROLL_UPDATE":
                    echo json_encode(array(
                        'status' => 'success',
                        'message'=> 'Planilla actualizada...',
                        'redirect'=>true));
                break;
            default:
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error desconocido.',
                    'redirect' => false
                ]);
                break;
        }
    }
}