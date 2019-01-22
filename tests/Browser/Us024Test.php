<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class Us024Test extends DuskTestCase
{
    public function testShowItemOK()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/item')
                    ->waitForText('Itens')
                    ->assertSee('00293631781094524893')
                    ->assertSee('02/01/2019')
                    ->assertSee('Homem-Aranha no Aranhaverso')
                    ->assertSee('HD-DVD');
        });
    }

    public function testShowItemForbidden()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit('/item')
                    ->assertSee('Acesso Negado.');
        });
    }
}
