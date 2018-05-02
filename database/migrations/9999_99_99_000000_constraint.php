<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Constraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users');
        });

        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('user_permissions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('page_translations', function (Blueprint $table) {
            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('language_id')->references('id')->on('languages');
        });

        Schema::table('menu_translations', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('language_id')->references('id')->on('languages');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('menus');
            $table->foreign('url_id')->references('id')->on('friendly_urls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
        });

        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['role_id']);
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('user_permissions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::table('menu_translations', function (Blueprint $table) {
            $table->dropForeign('menu_id');
            $table->dropForeign('language_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign('parent_id');
            $table->dropForeign('url_id');
        });
    }
}
