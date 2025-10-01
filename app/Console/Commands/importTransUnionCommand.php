<?php

namespace App\Console\Commands;

use AllowDynamicProperties;
use App\Jobs\TransUnionImportJob;
use App\Models\codes_and_descriptions;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Spatie\SimpleExcel\SimpleExcelReader;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

#[AllowDynamicProperties] class importTransUnionCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'import:trans-union {file : The path to the import file} {delimiter=,}';

    protected $description = 'Import Data from Transunion';

    public ProgressBar $progressBar;

    public function handle()
    {
        $filename = $this->argument('file');
        $delimiter = $this->argument('delimiter');
        if (!file_exists($filename)) {
            $this->error('File does not exist!');
            return false;
        }

        $start = now();
        $this->warn('Start: ' . $start);

        $rowCount = SimpleExcelReader::create($filename)->headersToSnakeCase()->getRows()->count();
        $this->warn('Count: ' . $rowCount);
        $output = new ConsoleOutput();
        $this->progressBar = new ProgressBar($output, $rowCount);
        $this->progressBar->start();

        SimpleExcelReader::create($filename)->headersToSnakeCase()->getRows()->chunk(1000)
            ->each(function ($rows) {
                foreach ($rows as $row) {
                    $cleanedRow = json_encode($this->cleanRow($row));
//                    codes_and_descriptions::firstOrCreate($cleanedRow);
                    TransUnionImportJob::dispatch($cleanedRow);
                    $this->progressBar->advance();
                }
            });

        $this->progressBar->finish();
        $end = now();
        $this->newLine();
        $this->warn('Start: ' . $start . ' End: ' . $end);
        $this->warn('Duration in Seconds: ' . Carbon::parse($start)->diffInSeconds($end));
    }
    private function cleanRow($row)
    {
        foreach ($row as $key => $value) {
            if (is_string($value)) {
                $row[$key] = $this->cleanString($value);
            }
        }
        return $row;
    }

// Define the function to clean each string
    private function cleanString($inputString): array|string|null
    {
        // Replace non-breaking spaces with regular spaces
        $cleanedString = str_replace("\xA0", ' ', $inputString);
        // Remove any other non-printable characters
        return preg_replace('/[^\x20-\x7E]/', '', $cleanedString);
    }
}
