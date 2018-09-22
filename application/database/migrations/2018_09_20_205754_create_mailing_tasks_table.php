<?php
declare(strict_types=1);

/** @uses */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMailingTasksTable
 */
class CreateMailingTasksTable extends Migration
{
    const TABLE_NAME = 'mailing_tasks';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('id')
                  ->comment('UUID');
            $table->string('hash', 32)
                  ->comment('MD5 hash of file');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
