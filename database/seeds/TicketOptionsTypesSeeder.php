<?php

use Illuminate\Database\Seeder;

class TicketOptionsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ticket_options_types')->delete();
        Schema::enableForeignKeyConstraints();

        DB::table('ticket_options_types')->insert([
            [
                'id' => 1,
                'alias' => 'dropdown',
                'name' => 'Menu déroulant (choix unique)',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
            [
                'id' => 2,
                'alias' => 'dropdown_multiple',
                'name' => 'Menu déroulant (choix multiples)',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 3,
                'alias' => 'checkbox',
                'name' => 'Cases à cocher (choix multiples)',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 4,
                'alias' => 'radio',
                'name' => 'Cases à cocher (choix unique)',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
        ]);
    }
}
