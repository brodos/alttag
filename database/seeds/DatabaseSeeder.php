<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->create([
        	'name' => 'Lucian',
            'email' => 'mm@mm.mm',
            'password' => bcrypt('secret'),
        ]);

        $site = $user->sites()->create(factory(App\Site::class)->raw([
            'uuid' => Str::uuid(),
            'url' => 'https://burgervan.ro/',
            'url_hash' => md5('https://burgervan.ro/'),
            'display_name' => 'BurgerVan',
            'slug' => str_slug('BurgerVan'),
            'domain' => 'burgervan.ro',
            'crawl' => 1,
            'process' => 1,
        ]));

        $site->urls()->create(factory(App\Url::class)->raw([
            'url' => $site->url,
            'url_hash' => md5($site->url),
        ]));
    }
}
