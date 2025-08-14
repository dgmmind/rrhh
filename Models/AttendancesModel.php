<?php
/**
 *
 */
class AttendancesModel extends Mysql
{
    private $intUserId;
    private $strUserEmail;
    private $strUserPassword;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @throws Exception
     */
    public function getTodayAttendance($userId): array
    {
        $query = "SELECT 
                a.*, 
                u.userName AS userName, 
                p.profileNames AS profileNames, 
                s.startTime 
              FROM attendances a
              INNER JOIN users u ON a.userId = u.userId
              INNER JOIN profiles p ON a.userId = p.userId
              INNER JOIN schedules s ON a.userId = s.userId
              WHERE a.userId = ? 
              AND DATE(a.attendanceCreatedIn) = CURDATE()";

        return $this->find($query, [$userId]);
    }




    /**
     * @throws Exception
     */
    public function checkAttendanceStatus($userId): string
    {
        $query = "SELECT attendanceStartTime, attendanceEndTime 
              FROM attendances 
              WHERE userId = ? 
              AND DATE(attendanceCreatedIn) = CURDATE()";

        $request = $this->find($query, [$userId]);

        if (!empty($request) && !empty($request['attendanceStartTime']) && !empty($request['attendanceEndTime']) && $request['attendanceEndTime'] !== "00:00:00") {
            return json_encode([
                "status" => "SUCCESS_ATTENDANCE"
            ]);
        }

        return json_encode([
            "status" => "NO_ATTENDANCE_FOUND"
        ]);
    }
    public function setPush($userId, $attendanceStartTime, $attendanceEndTime, $attendanceStartNote,$attendanceEndNote):false|string
    {
        $attendanceEndTime = !empty($attendanceEndTime) ? $attendanceEndTime : "00:00:00";
        $attendanceStartNote = !empty($attendanceStartNote) ? $attendanceStartNote : "";
        $attendanceEndNote = !empty($attendanceEndNote) ? $attendanceEndNote : "";
        $this->beginTransaction();
        try {
                $query = "INSERT INTO attendances (userId, attendanceStartTime, attendanceEndTime, attendanceStartNote,attendanceEndNote) VALUES (?, ?, ?, ?,?)";
                $setData = array($userId, $attendanceStartTime, $attendanceEndTime, $attendanceStartNote,$attendanceEndNote);

                $insertedId = $this->save($query, $setData);
            $this->commitTransaction();
            //debug($insertedIds);
            return json_encode([
                "status" => "SUCCESS_ATTENDANCE_INSERT",
                "insertedId"=>$insertedId
            ]);
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }
    public function updateCheckOut($userId,  $currentTime, $attendanceEndNote): false|string
    {
        $attendanceEndNote = !empty($attendanceEndNote) ? $attendanceEndNote : "";
        $this->beginTransaction();
        try {
            $query = "SELECT * FROM attendances WHERE userId = ? AND DATE(attendanceCreatedIn) = CURDATE()";
            $request = $this->find($query, [$userId]);

            if (empty($request)) {
                return json_encode([
                    "status" => "ERROR_ATTENDANCE_NOT_FOUND"
                ]);
            }
            if (!isset($request['attendanceEndTime']) || empty($request['attendanceEndTime']) || $request['attendanceEndTime'] === "00:00:00") {
                // Obtener el ID del usuario
                $attendanceId = $request['userId'];

                // Query para actualizar la hora de salida
                $query = "UPDATE attendances 
              SET attendanceEndTime = ?, attendanceEndNote = ? 
              WHERE userId = ? AND DATE(attendanceCreatedIn) = CURDATE()";  // Asegurar que solo actualizamos el de hoy

                $setData = array($currentTime, $attendanceEndNote, $attendanceId);
                $updatedRows = $this->updateRecord($query, $setData);
                if ($updatedRows > 0) {
                    return json_encode([
                        "status" => "SUCCESS_ATTENDANCE_UPDATE"
                    ]);
                } else {
                    return json_encode([
                        "status" => "ERROR_ATTENDANCE_UPDATE_FAILED"
                    ]);
                }
            } else {
                return json_encode([
                    "status" => "ERROR_ATTENDANCE_ALREADY_REGISTERED"
                ]);
            }
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }
}