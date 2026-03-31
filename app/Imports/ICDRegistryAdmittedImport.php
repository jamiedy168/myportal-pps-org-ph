<?php

namespace App\Imports;

use App\Models\RegistryAdmitted;
use App\Models\RegistryHeader;
use App\Models\ICD10;
use App\Models\ICD10Temp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;  // Optional, if you need to handle multiple sheets.

class ICDRegistryAdmittedImport implements ToModel, WithStartRow, SkipsOnError, WithValidation
{
    use SkipsErrors;

    protected $month_year_icd;
    protected $registry_id;

    public function __construct($month_year_icd, $registry_id)
    {
        $this->month_year_icd = $month_year_icd;
        $this->registry_id = $registry_id;
    }

    /**
     * Only process the first sheet (index 0).
     */
    public function sheets(): array
    {
        return [
            0 => $this, // Process only the first sheet (index 0)
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Check if critical columns are empty
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[4]) || empty($row[5])) {
                throw new \Exception('Critical cell is empty');
            }

            // Use raw data from the first sheet instead of calculated formulas
            // Here, we're just using the raw text data from the row for processing
            $icdCodes = [
                strtoupper($row[9]),
                strtoupper($row[11]),
                strtoupper($row[13]),
            ];

            // Check if ICD codes exist in either ICD10 or ICD10Temp
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

            return new RegistryAdmitted([
                'created_by' => auth()->user()->name,
                'is_active' => true,
                'patient_initial' => strtoupper($row[0]),
                'type_of_patient' => strtoupper($row[1]),
                'gender' => strtoupper($row[2]),
                'weight' => strtoupper($row[3]),
                'date_of_birth' => Date::excelToDateTimeObject($row[4]),
                'date_admitted' => Date::excelToDateTimeObject($row[5]),
                'date_discharged' => Date::excelToDateTimeObject($row[6]),
                'outcome' => strtoupper($row[7]),
                'primary_diagnosis' => strtoupper($row[8]),
                'icd_no' => strtoupper($row[9]),
                'secondary_diagnosis' => strtoupper($row[10]),
                'icd_no2' => strtoupper($row[11]),
                'tertiary_diagnosis' => strtoupper($row[12]),
                'icd_no3' => strtoupper($row[13]),
                'hospital_id' => auth()->user()->hospital_id,
                'month_year_icd' => $this->month_year_icd,
                'registry_header_id' => $this->registry_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            return null; // Skip row if there's any error (empty cell or other issues)
        }
    }

    /**
     * Skip the first row of the spreadsheet (header).
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Skipping the header row
    }

    /**
     * Validation rules (optional).
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Add your validation rules here if needed
        ];
    }

    /**
     * Handle errors (optional).
     */
    public function onError(\Throwable $e)
    {
        Log::error('Import error: ' . $e->getMessage());
    }
}

