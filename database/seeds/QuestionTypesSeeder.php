<?php

use Illuminate\Database\Seeder;

class QuestionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @access public
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('question_types')->delete();
        Schema::enableForeignKeyConstraints();

        DB::table('question_types')->insert([
            [
                'id' => 1,
                'alias' => 'text',
                'name' => 'Ligne de texte',
                'has_options' => 0,
                'allow_multiple' => 0,
            ],
            [
                'id' => 2,
                'alias' => 'textarea',
                'name' => 'Zone de texte (plusieurs lignes)',
                'has_options' => 0,
                'allow_multiple' => 0,
            ],
            [
                'id' => 3,
                'alias' => 'dropdown',
                'name' => 'Menu déroulant (choix unique)',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
            [
                'id' => 4,
                'alias' => 'dropdown_multiple',
                'name' => 'Menu déroulant (choix multiples)',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 5,
                'alias' => 'checkbox',
                'name' => 'Cases à cocher (choix multiples)',
                'has_options' => 1,
                'allow_multiple' => 1,
            ],
            [
                'id' => 6,
                'alias' => 'radio',
                'name' => 'Radio input',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
            [
                'id' => 7,
                'alias' => 'datalist',
                'name' => 'Ligne de texte avec propositions',
                'has_options' => 1,
                'allow_multiple' => 0,
            ],
        ]);
    }
}
