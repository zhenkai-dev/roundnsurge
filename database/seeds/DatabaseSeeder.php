<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolePermissionsTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        //$this->call(MembersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PageTranslationsTableSeeder::class);
        $this->call(FriendlyUrlsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MenuTranslationsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);

        $this->call(PackagesTableSeeder::class);
        $this->call(PackageTranslationsTableSeeder::class);
    }
}
