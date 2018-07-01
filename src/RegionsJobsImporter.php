<?php

require_once __DIR__ . '/JobsImporterInterface.php';

class RegionsJobsImporter implements JobsImporterInterface
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function load($file)
    {
        /* remove existing items */
        //$this->db->exec('DELETE FROM job');

        /* parse XML file */
        $xml = simplexml_load_file($file);

        /* import each item */
        $count = 0;
        foreach ($xml->item as $item) {
            $this->db->exec('INSERT INTO job (reference, title, description, url, company_name, publication) VALUES ('
                . '\'' . addslashes($item->ref) . '\', '
                . '\'' . addslashes($item->title) . '\', '
                . '\'' . addslashes($item->description) . '\', '
                . '\'' . addslashes($item->url) . '\', '
                . '\'' . addslashes($item->company) . '\', '
                . '\'' . addslashes($item->pubDate) . '\')'
            );
            $count++;
        }
        return $count;
    }
}
