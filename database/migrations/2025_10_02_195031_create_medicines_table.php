<?php

use App\Models\Pharmacy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('brand_names')->nullable();
            $table->string('active_ingredient')->nullable();
            $table->string('strength')->nullable();
            $table->string('strength_unit')->nullable();
            $table->string('manufacturer')->nullable();
            $table->foreignIdFor(Pharmacy::class)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};
