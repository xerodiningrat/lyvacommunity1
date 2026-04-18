<?php

namespace App\Console\Commands;

use App\Services\DiscordGallery;
use Illuminate\Console\Command;

class SyncDiscordGalleryMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lyva:sync-discord-gallery {--force : Force refresh from Discord}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Discord gallery media metadata into the local database';

    /**
     * Execute the console command.
     */
    public function handle(DiscordGallery $discordGallery): int
    {
        $count = $discordGallery->sync((bool) $this->option('force'));

        $this->info("Discord gallery synced. Stored media: {$count}");

        return self::SUCCESS;
    }
}
