<?php

namespace App\DataFixtures;

use App\Entity\BloodGroup;
use App\Entity\Document;
use App\Entity\Drug;
use App\Entity\Gender;
use App\Entity\IndividualVisit;
use App\Entity\Patient;
use App\Entity\Period;
use App\Entity\Repeat;
use App\Entity\TourVisit;
use App\Entity\Treatment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {}
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        //Creation des groupes sanguin
        $bloodGroupsValues = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-');
        $bloodGroups = array();
        for ($i = 0; $i < 8; $i++) {
            $bloodGroup = new BloodGroup();
            $bloodGroup->setLabel($bloodGroupsValues[$i]);
            $manager->persist($bloodGroup);
            array_push($bloodGroups, $bloodGroup);
        }

        //Creation des medicaments
        $drugsValues = array('Paracetamol', 'Efferalgan', 'Levothyrox', 'Spasfon', 'Magne B6', 'Gaviscon', 'Mopral', 'Toplexil', 'Xanax');
        $drugs = array();
        for ($i = 0; $i < 9; $i++) {
            $drug = new Drug();
            $drug->setLabel($drugsValues[$i]);
            $manager->persist($drug);
            array_push($drugs, $drug);
        }

        //Creation des genres
        $gendersValues = array('Homme', 'Femme', 'Non renseigné');
        $genders = array();
        for ($i = 0; $i < 3; $i++) {
            $gender = new Gender();
            $gender->setLabel($gendersValues[$i]);
            $manager->persist($gender);
            array_push($genders, $gender);
        }

        //Creation des periods
        $periodsValues = array('1 jour', '2 jours', '3 jours', '1 semaine', '2 semaines', '3 semaines');
        $periods = array();
        for ($i = 0; $i < 6; $i++) {
            $period = new Period();
            $period->setLabel($periodsValues[$i]);
            $manager->persist($period);
            array_push($periods, $period);
        }

        //Creation des repetition
        $repeatsValues = array('Matin', 'Midi', 'Soir');
        $repeats = array();
        for ($i = 0; $i < 3; $i++) {
            $repeat = new Repeat();
            $repeat->setLabel($repeatsValues[$i]);
            $manager->persist($repeat);
            array_push($repeats, $repeat);
        }


        //Creation des patients
        $patients = array();
        for ($i = 0; $i < 255; $i++) {
            $patient = new Patient();
            $patient->setFirstName($faker->firstName);
            $patient->setLastName($faker->lastName);
            $patient->setNotes($faker->realText());
            $patient->setHeight($faker->numberBetween(30, 220));
            $patient->setWeight($faker->numberBetween(3, 200));

            $allergies = array();
            if ($faker->boolean()) {
                array_push($allergies, 'Aucune');
            }
            else {
                $allergies = $faker->words($faker->numberBetween(1,4));
            }
            $patient->setAllergies(implode(', ', $allergies));

            $genderNumber = $faker->numberBetween(0, count($genders)-1);
            $patient->setGender($genders[$genderNumber]);
            $patient->setBloodGroup($faker->randomElement($bloodGroups));

            if ($genderNumber == 2) {
                $genderNumber = $faker->numberBetween(0, 1);
            }
            $patient->setSocialNumber(
                strval($genderNumber+1) .
                sprintf("%02d", $faker->numberBetween(0, 99)) .
                sprintf("%02d", $faker->numberBetween(0, 12)) .
                sprintf("%02d", $faker->numberBetween(0, 96)) .
                sprintf("%03d", $faker->numberBetween(0, 999)) .
                sprintf("%03d", $faker->numberBetween(0, 999)) .
                sprintf("%02d", $faker->numberBetween(0, 99))
            );

            $manager->persist($patient);
            array_push($patients, $patient);
        }

        //Creation des documents
        for ($i = 0; $i < 1024; $i++) {
            $slugLength = $faker->numberBetween(1, 4);
            $slug = '';
            for ($y = 0; $y < $slugLength; $y++) {
                $slug .= $faker->word.'-';
            }

            $document = new Document();
            $document->setName($slug.$faker->randomNumber(8, true));
            $document->setExtension($faker->randomElement(array('pdf', 'odt', 'docx', 'jpg', 'png', 'gif')));
            $document->setUploadAt($faker->dateTime);
            $document->setPatient($faker->randomElement($patients));
            $manager->persist($document);
        }

        //Creation des visites individuelles
        for ($i = 0; $i < 128; $i++) {
            $individualVisit = new IndividualVisit();
            $individualVisit->setStartTime($faker->dateTime);
            $individualVisit->setDate($faker->dateTime);
            $individualVisit->setSubject($faker->realText(255));
            $individualVisit->setPatient($faker->randomElement($patients));
            $manager->persist($individualVisit);
        }

        //Creation des visites en tour
        for ($i = 0; $i < 32; $i++) {
            $time = $faker->dateTime;

            $tourVisit = new TourVisit();
            $tourVisit->setStartTime($time);
            $tourVisit->setTitle($faker->word);

            $NumberOfVisit = $faker->numberBetween(2, 8);
            for ($y = 0; $y < $NumberOfVisit; $y++) {
                $individualVisit = new IndividualVisit();
                $individualVisit->setStartTime($time);
                $individualVisit->setDate($time);
                $individualVisit->setSubject($faker->realText(255));
                $individualVisit->setPatient($faker->randomElement($patients));
                $individualVisit->setTourVisit($tourVisit);

                $manager->persist($individualVisit);
                $time->add(new \DateInterval('PT'.$faker->numberBetween(30, 150).'M'));
            }

            $manager->persist($tourVisit);
        }

        //Creation des traitements
        for ($i = 0; $i < 128; $i++) {
            $treatment = new Treatment();

            $numberOfDrug = $faker->numberBetween(1, 4);
            $drugUse = array();
            while (count($drugUse) < $numberOfDrug) {
                $drug = $faker->randomElement($drugs);
                if (!in_array($drug, $drugUse)) {
                    $treatment->addDrug($drug);
                    array_push($drugUse, $drug);
                }
            }

            $numberOfRepeat = $faker->numberBetween(1, 3);
            $repeatUse = array();
            while (count($repeatUse) < $numberOfRepeat) {
                $repeat = $faker->randomElement($repeats);
                if (!in_array($repeat, $repeatUse)) {
                    $treatment->addRepetition($repeat);
                    array_push($repeatUse, $repeat);
                }
            }

            $treatment->setDuration($faker->randomElement($periods));
            $treatment->setPatient($faker->randomElement($patients));
            $manager->persist($treatment);
        }

        //Creation des utilisateurs
        for ($i = 0; $i < 16; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $plaintextPassword = 'toto';
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
