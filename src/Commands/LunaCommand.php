<?php

namespace Luna\Commands;

use Illuminate\Console\Command;

class LunaCommand extends Command
{
    protected $name = 'luna:hello';

    protected $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
