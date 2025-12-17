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
            Schema::table('collections', function (Blueprint $table) {
                $table->dropColumn(['show_in_homepage', 'is_visible_on_landing']);
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('collections', function (Blueprint $table) {
                $table->boolean('show_in_homepage')->default(false)->after('is_active');
                $table->boolean('is_visible_on_landing')->default(true)->after('show_in_homepage');
            });
        }
    };
