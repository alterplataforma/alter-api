<?php

namespace Database\Seeders;

use App\Models\Cash\CashRetirement;
use App\Models\Cash\CashShipping;
use App\Models\Location\City;
use App\Models\Location\Departament;
use App\Models\NequiAccount;
use App\Models\Service\CategoryService;
use App\Models\Service\ItemAddiction;
use App\Models\Service\ItemDomicile;
use App\Models\Service\ItemExtra;
use App\Models\Service\PlaceItem;
use App\Models\Service\PlaceSchedule;
use App\Models\Service\Rate;
use App\Models\Service\Score;
use App\Models\Service\Service;
use App\Models\Service\ServiceAddress;
use App\Models\Service\Transaction;
use App\Models\Service\Vehicle;
use App\Models\Support\SupportAnswer;
use App\Models\Support\SupportTicket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        Departament::factory(32)->create();
        $this->call(CitySeeder::class);
        City::factory(200)->create();
        $this->call(UserSeeder::class);
        $this->call(RecomendationSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(ServiceTypeSeeder::class);
        $this->call(VehicleTypeSeeder::class);
        Vehicle::factory(10)->create();
        $this->call(AlterConfigurationSeeder::class);
        $this->call(ServiceStateSeeder::class);
        Service::factory(10)->create();
        $this->call(ServiceAddresOrderSeeder::class);
        ServiceAddress::factory(10)->create();
        $this->call(PlaceTypeSeeder::class);
        Score::factory(10)->create();
        NequiAccount::factory(10)->create();
        $this->call(SupportThemeSeeder::class);
        $this->call(FrequentQuestionSeeder::class);
        SupportTicket::factory(10)->create();
        SupportAnswer::factory(10)->create();
        $this->call(CashStateSeeder::class);
        CashShipping::factory(10)->create();
        CashRetirement::factory(10)->create();
        Transaction::factory(10)->create();
        $this->call(BannerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PlaceSeeder::class);
        CategoryService::factory(10)->create();
        PlaceItem::factory(10)->create();
        $this->call(PlaceScheduleSeeder::class);
        $this->call(RateTypeSeeder::class);
        Rate::factory(20)->create();
        ItemExtra::factory(10)->create();
        ItemAddiction::factory(10)->create();
        ItemDomicile::factory(10)->create();
    }
}
