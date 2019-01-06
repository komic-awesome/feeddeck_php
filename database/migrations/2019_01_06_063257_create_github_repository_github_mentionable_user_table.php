<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGithubRepositoryGithubMentionableUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_repository_github_mentionable_user', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('github_repository_id')
                  ->unsigned();

            $table->integer('github_user_id')
                  ->unsigned();

            $table->foreign('github_repository_id')
                  ->references('id')
                  ->on('github_repositories')
                  ->onDelete('cascade');

            $table->foreign('github_user_id')
                  ->references('id')
                  ->on('github_users')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('github_repository_github_mentionable_user');
    }
}
