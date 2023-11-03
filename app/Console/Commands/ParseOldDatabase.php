<?php

namespace App\Console\Commands;

use App\Jobs\AttributeValueImport;
use App\Jobs\CategoriesImport;
use App\Jobs\ImportJobs\AttributesImport;
use App\Jobs\ProductsImport;
use App\Jobs\UsersImport;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class ParseOldDatabase extends Command
{
    const ATTRIBUTE_TABLE = 'nv_main_filtr';
    const ATTRIBUTE_VALUE_TABLE = 'nv_filtres';
    const USERS_TABLE = 'users';
    const CATEGORIES_TABLE = 'nv_catlist';
    const PRODUCTS_TABLE = 'nv_product';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:parse-old';

    protected Connection $connection;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        ini_set('memory_limit', -1);
        parent::__construct();
        $this->connection = DB::connection('mysql_old');
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->parseAttributes();
        $this->parseUsers();
        $this->parseCategories();
        $this->parseProducts();
    }

    protected function parseProducts(): void
    {
        $this->connection->table(self::PRODUCTS_TABLE)->chunk(3000, function ($products) {
            ProductsImport::dispatch($products);
        });
    }

    protected function parseCategories(): void
    {
        CategoriesImport::dispatch($this->connection->table(self::CATEGORIES_TABLE)->get());
    }

    protected function parseUsers(): void
    {
        $this->connection->table(self::USERS_TABLE)->chunk(5000, function ($users) {
            UsersImport::dispatch($users);
        });
    }

    protected function parseAttributes(): void
    {
        $this->connection->table(self::ATTRIBUTE_TABLE)->chunk(5000, function ($attributes) {
            AttributesImport::dispatch($attributes);
        });

        $this->connection->table(self::ATTRIBUTE_VALUE_TABLE)->chunk(5000, function ($attributeValue) {
            AttributeValueImport::dispatch($attributeValue);
        });
    }
}
