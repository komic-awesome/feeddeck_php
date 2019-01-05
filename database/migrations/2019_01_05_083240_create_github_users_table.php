<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGithubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_in_github')->comment('Github Id');
            $table->string('name')->comment('The user\'s public profile name.');
            $table->string('login')->comment('The username used to login. ');
            $table->string('email')->comment('The user\'s publicly visible profile email. ');
            $table->string('location')->comment('The user\'s public profile location. ');
            $table->string('website_url')->comment('A URL pointing to the user\'s public website/blog.');
            $table->string('url')->comment('The HTTP URL for this user ');
            $table->text('company')->comment('The user\'s public profile company.');
            $table->text('company_html')->comment('The user\'s public profile company as HTML.');
            $table->string('database_id_in_github')->comment('Identifies the primary key from the database. ');
            $table->string('avatar_url')->comment('A URL pointing to the user\'s public avatar. ');
            $table->text('bio')->comment('The user\'s public profile bio.');
            $table->text('bio_html')->comment('The user\'s public profile bio as HTML.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('github_users');
    }
}
