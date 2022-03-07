<?php

namespace Thettler\Botvel\Commands;

use Illuminate\Console\Command;

class BotvelCommand extends Command
{
    public $signature = 'botvel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
