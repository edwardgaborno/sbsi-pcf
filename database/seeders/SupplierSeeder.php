<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            'ABD',
            'ADVANCED PRACTICAL DIAGNOSTICS bvba',
            'AHN',
            'AMS',
            'APACOR',
            'AUTOBIO',
            'BIOBASE',
            'Bioscience',
            'BIOTEK',
            'BIOTRUNE',
            'CAPP',
            'CARETIUM',
            'COGS',
            'DDK',
            'DIA.PRO',
            'DIAGEM MEDICAL SUPPLY',
            'DIAMON DIAGNOSTICS, INC',
            'DIESSE',
            'DL BIOTECH',
            'DYNEX',
            'EXIAS',
            'FRESENIUS KABI',
            'GOLDSITE',
            'Grepcor',
            'GRIFOLS',
            'HAIMEN',
            'HORIBA ABX',
            'HORIBA STEC',
            'IDDL',
            'IRON WILL',
            'LDN',
            'LIOFILCHEM',
            'Marsman',
            'Medicon Hellas SA',
            'MedTest',
            'NOVATEC',
            'OMNIBUS',
            'OPTIMED',
            'OTHERS',
            'Rayto',
            'Rayto life and Analytical Sciences Co., Ltd',
            'Reactifs RAL',
            'SARSTEDT Aktiengesellchaft & Co.',
            'SBSI',
            'Sebia',
            'SIGMATECH',
            'SIMPORT',
            'STAGO',
            'TCOAG',
            'Thermo Fisher',
            'Unimed',
            "UNION CLINBIO LAB INT'L COL., LTD",
            'Werfen',
            'ZENTECH',
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'supplier_name' => $supplier
            ]);
        }
    }
}
