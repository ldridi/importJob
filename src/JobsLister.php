<?php

class JobsLister
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function listJobs()
    {
        $jobs = $this->db->query('SELECT id, reference, title, description, url, company_name, publication FROM job')->fetchAll(PDO::FETCH_ASSOC);
        return $jobs;
    }
}
