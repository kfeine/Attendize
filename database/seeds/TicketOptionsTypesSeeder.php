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
                'name' => 'Dropdown (single selection)',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
            [
                'id' => 2,
                'alias' => 'dropdown_multiple',
                'name' => 'Dropdown (multiple selection)',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 3,
                'alias' => 'checkbox',
                'name' => 'Checkbox',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 4,
                'alias' => 'radio',
                'name' => 'Radio input',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
        ]);
    }
}
