<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //forma de deixar opcional colocando um ? depois da variavel, title?
    protected $signature = 'app:create-product-command {title?} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle():void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if(!$user) {
            $user = $this->components->ask('Please, provide a valid user id');
        }

        // as duas opções são validas mas o Laravel esta utilizando mais o $this->components->ask();
        if (!$title) {
            $title = $this->ask('Plese, provide a title for the product');
        }

        Product::query()->create([
            'title' => $title,
            'owner_id' => $user
        ]);

        //Informação que coloca após o camando ter sido rodado

        $this->components->info('Product created!!');

    }
}
