<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            //data and privacy related fields
            $table->boolean('is_data_shared')->default(false)->comment('Indicates if the vendor has consented to share their data');
            $table->boolean('is_analytics_shared')->default(false);
            $table->boolean('is_marketing_shared')->default(false);

            //notification preferences 
            $table->boolean('is_email_notifications')->default(false);
            $table->boolean('is_push_notifications')->default(false);
            $table->boolean('is_marketing_notifications')->default(false);

            //alert types 
            $table->boolean('is_critical_alerts')->default(false);
            $table->boolean('is_performance_updates')->default(false);
            $table->boolean('is_weekly_reports')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
