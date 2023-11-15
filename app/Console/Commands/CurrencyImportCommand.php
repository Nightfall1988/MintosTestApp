<?php

namespace App\Console\Commands;
use App\Http\Services\Currencies\Import\ImportCurrenciesService;
use Illuminate\Console\Command;

class CurrencyImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import currency from source bank.lv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImportCurrenciesService $importCurrenciesService)
    {
        parent::__construct();
        $this->importCurrenciesService = $importCurrenciesService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->importCurrenciesService->execute();
        return 0;
    }
}
