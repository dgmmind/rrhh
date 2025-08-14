<?php
class Attendances extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        getPermissions(MD_ROLES);
    }

    /**
     * @throws Exception
     */
    public function attendances(): void
    {
        $data["pageName"]     = "attendances";
        $data["pageTitle"]     = "Attendances";
        $data["userId"]= $_SESSION['userData']["userId"];
        $statusAttendance = $this->model->checkAttendanceStatus($data["userId"]);
        $attendanceDaily = $this->model->getTodayAttendance($data["userId"]);

        if (!empty($attendanceDaily["attendanceStartTime"]) && $attendanceDaily["attendanceEndTime"] === "00:00:00") {
            $data["attendanceDaily"] = "ON";
        } else {
            $data["attendanceDaily"] = "OFF";
        }
        //debug($attendanceDaily);

        $statusAttendance = json_decode($statusAttendance, true);
        $data["statusAttendance"] = $statusAttendance["status"];


        //debug($_SESSION['permissions']);
        //debug($_SESSION['permissionsModule']);
        $this->views->getViews($this, 'attendances', $data,$attendanceDaily);
    }

    /**
     * @throws Exception
     */
    public function push() {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        // Validar si hay datos en la petición
        if (empty($json)) {
            die("No se recibió información.");
        }

        $userId = $_SESSION['userData']["userId"];
        $currentTime = date('H:i:s');  // Hora actual
        $attendanceNote = $json["attendanceNote"] ?? null;

        // Validar si el switch está activado o desactivado
        $isSwitchOn = $json["switchState"] ?? 0; // 1 si está activado (check-in), 0 si está desactivado (check-out)
        // Verificar si el usuario ya tiene asistencia registrada (entrada)
        $attendanceToday = $this->model->getTodayAttendance($userId);
        //debug($attendanceToday);
        //return;
        if ($isSwitchOn) {  // Switch activado (check-in)
            if (!$attendanceToday) {
                // No hay registro de asistencia, se guarda check-in
                $request = $this->model->setPush($userId, $currentTime, null, $attendanceNote,null);
                echo "Entrada registrada a las $currentTime";
            } else {
                echo "Ya has registrado tu entrada hoy.";
            }
        } elseif ($isSwitchOn == 0) {  // Switch desactivado (check-out)
            if ($attendanceToday && (empty($attendanceToday['attendancesEndTime']) || $attendanceToday['attendancesEndTime'] === "00:00:00")) {
                $request = $this->model->updateCheckOut($userId,$currentTime,$attendanceNote);
                //debug($request);
            } else {
                echo "No se puede registrar la salida sin una entrada previa.";
            }
        } else {
            echo "Estado del switch no válido.";
        }
    }

    public function setNewUser(): void
    {
        $user = "newUser";
        $users = $this->model->setNewUser($user);

    }
}