<?php

class Patient{
    public $id;
    public $name;
    public $medicalHistory;
    public $treatmentHistory;

    public function __construct($id, $name)
    {
        $this->name = $name;
        $this->id = $id;
        $this->medicalHistory = array();
        $this->treatmentHistory = array();
    }

    public function addDiagnosis(String $diagnosis){
        array_push($this->medicalHistory, $diagnosis);
    }

    public function addTreatment(String $treatment){
        array_push($this->treatmentHistory,$treatment);
    }

    public function __toString(): string
    {
        return $this->id.' '.$this->name;
    }

    public function getMedicalHistory(): array
    {
        return $this->medicalHistory;
    }

}

enum specialization: string{
    case FAMILY_MEDICINE = 'family_medicine';
    case CARDIOLOGY = 'cardiology';
    case NEUROLOGY = 'neurology';
    case RADIOLOGY = 'radiology';
}

abstract class Doctor{
    public $id;
    public $name;
    public specialization $specialization;
    public $experience;
    public $patients;

    public function __construct($id, $name, $experience, specialization $specialization)
    {
        $this->id = $id;
        $this->specialization = $specialization;
        $this->experience = $experience;
        $this->patients = array();
        $this->name = $name;
    }

    public function addPatient(Patient $patient){
        $this->patients[$patient->id] = $patient;
    }

    public function printPatients()
    {
        print "Patients of doctor $this->name: ";
        foreach($this->patients as $patient){
            print $patient." ";
        }
        print "\n";
    }
}

class FamilyDoctor extends Doctor{
    use Treatable;
    public function __construct($id, $name, $experience, specialization $specialization=Specialization::FAMILY_MEDICINE)
    {
        parent::__construct($id, $name, $experience, $specialization);
    }

    public function refer(Patient $patient, array $doctors, Specialization $specialization): Doctor
    {
        $max = $doctors[0];
        foreach ($doctors as $doctor){
            if ($doctor->experience>$max->experience){
                $max = $doctor;
            }
        }

        if (isset($max->patients[$patient->id])) {
            print "Patient $patient is already referred\n";
            return $max;
        }
        $max->patients[$patient->id] = $patient;
        return $max;
    }
}

class Specialist extends Doctor{
    public function __construct($id, $name, $experience, specialization $specialization)
    {
        parent::__construct($id, $name, $experience, $specialization);
    }

    public function treatPatient (Patient $patient, String $treatment){
        $patient->addTreatment($treatment);
        unset($this->patients[$patient->id]);
    }
}

trait Treatable{
    public function diagnose(Patient $patient, string $diagnosis){
        $patient->addDiagnosis($diagnosis);
    }
}

// Create patients
$john = new Patient(1, "John Doe");
$jane = new Patient(2, "Jane Smith");

// Create doctors
$familyDoctor = new FamilyDoctor("D001", "Dr. Brown", 12);
$cardiologist1 = new Specialist("D002", "Dr. Heart", 8, Specialization::CARDIOLOGY);
$cardiologist2 = new Specialist("D003", "Dr. Pulse", 15, Specialization::CARDIOLOGY);
$neurologist = new Specialist("D004", "Dr. Brain", 10, Specialization::NEUROLOGY);

// Add patient to family doctor
$familyDoctor->addPatient($john);
$familyDoctor->diagnose($john, 'High blood pressure');
// Print before referral
$familyDoctor->printPatients();

// Refer John to cardiologist (most experienced one)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], Specialization::CARDIOLOGY);
echo "Referred patient with id $john->id to doctor $treatingDoctor->name\n";

// Refer the same patient again (should return that patient is already referred)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], Specialization::CARDIOLOGY);

$treatingDoctor->printPatients();

if ($treatingDoctor instanceof Specialist) {
    $treatingDoctor->treatPatient($john, 'Beta-blockers');
}

// Print specialists’ patients after referral
$treatingDoctor->printPatients();

// Show John’s medical history
echo "\nMedical history of {$john->name}:\n";
foreach ($john->getMedicalHistory() as $record) {
    echo "- $record\n";
}