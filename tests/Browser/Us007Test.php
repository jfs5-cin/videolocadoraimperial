<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class Us007Test extends DuskTestCase
{

    public static $texto = "
    O vídeo fornece uma maneira poderosa de ajudá-lo a provar seu argumento. 
    Ao clicar em Vídeo Online, você pode colar o código de inserção do vídeo que deseja adicionar. 
    Você também pode digitar uma palavra-chave para pesquisar online o vídeo mais adequado ao seu documento. 
    Para dar ao documento uma aparência profissional, o Word fornece designs de cabeçalho, rodapé, 
    folha de rosto e caixa de texto que se complementam entre si. 
    Por exemplo, você pode adicionar uma folha de rosto, um cabeçalho e uma barra lateral correspondentes. 
    Clique em Inserir e escolha os elementos desejados nas diferentes galerias. 
    Temas e estilos também ajudam a manter seu documento coordenado. 
    Quando você clica em Design e escolhe um novo tema, as imagens, gráficos e elementos gráficos SmartArt 
    são alterados para corresponder ao novo tema. 
    ";

    /**
     * A Dusk test example.
     *
     * @return void
     */
    
    public function testEditGenreBtn()
    {
        $this->browse(function (Browser $browser) {
            $href = route('genre.edit', 20);
            $browser->loginAs(User::find(1))
                    ->visit('/genero')
                    ->waitForText('Gêneros')
                    ->click("a[href='$href']")
                    ->waitForText('Modificar Gênero')
                    ->assertPathIs('/genero/20/editar');
        });
    }

    public function testEditGenreOK()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/genero/20/editar')
                    ->waitForText('Modificar Gênero')
                    ->type('tmdb_id', '2')
                    ->type('description', 'Esporte')
                    ->click('button[type=submit]')
                    ->waitForText('Adicionar Gênero')
                    ->assertPathIs('/genero');
        });
        $this->assertDatabaseHas('genres', 
        [
            'tmdb_id' => 2,
            'description' => 'Esporte',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/genero/20/editar')
                    ->waitForText('Modificar Gênero')
                    ->type('tmdb_id', '2')
                    ->type('description', 'Heróis')
                    ->click('button[type=submit]')
                    ->waitForText('Adicionar Gênero')
                    ->assertPathIs('/genero');
        });
        $this->assertDatabaseHas('genres', 
        [
            'tmdb_id' => 2,
            'description' => 'Heróis',
        ]);
    }

    public function testEditGenreFail()
    {
        $this->browse(function (Browser $browser) {
            $texto = Us007Test::$texto;
            $browser->loginAs(User::find(1))
                    ->visit('/genero/20/editar')
                    ->waitForText('Modificar Gênero')
                    ->type('tmdb_id', '')
                    ->type('description', '')
                    ->click('button[type=submit]')
                    ->waitForText('Modificar Gênero')
                    ->assertSee('O campo código TMDb é obrigatório.')
                    ->assertSee('O campo descrição é obrigatório.')
                    ->type('tmdb_id', '0')
                    ->type('description', $texto)
                    ->click('button[type=submit]')
                    ->waitForText('Modificar Gênero')
                    ->assertSee('O código TMDb tem que ser maior que 0.')
                    ->assertSee('O campo descrição não pode ser superior a 255 caracteres.')
                    ->type('tmdb_id', '28')
                    ->type('description', 'Ação')
                    ->click('button[type=submit]')
                    ->waitForText('Modificar Gênero')
                    ->assertSee('O campo código TMDb já está sendo utilizado.')
                    ->assertSee('O campo descrição já está sendo utilizado.');
        });
        $this->assertDatabaseMissing('genres', 
        [
            'tmdb_id' => '',
            'description' => '',
        ]);
        
        $this->assertDatabaseMissing('genres', 
        [
            'tmdb_id' => 0,
            'description' => Us002Test::$texto,
        ]);
        
        $this->assertDatabaseMissing('genres', 
        [
            'tmdb_id' => 'A',
            'description' => 'Steaming Digital',
        ]);
    }

    public function testEditGenreForbidden()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit('/genero/20/editar')
                    ->assertSee('Acesso Negado.');
        });
    }

}
