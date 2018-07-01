<?php

require_once __DIR__ . '/JobsImporterInterface.php';

class CadreEmploiJobsImporter implements JobsImporterInterface
{
    private $db;

    /*private $mapper = [
        'reference' => 'reference',
        'title' => 'title',
        'description' => 'description',
        'url' => 'link',
        'company_name' => 'companyname',
        'publication' => (new DateTime($offer->publisheddate))->format('Y/m/d'))
    ];*/

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

        foreach ($xml->offer as $offer) {
            // @TODO validate xml (publisheddate)
            $this->db->exec('INSERT INTO job (reference, title, description, url, company_name, publication) VALUES ('
                . '\'' . addslashes($offer->reference) . '\', '
                . '\'' . addslashes($offer->title) . '\', '
                . '\'' . addslashes($offer->description) . '\', '
                . '\'' . addslashes($offer->link) . '\', '
                . '\'' . addslashes($offer->companyname) . '\', '
                . '\'' . addslashes((new DateTime($offer->publisheddate))->format('Y/m/d')) . '\')'
            ) or die(print_r($this->db->errorInfo(), true));
            $count++;
        }
        return $count;
    }
}
