<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class xsIndexer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xs:indexer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate bookInfo database\'s indexer';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = config('database.connections.mysql');
        $con = 'pdo.mysql://' .
            $database['username'] . ':' .
            $database['password'] . '@' .
            $database['host'] . ':' .
            $database['port'] . '/' .
            $database['database'];

        $command = base_path('vendor/hightman/xunsearch/util/Indexer.php') .
            ' --rebuild' .
            ' --project="' . config_path('book.ini') . '"' .
            ' --source="' . $con . '"' .
            ' --sql="SELECT book_info.id, title, isbn, publish_house, name_cn, name_en FROM book_info, book_author WHERE book_info.author_id = book_author.id"';

        exec($command, $outputs);

        foreach ($outputs as $output) {
            $this->line($output);
        }
        die;
    }
}
