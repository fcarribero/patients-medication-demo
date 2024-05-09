<?php

require_once __DIR__ . '/lib/MyDatabase.php';
require_once __DIR__ . '/inc/misc.php';
require_once __DIR__ . '/inc/methods.php';

$db = new MyDatabase;

buildDB($argv[1]);

$patients = getPatientsByMedication(2);
echo "Get all patients that are taking one particular medication\n";
echo drawDataTable($patients) . "\n\n";

$patients_prescriptions = getPatientsPrescriptionsCountByYear(2021);
echo "Get all patients and prescriptions count for current year ordered by\n";
echo drawDataTable($patients_prescriptions) . "\n\n";

$medications = getMedicationsByPatient(4);
echo "Get all medications for one particular patient\n";
echo drawDataTable($medications) . "\n\n";

$patients_multiple_medications = getPatientsWithMultipleMedications(2021);
echo "Get all patients that prescribed more than one medication for the previous and current year\n";
echo drawDataTable($patients_multiple_medications) . "\n\n";
