<?php
require_once "core/conn.php";

require_once "models/User.php";
require_once "models/Schedule.php";

require_once "utils/Security.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

class ClassModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    private function getSecurity()
    {
        return new Security($this->conn);
    }

    private function getUserModel()
    {
        return new UserModel($this->conn);
    }

    private function getScheduleModel()
    {
        return new ScheduleModel($this->conn);
    }

    public function count($filters = [])
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM classes c
                    LEFT JOIN users pdt ON c.pdt_id = pdt.id
                    LEFT JOIN users leader ON c.leader_id = leader.id
                    LEFT JOIN users vice ON c.vice_leader_id = vice.id';

            $params = [];
            $conditions = [];

            if (!empty($filters)) {
                if (isset($filters['grade'])) {
                    $conditions[] = 'c.grade = :grade';
                    $params[':grade'] = $filters['grade'];
                }
                if (isset($filters['searchTerm'])) {
                    $conditions[] = '(c.name LIKE :search OR pdt.name LIKE :search OR leader.name LIKE :search OR vice.name LIKE :search)';
                    $params[':search'] = '%' . $filters['searchTerm'] . '%';
                }
            }

            if (!empty($conditions)) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }

            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Navigation::alert(
                "Erro ao contar as turmas",
                $e->getMessage(),
                "error",
                $_SERVER['HTTP_REFERER']
            );
            return ['total' => 0];
        }
    }

    public function get($filters = [], $limit = null, $offset = null)
    {
        try {
            $sql = '
                SELECT
                    c.*,
                    pdt.id AS pdt_user_id, pdt.name AS pdt_name, pdt.email AS pdt_email, 
                    pdt.phone AS pdt_phone, pdt.role AS pdt_role, pdt.profile_photo AS pdt_profile_photo,
                    leader.id AS leader_user_id, leader.name AS leader_name, leader.email AS leader_email, 
                    leader.phone AS leader_phone, leader.role AS leader_role, leader.profile_photo AS leader_profile_photo,
                    vice.id AS vice_user_id, vice.name AS vice_name, vice.email AS vice_email, 
                    vice.phone AS vice_phone, vice.role AS vice_role, vice.profile_photo AS vice_profile_photo
                FROM classes c
                LEFT JOIN users pdt ON c.pdt_id = pdt.id
                LEFT JOIN users leader ON c.leader_id = leader.id
                LEFT JOIN users vice ON c.vice_leader_id = vice.id
            ';

            $params = [];
            $conditions = [];

            if (!empty($filters)) {
                if (isset($filters['grade'])) {
                    $conditions[] = 'c.grade = :grade';
                    $params[':grade'] = $filters['grade'];
                }
                if (isset($filters['searchTerm'])) {
                    $conditions[] = '(c.name LIKE :search OR pdt.name LIKE :search OR leader.name LIKE :search OR vice.name LIKE :search)';
                    $params[':search'] = '%' . $filters['searchTerm'] . '%';
                }
            }

            if (!empty($conditions)) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }
            
            $sql .= ' ORDER BY c.name ASC, c.grade ASC';

            if ($limit !== null) {
                $sql .= ' LIMIT :limit';
                $params[':limit'] = (int)$limit;
            }
            if ($offset !== null) {
                $sql .= ' OFFSET :offset';
                $params[':offset'] = (int)$offset;
            }

            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                if ($key === ':limit' || $key === ':offset') {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results = $stmt->fetchAll();

            $classes = [];
            foreach ($results as $row) {
                $class = array_intersect_key($row, array_flip([
                    'id',
                    'name',
                    'grade',
                    'pdt_id',
                    'leader_id',
                    'vice_leader_id',
                    'created_at',
                    'updated_at',
                    'upgrades_in',
                    'ends_in'
                ]));

                $roles = [
                    'pdt' => ['id' => 'pdt_id', 'expected' => 'pdt', 'prefix' => 'pdt_'],
                    'leader' => ['id' => 'leader_id', 'expected' => 'lider', 'prefix' => 'leader_'],
                    'vice' => ['id' => 'vice_leader_id', 'expected' => 'vice_lider', 'prefix' => 'vice_']
                ];

                foreach ($roles as $role => $config) {
                    $infoKey = $role === 'pdt' ? 'pdt_info' : ($role === 'leader' ? 'leader_info' : 'vice_leader_info');
                    $class[$infoKey] = null;

                    $roleId = $row[$config['id']];
                    $roleField = $config['prefix'] . 'role';

                    if ($roleId && isset($row[$roleField])) {
                        if ($row[$roleField] === $config['expected']) {
                            $class[$infoKey] = [
                                'id' => $row[$config['prefix'] . 'user_id'],
                                'name' => $row[$config['prefix'] . 'name'],
                                'email' => $row[$config['prefix'] . 'email'],
                                'phone' => $row[$config['prefix'] . 'phone'],
                                'role' => $row[$roleField],
                                'profile_photo' => $row[$config['prefix'] . 'profile_photo']
                            ];
                        } else {
                            $this->handleUserRoleChange($roleId, $row[$roleField]);
                        }
                    }
                }

                $classes[] = $class;
            }

            return $classes;
        } catch (PDOException $e) {
            Navigation::alert(
                "Erro ao buscar as turmas",
                $e->getMessage(),
                "error",
                $_SERVER['HTTP_REFERER']
            );
            return [];
        }
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

    public function create($name, $grade, $pdtId = null, $leaderId = null, $viceLeaderId = null, $startNewTransaction = true)
    {
        try {
            if ($startNewTransaction && !$this->conn->inTransaction()) {
                $this->conn->beginTransaction();
            }

            $security = $this->getSecurity();
            $userModel = $this->getUserModel();

            $roleIds = array_filter([$pdtId, $leaderId, $viceLeaderId]);
            $validUsers = [];
            if ($roleIds) {
                $placeholders = implode(',', array_fill(0, count($roleIds), '?'));
                $stmt = $this->conn->prepare("SELECT id, role FROM users WHERE id IN ($placeholders)");
                $stmt->execute($roleIds);
                $validUsers = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'role', 'id');
            }

            $roles = [
                'pdt' => ['id' => $pdtId, 'role' => 'pdt', 'default_role' => 'professor'],
                'lider' => ['id' => $leaderId, 'role' => 'lider', 'default_role' => 'aluno'],
                'vice_lider' => ['id' => $viceLeaderId, 'role' => 'vice_lider', 'default_role' => 'aluno']
            ];

            foreach ($roles as $role => $data) {
                if ($data['id'] && !isset($validUsers[$data['id']])) {
                    if ($startNewTransaction) {
                        $this->conn->rollBack();
                    }
                    Navigation::alert(
                        "Usuário não encontrado",
                        "Usuário com cargo $role não encontrado.",
                        "error",
                        "../../../dashboard/pages/turmas.php"
                    );
                    return false;
                }
            }

            $id = $security->generateUniqueId(8);
            $created_at = date("d-m-Y H:i:s");
            $upgrades_in = date("d-m-Y", strtotime("next year January 1st"));
            $ends_in = ($grade == 3) ? $upgrades_in : null;

            $stmt = $this->conn->prepare('
                INSERT INTO classes (id, name, grade, pdt_id, leader_id, vice_leader_id, created_at, upgrades_in, ends_in)
                VALUES (:id, :name, :grade, :pdt_id, :leader_id, :vice_leader_id, :created_at, :upgrades_in, :ends_in)
            ');
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'grade' => $grade,
                'pdt_id' => $pdtId,
                'leader_id' => $leaderId,
                'vice_leader_id' => $viceLeaderId,
                'created_at' => $created_at,
                'upgrades_in' => $upgrades_in,
                'ends_in' => $ends_in
            ]);

            foreach ($roles as $data) {
                if ($data['id']) {
                    $userModel->updateClass($data['id'], $id);
                    $userModel->updateRole($data['id'], $data['role']);
                }
            }

            if ($startNewTransaction) {
                $this->conn->commit();
            }
            return true;
        } catch (Exception $e) {
            if ($startNewTransaction) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function bulkCreate($filePath)
    {
        try {
            $this->conn->beginTransaction();
            $security = $this->getSecurity();
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            $results = ['success' => 0, 'errors' => [], 'created_classes' => []];
            $classData = [];
            $chunkSize = 100;

            $emails = [];
            foreach ($rows as $index => $row) {
                if (empty($row[0]) && empty($row[1]) && empty($row[3]) && empty($row[4])) {
                    continue;
                }
                if (empty($row[0]) || empty($row[1])) {
                    $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
                    continue;
                }
                foreach ([2, 3, 4] as $i) {
                    if (!empty($row[$i]) && filter_var($row[$i], FILTER_VALIDATE_EMAIL)) {
                        $emails[$row[$i]] = $index;
                    }
                }
            }

            $userIds = [];
            if ($emails) {
                $placeholders = implode(',', array_fill(0, count($emails), '?'));
                $stmt = $this->conn->prepare("SELECT id, email FROM users WHERE email IN ($placeholders)");
                $stmt->execute(array_keys($emails));
                $userIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id', 'email');
            }

            foreach ($rows as $index => $row) {
                if (empty($row[0]) || empty($row[1])) {
                    continue;
                }

                $roleIds = [];
                foreach ([2, 3, 4] as $i) {
                    $roleIds[$i] = !empty($row[$i]) && filter_var($row[$i], FILTER_VALIDATE_EMAIL) ? ($userIds[$row[$i]] ?? null) : $row[$i];
                    if (!empty($row[$i]) && filter_var($row[$i], FILTER_VALIDATE_EMAIL) && !isset($userIds[$row[$i]])) {
                        $results['errors'][] = "Linha " . ($index + 2) . ": Usuário com email $row[$i] não encontrado";
                        continue 2;
                    }
                }

                $id = $security->generateUniqueId(8);
                $classData[] = [
                    'id' => $id,
                    'name' => $row[0],
                    'grade' => $row[1],
                    'pdt_id' => $roleIds[2],
                    'leader_id' => $roleIds[3],
                    'vice_leader_id' => $roleIds[4],
                    'created_at' => date("d-m-Y H:i:s"),
                    'upgrades_in' => date("d-m-Y", strtotime("next year January 1st")),
                    'ends_in' => $row[1] == 3 ? date("d-m-Y", strtotime("next year January 1st")) : null
                ];
                $results['created_classes'][$row[0]] = $id;
            }

            foreach (array_chunk($classData, $chunkSize) as $chunk) {
                try {
                    $values = [];
                    $params = [];
                    foreach ($chunk as $index => $data) {
                        $values[] = "(:id_$index, :name_$index, :grade_$index, :pdt_id_$index, :leader_id_$index, :vice_leader_id_$index, :created_at_$index, :upgrades_in_$index, :ends_in_$index)";
                        $params = array_merge($params, [
                            "id_$index" => $data['id'],
                            "name_$index" => $data['name'],
                            "grade_$index" => $data['grade'],
                            "pdt_id_$index" => $data['pdt_id'],
                            "leader_id_$index" => $data['leader_id'],
                            "vice_leader_id_$index" => $data['vice_leader_id'],
                            "created_at_$index" => $data['created_at'],
                            "upgrades_in_$index" => $data['upgrades_in'],
                            "ends_in_$index" => $data['ends_in']
                        ]);
                    }

                    $sql = 'INSERT INTO classes (id, name, grade, pdt_id, leader_id, vice_leader_id, created_at, upgrades_in, ends_in)
                            VALUES ' . implode(',', $values);
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute($params);

                    $roleUpdates = [];
                    $classUpdates = [];
                    foreach ($chunk as $data) {
                        foreach (['pdt_id' => 'pdt', 'leader_id' => 'lider', 'vice_leader_id' => 'vice_lider'] as $key => $role) {
                            if ($data[$key]) {
                                $roleUpdates[] = [$data[$key], $role];
                                $classUpdates[] = [$data[$key], $data['id']];
                            }
                        }
                    }

                    if ($roleUpdates) {
                        $values = array_map(fn($i) => "(:user_id_$i, :role_$i)", array_keys($roleUpdates));
                        $sql = 'INSERT INTO users (id, role) VALUES ' . implode(',', $values) . ' ON DUPLICATE KEY UPDATE role = VALUES(role)';
                        $stmt = $this->conn->prepare($sql);
                        $params = [];
                        foreach ($roleUpdates as $i => [$userId, $role]) {
                            $params["user_id_$i"] = $userId;
                            $params["role_$i"] = $role;
                        }
                        $stmt->execute($params);
                    }

                    if ($classUpdates) {
                        $values = array_map(fn($i) => "(:user_id_$i, :class_id_$i)", array_keys($classUpdates));
                        $sql = 'INSERT INTO users (id, class_id) VALUES ' . implode(',', $values) . ' ON DUPLICATE KEY UPDATE class_id = VALUES(class_id)';
                        $stmt = $this->conn->prepare($sql);
                        $params = [];
                        foreach ($classUpdates as $i => [$userId, $classId]) {
                            $params["user_id_$i"] = $userId;
                            $params["class_id_$i"] = $classId;
                        }
                        $stmt->execute($params);
                    }

                    $results['success'] += count($chunk);
                } catch (Exception $e) {
                    $results['errors'][] = "Erro no lote: " . $e->getMessage();
                }
            }

            $this->conn->commit();
            return $results;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
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

            $userModel = $this->getUserModel();
            foreach ($roles as $roleId => $roleData) {
                if ($currentClass[$roleId] != $roleData['new']) {
                    $userModel->updateRole($currentClass[$roleId], $roleData['default']);
                    $userModel->updateClass($currentClass[$roleId], null);
                    if ($roleData['new']) {
                        $userModel->updateRole($roleData['new'], $roleData['role']);
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

            $userModel = $this->getUserModel();
            foreach ($roles as $roleId => $role) {
                if ($class[$roleId]) {
                    $userModel->updateRole($class[$roleId], $role);
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

            $scheduleModel = $this->getScheduleModel();
            $scheduleModel->cancel(['class_id' => $id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
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
            $placeholders = implode(", ", array_map(function ($key) {
                return ":role_$key";
            }, array_keys($roles)));
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

                $updateStmt = $this->conn->prepare('UPDATE classes SET grade = ?, upgrades_in = ?, ends_in = ?, updated_at = ? WHERE id = ?');

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
}
