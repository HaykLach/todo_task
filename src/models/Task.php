<?php
namespace Models;

use DateTime;
use \Models\Database;

class Task
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * CREATE
     * @return boolean
     */
    public function createTask($data) : object
    {
        $this->db->query("INSERT INTO task (`email`, `username`, `description`,`completed`, `created_at`, `updated_at`) VALUES (:email,:username,:description, 0, :created_at, :updated_at)");
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s', time()));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s', time()));
        if ($this->db->execute()) {
            return $this->getTask($this->db->lastInsertId());
        }
        return new \stdClass();
    }

    /**
     * @return int
     */
    public function rowCount(): int
    {
        $this->db->query("SELECT * FROM task ");
        if ($this->db->execute())
            return $this->db->rowCount();
        return 0;
    }

    /**
     * @param $id
     * @return object
     */
    public function getTask($id) : object
    {
        $this->db->query("SELECT * FROM task WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return $this->db->single();
        }
        return new \stdClass();
    }

    /**
     * READ
     * @return array
     */
    public function selectAll($limit, $offset, $sort_by, $order_by) : array
    {
        $sql = "SELECT * FROM task ";
        if (!empty($sort_by) && !empty($order_by)) {
            $sql .= " ORDER BY $sort_by $order_by";
        }
        $sql .= " LIMIT :limit, :offset";

        $this->db->query($sql);
        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $offset);
        return $this->db->resultSet();
    }

    /**
     * UPDATE
     * @return boolean
     */
    public function changeTaskStatus($id, $completed) : bool
    {
        $this->db->query("UPDATE task SET completed = :completed WHERE id = :id");
        $this->db->bind(':completed', $completed);
        $this->db->bind(':id', $id);
        if ($this->db->execute())
            return true;
        return false;
    }

    /**
     * @param $id
     * @param $description
     * @return bool
     */
    public function updateTaskDescription($id, $description): bool
    {
        $this->db->query("UPDATE task SET description = :description, updated_at = :updated_at WHERE id = :id");
        $this->db->bind(':description', $description);
        $this->db->bind(':id', $id);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s', time()));
        if ($this->db->execute())
            return true;
        return false;
    }

    /**
     * DELETE
     * @return boolean
     */
    public function deleteTask($id) : bool
    {
        $this->db->query("DELETE FROM task WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute())
            return true;
        return false;
    }
}
