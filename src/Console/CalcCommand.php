<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 06.09.2018
 * Time: 22:30
 */

namespace Zergbz1988\Calc\Console;

use Illuminate\Console\Command;
use Zergbz1988\Calc\Interfaces\Calc;

/**
 * Class CalcCommand
 * @package Zergbz1988\Calc\Commands
 */
class CalcCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:run {input}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates user\'s expression';

    /**
     * calc service.
     *
     * @var Calc
     */
    protected $calc;

    /**
     * Create a new command instance.
     *
     * @param  Calc $calc
     * @return void
     */
    public function __construct(Calc $calc)
    {
        parent::__construct();

        $this->calc = $calc;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $calcResult = $this->calc->getCalcResult($this->argument('input'));

        return response()->json([
            'status' => $calcResult->getStatus(),
            'message' => $calcResult->getMessage()
        ]);
    }

}