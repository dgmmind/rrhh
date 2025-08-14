<?php
/**
 *
 */
class AuthModel extends Mysql
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
    public function setLogin($data): false|string
    {
        $this->strUserEmail = $data["userEmail"];
        $this->strUserPassword = $data["userPassword"];

        $query = "SELECT * FROM users WHERE userName = ?";
        $request = $this->find($query, [$this->strUserEmail]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_USER_NOT_FOUND"
            ]);
        }

        if ($request['userStatus'] == 0) {
            return json_encode([
                "status" => "ERROR_ACCOUNT_DISABLED"
            ]);
        }

        if (!password_verify($this->strUserPassword, $request['userPassword'])) {
            return json_encode([
                "status" => "ERROR_INVALID_PASSWORD"
            ]);
        }

        return json_encode([
            "status" => "SUCCESS_USER_VALID",
            "data" => $request
        ]);
    }

    /**
     * @throws Exception
     */
    public function sessionLogin(int $userId): void
    {
        $this->intUserId = $userId;
        $sql = "SELECT u.userId, u.userName, u.userStatus, u.roleId, r.roleName, r.roleDescription, r.roleStatus, p.profileNames, p.profileSurnames,profileIdentity
            FROM users u
            INNER JOIN profiles p 
            ON u.userId = p.userId
            INNER JOIN roles r 
            ON u.roleId = r.roleId
            WHERE u.userId = $this->intUserId";
        $request = $this->find($sql);
        $_SESSION['userData'] = $request;
    }
}

