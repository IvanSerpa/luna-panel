<?php

namespace LunaPanel\Commands;

use Illuminate\Console\Command;

class LunaPanelCommand extends Command
{
    public $signature = 'luna-panel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
