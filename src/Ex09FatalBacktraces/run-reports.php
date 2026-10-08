<?php

declare(strict_types=1);

/**
 * EXERCISE 09: Backtraces for fatal errors - a bug hunt
 * (PHP 8.5)
 *
 * PROBLEM
 *   This nightly job prints three reports. Tonight it died with a fatal
 *   error. Fatal errors (memory limit, time limit, ...) are not exceptions:
 *   until PHP 8.5 all they told you was the line that happened to be running
 *   when PHP gave up, without any hint how the program got there.
 *
 * TASK
 *   1. Run the job the way PHP 8.4 would have reported the problem:
 *
 *        make shell
 *        php -d fatal_error_backtraces=0 src/Ex09FatalBacktraces/run-reports.php
 *
 *      Which report is broken? Which value is wrong? Can you tell?
 *
 *   2. Run it again with the PHP 8.5 default:
 *
 *        php src/Ex09FatalBacktraces/run-reports.php
 *
 *      Read the stack trace from top to bottom, arguments included.
 *      Where does the suspicious number come from?
 *
 *   3. Fix the bug at its origin so that all three reports are printed.
 *
 * CONSTRAINTS
 *   - Do not change this file or TextTable.php. The line named in the error
 *     message is not where the bug is.
 *   - Do not raise the memory limit.
 *
 * TO DISCUSS
 *   - The trace prints arguments. What about passwords and API keys?
 *     (See #[\SensitiveParameter] from PHP 8.2 and the ini settings
 *     fatal_error_backtraces and zend.exception_ignore_args.)
 *
 * VERIFY
 *   make test ex=09
 */

use Workshop\Ex09FatalBacktraces\Report;

require __DIR__ . '/../../bootstrap.php';

ini_set('memory_limit', '64M');

$reports = [
    new Report('Customers', ['Id', 'Name', 'City'], [
        [1, 'Ada Lovelace', 'London'],
        [2, 'Grace Hopper', 'New York'],
        [3, 'Konrad Zuse', 'Berlin'],
    ]),
    new Report('Orders', ['Order', 'Customer', 'Items', 'Total'], [
        ['2025-0041', 'Grace Hopper', 3, '149.70 EUR'],
        ['2025-0042', 'Ada Lovelace', 1, '49.90 EUR'],
        ['2025-0043', 'Konrad Zuse', 12, '1,038.00 EUR'],
    ]),
    new Report('Inventory', ['Product', 'EAN', 'Stock'], [
        ['Keyboard', 4006381333931, 12],
        ['Mouse', 4012345678901, 0],
        ['Monitor', 4260123456788, 3],
    ]),
];

// Nothing is printed before all reports are ready, so the output gives no
// clue about how far the job got.
$output = '';
foreach ($reports as $report) {
    $output .= $report->render() . PHP_EOL;
}

echo $output;
