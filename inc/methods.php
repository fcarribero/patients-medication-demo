<?php

// Get all patients that are taking one particular medication
function getPatientsByMedication($medicationId) {
    global $db;

    return $db->select(
        'patient_medication LEFT JOIN patients ON patients.id = patient_medication.patient_id LEFT JOIN medications ON medications.id = patient_medication.medication_id',
        ['patients.name AS patient_name', 'medications.name AS medication_name'],
        'medication_id = ' . $medicationId,
        null,
        'patients.id'
    );
}

// Get all patients and prescriptions count by year
function getPatientsPrescriptionsCountByYear($year) {
    global $db;

    return $db->select(
        'patients RIGHT JOIN patient_medication ON patients.id = patient_medication.patient_id',
        ['patients.name', 'COUNT(patient_medication.id) as prescriptions'],
        'YEAR(patient_medication.start_by) = ' . $year,
        'prescriptions DESC',
        'patients.id'
    );
}

// Get all medications for one particular patient
function getMedicationsByPatient($patientId) {
    global $db;

    return $db->select(
        'patient_medication LEFT JOIN medications ON patient_medication.medication_id = medications.id LEFT JOIN patients ON patient_medication.patient_id = patients.id LEFT JOIN doctors ON patients.doctor_id = doctors.id',
        ['patients.name AS patient_name', 'doctors.name AS doctor_name', 'medications.name AS medication_name', 'medications.dose', 'patient_medication.quantity', 'patient_medication.frequency_hours', 'patient_medication.start_by', 'patient_medication.end_by'],
        'patient_id = ' . $patientId
    );
}

// Get all patients that prescribed more than one medication for the previous and current year
function getPatientsWithMultipleMedications($currentYear) {
    global $db;

    return $db->select(
        'patient_medication LEFT JOIN patients ON patient_medication.patient_id = patients.id',
        ['patients.name'],
        '(SELECT COUNT(*) FROM patient_medication AS pm2 WHERE pm2.patient_id = patient_medication.patient_id AND (
        ' . $currentYear . ' BETWEEN YEAR(pm2.start_by) AND YEAR(pm2.end_by) OR
        ' . ($currentYear - 1) . ' BETWEEN YEAR(pm2.start_by) AND YEAR(pm2.end_by)
    )) > 1',
        null,
        'patient_medication.patient_id'
    );
}