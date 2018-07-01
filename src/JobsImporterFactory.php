<?php

require_once __DIR__ . '/RegionsJobsImporter.php';
require_once __DIR__ . '/CadreEmploiJobsImporter.php';

require_once __DIR__ . '/../db.php';

class JobsImporterFactory
{
    public static function create($type)
    {
        switch($type) {
            case 'cadremploi':
                return new CadreEmploiJobsImporter(DB::getConnection()); // Dependency Injection
            case 'regionsjob':
                return new RegionsJobsImporter(DB::getConnection());
            default:
                throw new Exception('Unknown publisher');
        }
    }
}