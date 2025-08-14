<?php
class Permissions extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function permissions(): void
    {
        $data["PAGE_NAME"]     = "permissions";


        $this->views->getViews($this, 'permissions', $data);
    }

    /**
     * @throws Exception
     */
    public function assign($id): void
    {
        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }


        $verifiedId = verifyId('users', 'userId', $id);
        if (empty($verifiedId['total']) || $verifiedId['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }

        $modules = $this->model->getModules($id);
        $permissionsRole = $this->model->permissionRoleId($id);
        //debug($permissionsRole);
        $defaultPermissions = ['c' => 0, 'r' => 0, 'u' => 0, 'd' => 0];
        $data1 = ['roleId' => $id];


        foreach ($modules as &$module) {
            $module['permissions'] = $defaultPermissions;

            foreach ($permissionsRole as $permRole) {
                //debug($permRole);
                if ($permRole['moduleId'] === $module['moduleId']) {
                    $module['permissions'] = [
                        'c' => $permRole['c'],
                        'r' => $permRole['r'],
                        'u' => $permRole['u'],
                        'd' => $permRole['d'],
                    ];
                    break;
                }
            }
        }

        $data1['modules'] = $modules;

        $data["userId"] = $id;
        $this->views->getViews($this, 'assign', $data, $data1);
    }
    public function assignPermissions(): void
    {
        $modules = $_POST['module'];
        $roleId = $_POST['roleId'];
        // Llama al modelo para asignar permisos
        $request= $this->model->assignPermissions($modules, $roleId);
        $response = json_decode($request, true);
        switch ($response["status"]) {
            case "SUCCESS_PERMISSIONS_UPDATE":

                echo json_encode(array(
                    'status' => 'success',
                    'message'=> 'Permisos actualizados...',
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