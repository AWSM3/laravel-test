<?php
declare(strict_types=1);

/** @uses */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\MailingStatus;

/**
 * Class CreateMailingStatusesTable
 */
class CreateMailingStatusesTable extends Migration
{
    const
        TABLE_NAME = 'mailing_statuses',

        STATUSES = [
            MailingStatus::STATUS_FAIL,
            MailingStatus::STATUS_SUCCESS,
        ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('id', 60)->comment('UUID');
            $table->string('task', 60)->comment('Task id');
            $table->string('email', 255)
                  ->comment('Email');
            $table->enum('status', self::STATUSES)
                  ->comment('Sending status');

            $table->primary('id');
            $table->foreign('task')
                  ->references('id')->on(CreateMailingTasksTable::TABLE_NAME)
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
