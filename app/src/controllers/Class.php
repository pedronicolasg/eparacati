<?php
require_once "core/conn.php";

require_once "controllers/User.php";

require_once "utils/Security.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

class ClassController
{
    private $conn;
    private $security;
    private $userController;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->security = new Security($conn);
        $this->userController = new UserController($conn);
    }

    public function checkUpgrades()
    {
        $today = date("d-m-Y");

        $stmt = $this->conn->prepare('SELECT * FROM classes WHERE upgrades_in = ?');
        $stmt->execute([$today]);
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($classes as $class) {
            if ($class['grade'] == 3) {
                $this->delete($class['id'], true);
            } else {
                $newGrade = $class['grade'] + 1;
                $nextUpgrade = date("d-m-Y", strtotime("next year January 1st"));

                $ends_in = ($newGrade == 3) ? $nextUpgrade : null;

                $updateStmt = $this->conn->prepare('UPDATE classes SET grade = ?, upgrades_in = ?,  ends_in = ?, updated_at = ? WHERE id = ?');

                $updated_at = date("d-m-Y H:i:s");
                $updateStmt->execute([
                    $newGrade,
                    $nextUpgrade,
                    $ends_in,
                    $updated_at,
                    $class['id']
                ]);
            }
        }
    }

    public function count($filters = [])
    {
        $sql = 'SELECT COUNT(*) FROM classes';
        $params = [];

        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function create($name, $grade, $pdtId = null, $leaderId = null, $viceLeaderId = null, $startNewTransaction = true)
    {
        try {
            if ($startNewTransaction && !$this->conn->inTransaction()) {
                $this->conn->beginTransaction();
            }

            $id = $this->security->generateUniqueId(8, 'classes');
            $created_at = date("d-m-Y H:i:s");
            $upgrades_in = date("d-m-Y", strtotime("next year January 1st"));
            $ends_in = ($grade == 3) ? $upgrades_in : null;

            $roles = [
                $pdtId => 'pdt',
                $leaderId => 'lider',
                $viceLeaderId => 'vice_lider'
            ];

            foreach ($roles as $userId => $role) {
                if ($userId) {
                    $this->userController->updateRole($userId, $role);
                    $this->userController->updateClass($userId, $id);
                }
            }

            $stmt = $this->conn->prepare('INSERT INTO classes (id, name, grade, pdt_id, leader_id, vice_leader_id, created_at, upgrades_in, ends_in) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$id, $name, $grade, $pdtId, $leaderId, $viceLeaderId, $created_at, $upgrades_in, $ends_in]);

            if ($startNewTransaction) {
                $this->conn->commit();
            }
            return true;
        } catch (Exception $e) {
            if ($startNewTransaction) {
                $this->conn->rollback();
            }
            throw $e;
        }
    }

    public function bulkCreate($filePath)
    {
        try {
            if (!$this->conn->inTransaction()) {
                $this->conn->beginTransaction();
            }

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            $results = ['success' => 0, 'errors' => [], 'created_classes' => []];

            foreach ($rows as $index => $row) {
                try {
                    if (empty($row[0]) || empty($row[1])) {
                        $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
                        continue;
                    }

                    $roleIds = [];
                    foreach ([2, 3, 4] as $i) {
                        $roleIds[$i] = !empty($row[$i]) && filter_var($row[$i], FILTER_VALIDATE_EMAIL) ? $this->userController->getInfo($row[$i], 'email', ['id'])['id'] : $row[$i];
                    }

                    $id = $this->security->generateUniqueId(8, 'classes');
                    $this->create($row[0], $row[1], $roleIds[2], $roleIds[3], $roleIds[4], false);

                    $results['success']++;
                    $results['created_classes'][$row[0]] = $id;
                } catch (Exception $e) {
                    $results['errors'][] = "Linha " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->conn->commit();
            return $results;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function get()
    {
        $stmt = $this->conn->prepare('SELECT * FROM classes');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function getInfo($identifier, $type = 'id', $fields = [])
    {
        $defaultFields = ["id"];
        $allowedFields = ["id", "name", "grade", "pdt_id", "leader_id", "vice_leader_id", "created_at", "updated_at"];

        if (empty($fields)) {
            $fields = $allowedFields;
        } else {
            $fields = array_intersect($fields, $allowedFields);
            $fields = array_unique(array_merge($defaultFields, $fields));
        }

        $sqlFields = implode(", ", $fields);
        $sql = "";
        $params = [];

        if ($type === "id") {
            $sql = "SELECT $sqlFields FROM classes WHERE id = :id";
            $params = ["id" => $identifier];
        } elseif ($type === "name") {
            $sql = "SELECT $sqlFields FROM classes WHERE name = :name";
            $params = ["name" => $identifier];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getUsers($classId, $roles = [], $fields = [])
    {
        $defaultRoles = ['pdt', 'lider', 'vice_lider', 'aluno'];
        $defaultFields = ["id", "name", "role"];
        $allowedFields = ["id", "name", "email", "role", "class_id", "profile_photo", "website_theme", "created_at", "updated_at"];

        $roles = empty($roles) ? $defaultRoles : array_intersect($roles, $defaultRoles);
        $fields = empty($fields) ? $defaultFields : array_intersect($fields, $allowedFields);
        $fields = array_unique(array_merge($defaultFields, $fields));

        $sqlFields = implode(", ", $fields);
        $sql = "SELECT $sqlFields FROM users WHERE class_id = :class_id";

        if (!empty($roles)) {
            $placeholders = implode(", ", array_map(function($key) { return ":role_$key"; }, array_keys($roles)));
            $sql .= " AND role IN ($placeholders)";
        }

        $stmt = $this->conn->prepare($sql);
        $params = [':class_id' => $classId];
        foreach ($roles as $key => $role) {
            $params[":role_$key"] = $role;
        }
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function edit($id, $name, $grade, $pdtId = null, $leaderId = null, $viceLeaderId = null)
    {
        try {
            $this->conn->beginTransaction();

            $currentClass = $this->getInfo($id);
            $roles = [
                'pdt_id' => ['new' => $pdtId, 'default' => 'professor', 'role' => 'pdt'],
                'leader_id' => ['new' => $leaderId, 'default' => 'aluno', 'role' => 'lider'],
                'vice_leader_id' => ['new' => $viceLeaderId, 'default' => 'aluno', 'role' => 'vice_lider']
            ];


            foreach ($roles as $roleId => $roleData) {
                if ($currentClass[$roleId] != $roleData['new']) {
                    $this->userController->updateRole($currentClass[$roleId], $roleData['default']);
                    if ($roleData['new']) {
                        $this->userController->updateRole($roleData['new'], $roleData['role']);
                    }
                }
            }

            $updated_at = date("d-m-Y H:i:s");
            $stmt = $this->conn->prepare('UPDATE classes SET name = ?, grade = ?, pdt_id = ?, leader_id = ?, vice_leader_id = ?, updated_at = ? WHERE id = ?');
            $stmt->execute([$name, $grade, $pdtId, $leaderId, $viceLeaderId, $updated_at, $id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function handleUserDeletion($userId)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare('
                UPDATE classes
                SET
                    pdt_id = CASE WHEN pdt_id = ? THEN NULL ELSE pdt_id END,
                    leader_id = CASE WHEN leader_id = ? THEN NULL ELSE leader_id END,
                    vice_leader_id = CASE WHEN vice_leader_id = ? THEN NULL ELSE vice_leader_id END,
                    updated_at = ?
                WHERE pdt_id = ? OR leader_id = ? OR vice_leader_id = ?
            ');

            $updated_at = date("d-m-Y H:i:s");
            $stmt->execute([$userId, $userId, $userId, $updated_at, $userId, $userId, $userId]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function handleUserRoleChange($userId, $newRole)
    {
        try {
            $this->conn->beginTransaction();

            if (!in_array($newRole, ['pdt', 'lider', 'vice_lider'])) {
                $stmt = $this->conn->prepare('
                    UPDATE classes
                    SET
                        pdt_id = CASE WHEN pdt_id = ? THEN NULL ELSE pdt_id END,
                        leader_id = CASE WHEN leader_id = ? THEN NULL ELSE leader_id END,
                        vice_leader_id = CASE WHEN vice_leader_id = ? THEN NULL ELSE vice_leader_id END,
                        updated_at = ?
                    WHERE pdt_id = ? OR leader_id = ? OR vice_leader_id = ?
                ');

                $updated_at = date("d-m-Y H:i:s");
                $stmt->execute([$userId, $userId, $userId, $updated_at, $userId, $userId, $userId]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function delete($id, $deleteStudents = false)
    {
        try {
            $this->conn->beginTransaction();

            $class = $this->getInfo($id);

            $roles = [
                'pdt_id' => 'professor',
                'leader_id' => 'aluno',
                'vice_leader_id' => 'aluno'
            ];

            foreach ($roles as $roleId => $role) {
                if ($class[$roleId]) {
                    $this->userController->updateRole($class[$roleId], $role);
                }
            }

            $stmt = $this->conn->prepare('DELETE FROM classes WHERE id = ?');
            $stmt->execute([$id]);

            $deletedStudents = [];

            if ($deleteStudents) {
                $stmt = $this->conn->prepare('SELECT id, name FROM users WHERE role = \'aluno\' AND class_id = ?');
                $stmt->execute([$id]);
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($students as $student) {
                    $deletedStudents[$student['name']] = $student['id'];
                }

                $stmt = $this->conn->prepare('DELETE FROM users WHERE role = \'aluno\' AND class_id = ?');
                $stmt->execute([$id]);
            } else {
                $stmt = $this->conn->prepare('UPDATE users SET class_id = NULL WHERE role = \'aluno\' AND class_id = ?');
                $stmt->execute([$id]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
}
