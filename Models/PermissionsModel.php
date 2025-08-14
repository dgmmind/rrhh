<?php
/**
 *
 */
class PermissionsModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getModules(): ?array
    {
        $query   = "SELECT * FROM modules WHERE moduleStatus !=?";
        return $this->findAll($query,[0]);
    }

    /**
     * @throws Exception
     */
    public function permissionRoleId($id): ?array
    {
        $query   = "SELECT * FROM permissions WHERE roleId =?";
        return $this->findAll($query,[$id]);
    }

    /**
     * Asigna permisos a un rol específico basado en los módulos proporcionados.
     *
     * @param array $modules Lista de módulos con permisos (c, r, u, d).
     * @param int $roleId ID del rol al cual se asignarán los permisos.
     * @return array Lista de IDs insertados de los permisos creados.
     * @throws Exception Si ocurre un error durante la asignación de permisos.
     */

    public function assignPermissions(array $modules, int $roleId): false|string
    {
        // Iniciar la transacción
        $this->beginTransaction();
        //$insertedIds = [];

        try {
            $this->deletePermissions($roleId);

            foreach ($modules as $module) {
                $moduleId = $module['moduleId'];

                // Convertir los valores a enteros, donde 'on' se convierte en 1 y vacío en 0
                $c = !empty($module['c']) && $module['c'] === 'on' ? 1 : 0;
                $r = !empty($module['r']) && $module['r'] === 'on' ? 1 : 0;
                $u = !empty($module['u']) && $module['u'] === 'on' ? 1 : 0;
                $d = !empty($module['d']) && $module['d'] === 'on' ? 1 : 0;

                $query = "INSERT INTO permissions (roleId, moduleId, c, r, u, d) VALUES (?, ?, ?, ?, ?, ?)";
                $setData = array($roleId, $moduleId, $c, $r, $u, $d);

                $insertedId = $this->save($query, $setData);
                //$insertedIds[] = $insertedId;
            }

            $this->commitTransaction();
            //debug($insertedIds);
            return json_encode([
                "status" => "SUCCESS_PERMISSIONS_UPDATE"
            ]);
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->rollbackTransaction();
            throw $e; // Lanzar la excepción original para conservar el stack trace
        }
    }



    /**
     * Elimina permisos para los IDs de roles especificados.
     *
     * @param string $roleIds Una cadena de IDs de roles separados por comas.
     * @return string Estado de la eliminación de permisos.
     * @throws Exception Si ocurre un error durante la eliminación de permisos.
     */
//    public function deletePermissions(string $roleIds): string
//    {
//        debug($roleIds);
//        // Convertir los IDs en un arreglo para usarlos en la consulta
//        $roleIdsArray = explode(",", $roleIds);
//        $placeholders = implode(',', array_fill(0, count($roleIdsArray), '?'));
//
//        // Solo inicia una transacción si no hay una activa
//        if (!$this->inTransaction()) {
//            $this->beginTransaction();
//        }
//
//        try {
//            // Verificar si existen permisos para estos roleIds
//            $sql = "SELECT roleId FROM permissions WHERE roleId IN ($placeholders)";
//            $existingRoleIds = $this->findAll($sql, $roleIdsArray);
//
//            $countInputIds = count($roleIdsArray);
//            $countExistingIds = count($existingRoleIds);
//
//            if ($countExistingIds > 0) {
//                $deleteSql = "DELETE FROM permissions WHERE roleId IN ($placeholders)";
//                $this->deleteRecord($deleteSql, $roleIdsArray);
//
//                if (!$this->inTransaction()) {
//                    $this->commitTransaction();
//                }
//
//                return ($countInputIds > $countExistingIds) ? 'DATA_DELETE_INCOMPLETE' : 'DATA_DELETE';
//            }
//
//            // Si no hay permisos que eliminar, revertir transacción
//            if ($this->inTransaction()) {
//                $this->rollbackTransaction();
//            }
//            return 'empty';
//        } catch (Exception $e) {
//            // Revertir la transacción en caso de error
//            if ($this->inTransaction()) {
//                $this->rollbackTransaction();
//            }
//            throw $e; // Lanzar la excepción original para conservar el stack trace
//        }
//    }
    public function deletePermissions(int $roleId): string
    {
        // Solo inicia una transacción si no hay una activa
        if (!$this->inTransaction()) {
            $this->beginTransaction();
        }

        try {
            // Eliminar los permisos asociados al roleId recibido
            $sql = "DELETE FROM permissions WHERE roleId = ?";
            $this->deleteRecord($sql, [$roleId]);

            // Confirmar la transacción si no había una activa previamente
            if (!$this->inTransaction()) {
                $this->commitTransaction();
            }

            return 'DATA_DELETE';  // Devuelve un mensaje indicando que se eliminaron los permisos
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            if ($this->inTransaction()) {
                $this->rollbackTransaction();
            }
            throw $e; // Lanzar la excepción original para conservar el stack trace
        }
    }

    public function permissionsModule(int $roleId): array
    {
        // Iniciar la transacción
        $this->beginTransaction();

        try {
            // Preparar SQL con parámetros
            $sql = "SELECT p.roleId,
               p.moduleId,
               m.moduleName as module,
               p.c,
               p.r,
               p.u,
               p.d 
        FROM permissions p 
        INNER JOIN modules m ON p.moduleId = m.moduleId
        WHERE p.roleId =?";

            // Ejecutar la consulta pasando el parámetro correctamente
            $request = $this->findAll($sql, [$roleId]);

            //debug($request);
            // Armar el resultado
            $modules = [];
            foreach ($request as $item) {
                $modules[$item['moduleId']] = $item;
            }

            // Confirmar la transacción (si todo fue correcto)
            $this->commitTransaction();

            return $modules;

        } catch (Exception $e) {
            // Si ocurre un error, revertir la transacción
            $this->rollbackTransaction();

            // Lanzar una nueva excepción con el mensaje de error
            throw new Exception("Error al obtener los permisos del módulo: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}