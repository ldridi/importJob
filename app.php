<?php

require_once __DIR__ . '/src/JobsImporterFactory.php';
require_once __DIR__ . '/src/JobsLister.php';

require_once __DIR__ . '/db.php'; // Singleton design pattern (keep one pdo instance in memory)
require_once __DIR__ . '/lib/Config.php';

echo sprintf("Starting...\n");

$publishers = explode(',', Config::get('application')['publishers']);

foreach($publishers as $publisher) {
    $driver = JobsImporterFactory::create($publisher); // Factory design pattern (return instance by type)

    $count = $driver->load('data/'.$publisher.'.xml'); // Strategy design pattern (same feature but different implementation)
    echo sprintf("> %d %s jobs imported.\n", $count, ucfirst($publisher));
}

/* list jobs */
$jobsLister = new JobsLister(DB::getConnection()); // Dependency Injection
$jobs = $jobsLister->listJobs();
echo sprintf("> all jobs (%d):\n", count($jobs));
foreach ($jobs as $job) {
    echo sprintf(" %d: %s - %s - %s\n", $job['id'], $job['reference'], $job['title'], $job['publication']);
}


echo sprintf("Done.\n");

/* Steps to add more publishers
1. add xml file to data folder
2. create class in src/ which implements JobsImporterInterface
3. redefine load method and add inside specific implementation to load jobs
4. add this publisher type to src/JobsImporterFactory class
*/