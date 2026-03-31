<?php

namespace App\Imports;

use App\Models\RegistryNeonatal;
use App\Models\ICD10;
use App\Models\ICD10Temp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ICDRegistryNeonatalImport implements ToModel, WithStartRow, SkipsOnError, WithValidation
{
    use SkipsErrors;

    protected $month_year_icd;
    protected $registry_id;

    public function __construct($month_year_icd,$registry_id)
    {
        $this->month_year_icd = $month_year_icd;
        $this->registry_id = $registry_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {

            $icdCodes = [
                strtoupper($row[15]),
                strtoupper($row[17]),
                strtoupper($row[20]),
                strtoupper($row[23]),
                strtoupper($row[25]),
                strtoupper($row[27]),
                strtoupper($row[29])
            ];

            $icdExists = ICD10::where('isactive', true)
                                ->whereIn('description', $icdCodes)
                                ->pluck('description')
                                ->toArray();

            $icd10tempExists = ICD10Temp::where('isactive', true)
                                        ->whereIn('description', $icdCodes)
                                        ->pluck('description')
                                        ->toArray();

            foreach ($icdCodes as $icdCode) {
                if (!in_array($icdCode, $icdExists) && !in_array($icdCode, $icd10tempExists)) {
                    ICD10Temp::create([
                        'isactive' => true,
                        'description' => $icdCode,
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }

            return new RegistryNeonatal([
                'created_by' => auth()->user()->name,
                'is_active' => true,
                'patient_initial' => strtoupper($row[0]),
                'date_of_admission' => Date::excelToDateTimeObject($row[1]),
                'maturity' => strtoupper($row[2]),
                'gestational_age' => strtoupper($row[3]),
                'birth_weight' => strtoupper($row[4]),
                'weight_gestational_age' => strtoupper($row[5]),
                'presentation_upon_delivery' => strtoupper($row[6]),
                'manner_of_delivery' => strtoupper($row[7]),
                'gender' => strtoupper($row[8]),
                'apgar_score' => strtoupper($row[9]),
                'einc' => strtoupper($row[10]),
                'incomplete_einc_steps' => strtoupper($row[11]),
                'diagnosis1' => strtoupper($row[12]),
                'no_of_fetuses' => strtoupper($row[13]),
                'patient_birth_location' => strtoupper($row[14]),
                'icd_no_1' => strtoupper($row[15]),
                'diagnosis2' => strtoupper($row[16]),
                'icd_no_2' => strtoupper($row[17]),
                'highest_total_bilirubin' => strtoupper($row[18]),
                'diagnosis3' => strtoupper($row[19]),
                'icd_no_3' => strtoupper($row[20]),
                'respiratory_support' => strtoupper($row[21]),
                'diagnosis4' => strtoupper($row[22]),
                'icd_no_4' => strtoupper($row[23]),
                'diagnosis5' => strtoupper($row[24]),
                'icd_no_5' => strtoupper($row[25]),
                'diagnosis6' => strtoupper($row[26]),
                'icd_no_6' => strtoupper($row[27]),
                'diagnosis7' => strtoupper($row[28]),
                'icd_no_7' => strtoupper($row[29]),
                'baby_covid_status' => strtoupper($row[30]),
                'mother_covid_status' => strtoupper($row[31]),
                'kangaroo_mother_care' => strtoupper($row[32]),
                'type_feeding_discharge' => strtoupper($row[33]),
                'use_donor_human_milk' => strtoupper($row[34]),
                'discharge_outcome' => strtoupper($row[35]),
                'date_discharged' => Date::excelToDateTimeObject($row[36]),
                'month_year_icd' => $this->month_year_icd,
                'hospital_id' => auth()->user()->hospital_id,
                'registry_header_id' => $this->registry_id,
    
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            // Optionally, return null or handle the error as needed
        }
    }

    /**
     * Skip the first row of the spreadsheet.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Rules for validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Define your validation rules here; for example:
            // '0' => 'required|string|max:255', // patient_initial
            // Add more rules as needed for other columns.
        ];
    }

    /**
     * Handle errors.
     */
    public function onError(\Throwable $e)
    {
        Log::error('Import error: ' . $e->getMessage());
    }
}
