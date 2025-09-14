<?php

namespace Luna\Commands;

use Illuminate\Console\Command;

class LunaCommand extends Command
{
    public $signature = 'luna-panel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
