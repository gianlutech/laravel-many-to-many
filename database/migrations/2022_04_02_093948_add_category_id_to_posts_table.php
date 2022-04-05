<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Aggiungo la colonna 
            //$table->unsignedBigInteger('category_id')->nullable()->after('id');
            //Dichiaro che è foreign key
            //$table->foreign('category_id')->reference('id')->on('categories')->onDelete('set null');
            $table->foreignId('category_id')->after('id')->nullable()->onDelete('set null')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Elimino il vincolo (constraint)
            $table->dropForeign('posts_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
