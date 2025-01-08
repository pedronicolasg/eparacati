<?php

class ClassManager{
  private $conn;

  public function __construct($conn){
    $this->conn = $conn;
  }

  public function editClass($id, $name, $teacher_id){
    $stmt = $this->conn->prepare('UPDATE classes SET name = ?, teacher_id = ? WHERE id = ?');
    $stmt->bind_param('sii', $name, $teacher_id, $id);
    $stmt->execute();
    $stmt->close();
  }

  public function deleteClass($id){
    $stmt = $this->conn->prepare('DELETE FROM classes WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
  }

  public function getClasses(){
    $stmt = $this->conn->prepare('SELECT * FROM classes');
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getClass($id){
    $stmt = $this->conn->prepare('SELECT * FROM classes WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
  }
}